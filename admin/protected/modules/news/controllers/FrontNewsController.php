<?php

class FrontNewsController extends FrontController
{  
    #количество товаров на страницу
    CONST PAGE = 10;
    public $layout = 'webroot.templates.layout-internal';
    public function start($meta)
	{
	    $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=12');
        
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
        
        
        $count = News::model()->count($criteria);
        
        $pages=new CPagination($count);
        $pages->pageSize = self::PAGE;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];
    
	    $news = new CActiveDataProvider('News', array(
	        'pagination' => array(
	            'pageSize' => self::PAGE,
	            'pageVar' => 'page',
	        ),
	        'criteria' => $criteria,
	    ));
              
        $this->render('index', array(
	       'model'     => $model,
           'meta'      => $meta,
           'news'      => $news,
           'pages'     => $pages
        ));  
    }
    
    public function actionNews($alias, $meta){
        $model = News::model()->with('images')->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
        
        $this->render('news',array(
	       'model' => $model,
           'meta'  => $meta,
        ));  
    }

	public function getViewPath() {
        $controllername = $this->getId();
        $newPath = "webroot.templates.news";
        $newPath = YiiBase::getPathOfAlias($newPath);
        return $newPath;
    }

}
