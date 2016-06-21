<?php

class FrontFaqController extends FrontController
{  
    #количество товаров на страницу
    CONST PAGE = 5;
    
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
        
        parent::metasub($model, $meta);
        
 
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
                'route' => $_SERVER['REDIRECT_URL']
	        ),
	        'criteria' => $criteria,
	    ));
                
        $this->render('index', array(
	       'model' => $model,
           'meta'  => $meta,
           'articles' => $articles,
           'pages' => $pages
        ));  
    }
    
    public function actionArticle($alias, $meta){
        $model = Article::model()->with('images')->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
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
        
        
        parent::metasub($model, $meta);
        
        $this->render('article',array(
	       'model' => $model,
           'meta'  => $meta,
        ));  
    }


	public function loadModel($id)
	{
		$model=Articles::model()->with('metatag')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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


}
