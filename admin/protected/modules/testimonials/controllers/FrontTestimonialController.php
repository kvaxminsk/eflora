<?php

class FrontTestimonialController extends FrontController
{  
    #количество товаров на страницу
    CONST PAGE = 10;
    
    public function start($meta)
	{
	    $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=11');
        
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
		);
	}
    
    public function actionIndex($alias, $meta){
		$redirect = str_replace('?result=yes', '', getEnv('HTTP_REFERER'));
	    $redirect = str_replace('?result=no', '', $redirect);
		
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
        
		$model = new Testimonial;
        $model->active = 0;
         
		if(isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['message'])) {
		    $model->testimonial = strip_tags(stripcslashes($_POST['message']));
		    $model->email = strip_tags(stripcslashes($_POST['email']));
		    $model->name = strip_tags(stripcslashes($_POST['name']));
			
            if ($model->save()) $this->redirect($redirect . '?result=yes');
            else $this->redirect($redirect . '?result=no');
		}
 
        $criteria=new CDbCriteria;
		$criteria->addCondition('t.active=1');
		$criteria->order = "t.order ASC, t.date DESC";        
        
        $count = Testimonial::model()->count($criteria);
        
        $pages  = new CPagination($count);
        $pages->pageSize = self::PAGE;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];
    
	    $testimonials = new CActiveDataProvider('Testimonial', array(
	        'pagination' => array(
	            'pageSize' => self::PAGE,
	            'pageVar' => 'page',
	        ),
	        'criteria' => $criteria,
	    ));
                
        $this->render('index', array(
	       'model'             => $model,
           'meta'              => $meta,
           'testimonials'      => $testimonials,
           'pages'             => $pages
        ));  
    }
    
 

	public function getViewPath() {
                $controllername = $this->getId();
                $newPath = "webroot.templates.testimonials";
                $newPath = YiiBase::getPathOfAlias($newPath);
                return $newPath;
    }
    

}
