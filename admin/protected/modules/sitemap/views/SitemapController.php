<?php

class SitemapController extends FrontController {
    public $sitemapXml='';
    public $types = array();
    public $host = '';
	
	public function __construct() {
		parent::__construct();
	}
    
    public function start($meta) {
		parent::start($meta);
	}
     
	public function filters() {
		return array (
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules() {
		return array (
			array (
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index'),
				'users' => array('*'),
			),
		);
	}

    public function actionIndex() {
        $this->host = Yii::app()->request->hostInfo;
        
        $types = MaterialType::model()->getTypes();
        $this->types = $types;
        
        $on_sitemap_types = MaterialType::model()->getTypesSitemap();
        $materials = Material::model()->TreeBehavior->getTreeData();
        $menu = $this->getMenuTree($materials, $on_sitemap_types);     
		
		$this->render('index', array(
            'data' => $this->getXml($menu)
        ));
    }
    
    public function getXml($menu, $result = '') {
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
    
    public function materialXml($menu, $type){       
        $result[] = array('name' => $menu['name'], 'url' => $this->host . $menu['url']);  
		return $result;
    }
    
    public function catalogXml($menu, $type){
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
    public function articleXml($menu, $type){
        Yii::import('application.modules.articles.models.*');
        $result = $this->itemXml('Article');
        $categories = ArticleCategory::model()->getTreeData();
        $result = array_merge($result, $this->categoryXmlTree($categories, 'Article'));
        
		return $result;
    }
    
    public function newsXml($menu, $type){
        Yii::import('application.modules.news.models.*');
        $result = $this->itemXml('News', false);
		
		return $result;
    }
    
    public function galleryXml($menu, $type){
        Yii::import('application.modules.gallery.models.*');
        $categories = Gallery::model()->getTreeData();
        $result = $this->categoryXmlTree($categories);
		
		return $result;
    }
    
    
    public function itemXml($class = '', $category = true){
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
    public function categoryXmlTree($tree, $class = ''){        
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
    
    public function getViewPath() {
        $controllername = $this->getId();
        $newPath = "webroot.templates.sitemap";
        $newPath = YiiBase::getPathOfAlias($newPath);
        return $newPath;
    }
    
    
    public function getMenuTree($materials, $sitemap, $result = array()){
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
