<?php

class FrontGalleryController extends FrontController
{
	
    public function __construct()
	{
		parent::__construct();
	}
    
    public function start($meta)
	{
	    $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=6');
        
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
    
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index, view'),
				'users'=>array('*'),
			),
		);
	}


	public function actionIndex($alias, $meta)
	{
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        parent::meta($model, $meta);
        
	
	    $criteria = new CDbCriteria;
        $criteria->compare('active', 1);
        $criteria->compare('parent_id', 0);
        $criteria->order = 't.order ASC, t.id DESC';
        $albums = Gallery::model()->findAll($criteria);
       
	    $this->render('index',array(
            'model'     => $model,
            'meta'      => $meta,
            'albums'    => $albums
	    ));
	}

	public function actionView($alias, $meta)
	{
        $model = Gallery::model()->find('t.meta_id=:id AND t.active=:a', array('id' => $meta->id, 'a' => 1));
        
        $brc_category = self::metaCategory($model->id);
        $brc_category = array_reverse($brc_category);
        $this->breadcrumbs = array_merge($this->breadcrumbs, $brc_category);
        
        parent::meta($model, $meta);
        
        
        $criteria = new CDbCriteria;
        $criteria->compare('active', 1);
        $criteria->compare('gallery_id', $model->id);
        $criteria->order = 't.order ASC, t.name ASC, t.id DESC';
        $images = GalleryPhoto::model()->findAll($criteria);
        
        $criteria = new CDbCriteria;
        $criteria->compare('active', 1);
        $criteria->compare('parent_id', $model->id);
        $criteria->order = 't.order ASC, t.name DESC';
        $subalbums = Gallery::model()->findAll($criteria);
        
		$this->render('view',array(
			'model'      => $model,
            'meta'       => $meta,
            'images'     => $images,
            'subalbums'  => $subalbums
            
		));
	}
    
    public function metaCategory($id , $result = array()){
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('t.id=' . $id);    
        $criteria->with = 'metatag';
        
        $category = Gallery::model()->find($criteria);
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


	public function getViewPath() {
            $controllername = $this->getId();
            $newPath = "webroot.templates.gallery";
            $newPath = YiiBase::getPathOfAlias($newPath);
            return $newPath;
    }


}
