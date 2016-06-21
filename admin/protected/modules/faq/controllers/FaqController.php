<?php

class FaqController extends BackController
{
	public $h1 = "Вопросы";
    
    public $title = "Вопросы";
    
    public $modulerun = 'Faq';



    #добавление статьи
    public function actionCreate()
	{
		$model = new Faq;
        $model->active = 1;
         
		if(isset($_POST['Faq']))
		{
			$model->attributes = $_POST['Faq'];
       
            if ($model->save()) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Faq::model()->imagefolder);
                }
                $this->redirect(array('index'));
            }
		}
  
		$this->h1 = "Новый вопрос";
        
		$this->render('create', array(
			'model'      => $model
		));
	}

    
    #обновление статьи
    public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
  
        
		if(isset($_POST['Faq']))
		{
			$model->attributes = $_POST['Faq'];
                        
            #сохранение со связующей моделью    
            if ($model->save()) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Faq::model()->imagefolder);
                }
                $this->redirect(array('index'));
            }
		}
        
		$this->h1 = "Редактировать вопрос";
        
		$this->render('update', array(
			'model'      => $model,
		));
	}


	public function actionIndex()
	{                
		$model=new Faq('search');
		$model->unsetAttributes(); 
		
		if(isset($_GET['Faq'])){
			$model->attributes = $_GET['Faq'];
		}
        
		$this->render('index',array(
			'model'        =>  $model            
		));
	}
	

	public function loadModel($id)
	{
	    # запрос к модели с выборкой данных со сторонней таблицы
		$model = Faq::model()->findByPk($id);
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
