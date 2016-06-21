<?php

class TestimonialController extends BackController
{
	public $h1 = "Отзывы";
    
    public $title = "Отзывы";
    
    public $modulerun = 'Testimonial';

    #добавление статьи
    public function actionCreate()
	{
		$model = new Testimonial;
        $model->active = 1;
         
		if(isset($_POST['Testimonial']))
		{
		    if((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')){
                $this->redirect(array('index'));
            }  
			$model->attributes = $_POST['Testimonial'];
       
            if ($model->save()) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Testimonial::model()->imagefolder);
                }
                if(!empty($_POST['save'])){
                    switch ($_POST['save']){
                        case 'save':
                            $this->redirect(array('update', 'id' => $model->id));
                            break;
                        case 'save-exit':
                            $this->redirect(array('index'));
                            break;                        
                    }
                }
                $this->redirect(array('index'));
            }
		}
  
		$this->h1 = "Новый отзыв";
        
		$this->render('create', array(
			'model'      => $model
		));
	}

    
    #обновление статьи
    public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
  
        
		if(isset($_POST['Testimonial']))
		{
		    if((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')){
                $this->redirect(array('index'));
            }
              
			$model->attributes = $_POST['Testimonial'];
                        
            #сохранение со связующей моделью    
            if ($model->save()) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Testimonial::model()->imagefolder);
                }
                if(!empty($_POST['save'])){
                    switch ($_POST['save']){
                        case 'save':
                            $this->redirect(array('update', 'id' => $model->id));
                            break;
                        case 'save-exit':
                            $this->redirect(array('index'));
                            break;                        
                    }
                }
                $this->redirect(array('index'));
            }
		}
        
		$this->h1 = "Редактировать отзыв";
        
		$this->render('update', array(
			'model'      => $model,
		));
	}


	public function actionIndex()
	{                
		$model=new Testimonial('search');
		$model->unsetAttributes(); 
		
		if(isset($_GET['Testimonial'])){
			$model->attributes = $_GET['Testimonial'];
		}
        
		$this->render('index',array(
			'model'        =>  $model            
		));
	}
	

	public function loadModel($id)
	{
	    # запрос к модели с выборкой данных со сторонней таблицы
		$model = Testimonial::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='testimonial-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
