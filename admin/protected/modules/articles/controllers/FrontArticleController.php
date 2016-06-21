<?php

class FrontArticleController extends FrontController
{  
    #количество товаров на страницу
    CONST PAGE = 10;
    
    public $conditions = array();
    
    public function start($meta)
	{
	    $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=2');
        
        $material = Material::model()->with('metatag')->find($criteria);
        if(!empty($material)){
            $urlroot = '/'. $material->metatag->uri. '/' . $material->metatag->alias;
            $urlroot = str_replace('//', '/', $urlroot);
            $this->urlroot = $urlroot; 
            $this->breadcrumbs[] = array(
                'meta_id'   => $material->metatag->id,
                'name'      => $material->name,
                'url'       => $urlroot, 
            ); 
        }
	}
    
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','article', 'category'),
				'users'=>array('*'),
			),
		);
	}
    
    public function actionIndex($alias, $meta){
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
        
 
        $criteria=new CDbCriteria;
		$criteria->addCondition('t.active=1');
		$criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';
        
        
        $count = Article::model()->count($criteria);
        
        $pages=new CPagination($count);
        $pages->pageSize = self::PAGE;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];
    
	    $articles = new CActiveDataProvider('Article', array(
	        'pagination' => array(
	            'pageSize' => self::PAGE,
	            'pageVar' => 'page',
	        ),
	        'criteria' => $criteria,
	    ));
        
        $criteria=new CDbCriteria;
		$criteria->addCondition('t.active=1');
        $criteria->addCondition('t.parent_id=0');
		$criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';
        $categories = ArticleCategory::model()->findAll($criteria);
                
        $this->render('index', array(
	       'model'         => $model,
           'meta'          => $meta,
           'articles'      => $articles,
           'pages'         => $pages,
           'categories'    => $categories 
        ));  
    }
    
    public function actionArticle($alias, $meta){
        $criteria=new CDbCriteria;
        $criteria->addCondition('t.meta_id=' . $meta->id);		
        $model = Article::model()->find($criteria);
  
        
        if($model->category_id > 0){
            $brc_category = self::metaCategory($model->category_id);
            $brc_category = array_reverse($brc_category);
            $this->breadcrumbs = array_merge($this->breadcrumbs, $brc_category);
        }
        if(!empty($meta)){
            $url = $this->urlroot . '/' . $meta->uri . '/' . $meta->alias;
            $url = str_replace('//', '/', $url); 
            $this->breadcrumbs[] = array(
                'meta_id'   => $meta->id,
                'name'      => $model->name,
                'url'       => $url, 
            );
        }
        
        
        parent::meta($model, $meta);
        
        $linkcat = $model['url'];
        $linkcat = explode('/', $linkcat);
        unset($linkcat[count($linkcat)-1]);
        $linkcat = implode('/', $linkcat);
        
        $this->render('article',array(
	       'model'     => $model,
           'meta'      => $meta,
           'linkcat'   => $linkcat 
        ));  
    }
    
    /**
     *  страница категории  
     **/
    public function actionCategory($alias, $meta){
        $model = ArticleCategory::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        $brc_category = self::metaCategory($model->id);
        $brc_category = array_reverse($brc_category);
        $this->breadcrumbs = array_merge($this->breadcrumbs, $brc_category);
        
        parent::meta($model, $meta);
        
        $categories = array();
        $categories[] = $model->id;
        
        $sub_categories = ArticleCategory::getChildsId($model->id);
        if(!empty($sub_categories))
            $categories = array_merge($categories, $sub_categories);
        
        
        $this->conditions['addInCondition'][] = array('category_id', $categories);
        
        list($articles, $pages) = $this->getArticles();
        
        $criteria = new CDbCriteria;        
        $criteria->addCondition('t.active=1');
		$criteria->addCondition('t.parent_id=' . $model->id);
		$criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';
        
        $subcategories = ArticleCategory::model()->findAll($criteria);
                        
        $this->render('category',array(
	       'model'             => $model,
           'meta'              => $meta,
           'articles'          => $articles,
           'pages'             => $pages,
           'subcategories'     => $subcategories 
          
        ));  
    }



	public function getViewPath() {
                $controllername = $this->getId();
                $newPath = "webroot.templates.articles";
                $newPath = YiiBase::getPathOfAlias($newPath);
                return $newPath;
    }
    
    public function metaCategory($id , $result = array()){
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('t.id=' . $id);    
        $criteria->with = 'metatag';
        
        $category = ArticleCategory::model()->find($criteria);
        if(!empty($category)){
            $url = $this->urlroot . '/' . $category->metatag->uri . '/' . $category->metatag->alias;
            $url = str_replace('//', '/', $url); 
            $result[] = array(
                'meta_id'   => $category->metatag->id,
                'name'      => $category->name,
                'url'       => $url, 
            ); 
            if($category->parent_id > 0){
                $result = self::metaCategory($category->parent_id, $result);
            }
        }
        return $result;
    }
    
    public function getArticles(){
        
        $criteria = new CDbCriteria;
        if(!empty($this->conditions)){
            foreach($this->conditions as $name => $value){
                switch ($name){
                    case 'addInCondition':
                        foreach($value as $i => $param){
                            $criteria->addInCondition($param[0] , $param[1]);
                        }
                        break;
                    case 'addCondition':
                        foreach($value as $i => $param){
                            $criteria->addCondition($param);
                        }
                        break;
                }
            }
        }
        
		$criteria->addCondition('t.active=1');
		$criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';
      
        #сортировка      
        if ((!empty($_GET['order'])) && (!empty($_GET['order-type']))){
            if($_GET['order'] == 'name'){
                $criteria->order = "t." . $_GET['order'] . " " . $_GET['order-type'];
            }else{
                $criteria->order = "t." . $_GET['order'] . " " . $_GET['order-type'] . ", t.name ASC";
            }
        }else{
            $criteria->order = "t.order ASC, t.name ASC";    
        }
        
  
        
        $count = Article::model()->count($criteria);
        
        $page_count = self::PAGE;
        if(!empty($_GET['count'])){
            $page_count = $_GET['count'];
        }
        
        $pages = new CPagination($count);
        $pages->pageSize = $page_count;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];
        
        
        
	    $articles = new CActiveDataProvider('Article', array(
	        'pagination' => array(
	            'pageSize'     => $page_count,
	            'pageVar'      => 'page',
	        ),
	        'criteria' => $criteria,
	    ));
        
        return array($articles, $pages);
    }
    


}
