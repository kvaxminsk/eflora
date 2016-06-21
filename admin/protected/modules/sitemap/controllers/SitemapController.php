<?php

class SitemapController extends FrontController {
    public $types = array();
    public $host = '';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getViewPath() {
        $controllername = $this->getId();
        $newPath = "webroot.templates.sitemap";
        $newPath = YiiBase::getPathOfAlias($newPath);
        return $newPath;
    }

    public function actionIndex() {
        $this->host = Yii::app()->request->hostInfo;
        
        $types = MaterialType::model()->getTypes();
        $this->types = $types;
        
        $on_sitemap_types = MaterialType::model()->getTypesSitemap();
        $materials = Material::model()->TreeBehavior->getTreeData();
        $menu = $this->getMenuTree($materials, $on_sitemap_types);    
		
		$tree = $this->getXml($menu);
		
		$fileContent = $this->XmlFileRender($menu);
		file_put_contents(HOME . '/sitemap.xml', $fileContent);
		
		$this->render('index', array(
            'data' => $tree,
			'host' => $this->host
        ));
    }
    
	private function XmlFileRender($tree) {
		foreach ($tree as $v) {
			$body .= "<url>\n<loc>" . $v['url'] . "</loc>\n</url>\n";
		}
		
		$fileContent = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n<!-- Created by SM.CMS (http://sitemania.by/) -->\n". $body . "</urlset>";
		
		return $fileContent;
	}
	
    private function getXml($menu, $result = '') {
		$result = [];
        foreach($menu as $i => $m){
            $menu_type = $this->types[$m['type_id']]['module'];
            $result = array_merge($result, $this->materialXml($m, $menu_type)); 
            switch($menu_type){
                case 'catalog':
                    $result = array_merge($result, $this->catalogXml($m, $this->types[$m['type_id']]));
                    break;
                case 'articles':
                    $result = array_merge($result, $this->articleXml($m, $this->types[$m['type_id']]));
                    break;
                case 'news':
                    $result = array_merge($result, $this->newsXml($m, $this->types[$m['type_id']]));
                    break;
                case 'gallery':
                    $result = array_merge($result, $this->galleryXml($m, $this->types[$m['type_id']]));
                    break;
            }
        }
		return $result;
    }
    
    private function materialXml($menu, $type){       
        $result[] = array('name' => $menu['name'], 'url' => $this->host . $menu['url']);  
		return $result;
    }
    
    private function catalogXml($menu, $type){
        Yii::import('application.modules.catalog.models.*');
        switch($type['action']){
            case 'index':
                $result = $this->itemXml('Product');
                $categories = Category::model()->getTreeData();
                $result = array_merge($result, $this->categoryXmlTree($categories, 'Product'));
                break;
            case 'brands':
                $criteria = new CDbCriteria;
        		$criteria->addCondition('t.active=1');
        		$criteria->order = "t.order ASC, t.name ASC";
                $criteria->with = 'metatag';
                $brands = Subjects::model()->findAll($criteria);
                foreach($brands as $i => $br){
                     $result[] = array('name' => $br['name'], 'url' => $this->host . $br['url']);  
                }
                break;
        }
		
		return $result;
    }
    private function articleXml($menu, $type){
        Yii::import('application.modules.articles.models.*');
        $result = $this->itemXml('Article');
        $categories = ArticleCategory::model()->getTreeData();
        $result = array_merge($result, $this->categoryXmlTree($categories, 'Article'));
        
		return $result;
    }
    
    private function newsXml($menu, $type){
        Yii::import('application.modules.news.models.*');
        $result = $this->itemXml('News', false);
		
		return $result;
    }
    
    private function galleryXml($menu, $type){
        Yii::import('application.modules.gallery.models.*');
        $categories = Gallery::model()->getTreeData();
        $result = $this->categoryXmlTree($categories);
		
		return $result;
    }
    
    
    private function itemXml($class = '', $category = true){
        if($class != ''){    
            $criteria = new CDbCriteria;
            $criteria->compare('t.active', 1);
            if($category){
                $criteria->compare('category_id', 0);
            }
        	$criteria->order = "t.order ASC, t.name ASC";
            $criteria->with = 'metatag';
            $items = $class::model()->findAll($criteria);
            if(!empty($items)){
                foreach($items as $k => $it){
                     $result[] = array('name' => $it['name'], 'url' => $this->host . $it['url']);  
                }
            }
        }
		return $result;
    }
    private function categoryXmlTree($tree, $class = ''){        
        foreach($tree as $i => $t){
            if($t['active'] == 0)
                continue;
            
            $result[] = array('name' => $t['name'], 'url' => $this->host . $t['url']);    
            
            if ($class != '')
            {
                $criteria = new CDbCriteria;
        		$criteria->addCondition('t.active=1 AND category_id=' . $t['id']);
        		$criteria->order = "t.order ASC, t.name ASC";
                $criteria->with = 'metatag';
                $items = array();
                $items = $class::model()->findAll($criteria);
                if(!empty($items)){
                    foreach($items as $k => $it){
						$result[] = array('name' => $it['name'], 'url' => $this->host . $it['url']);  
                    }
                }
            }
            
            if(!empty($t['children'])){
                $result = array_merge($result, $this->categoryXmlTree($t['children']));
            }
        }
		return $result;
    }    
    
    private function getMenuTree($materials, $sitemap, $result = array()){
        foreach ($materials as $k => $v){
            if(($v['active']) && (in_array($v['type_id'], $sitemap))){
                $result[$k] = $v;
                unset($result[$k]['children']);
                unset($result[$k]['parent']);   
            }
            if(!empty($v['children'])){
                $result[$k]['children'] = $this->getMenuTree($v['children'], $ids, $result);
            }
        }
        return $result;
    }
}
