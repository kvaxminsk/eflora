<?php

class DefaultController extends BackController
{
	public $h1 = "Настройки";
    
	public $title = "Настройки";

    
    public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
    
	public function accessRules()
	{
		return array(
			array(
                'allow',
				'actions'=>array('index'),
				'users'=>array('@'),
			),
		);
	}

	
	public function actionIndex()
	{
		$model = SiteConfig::model()->findByPk(1);
		

		if(isset($_POST['SiteConfig'])){
		    
            $model->attributes = $_POST['SiteConfig'];
		    $old_password = $_POST['SiteConfig']['old_password'];
            $new_password = $_POST['SiteConfig']['new_password']; 
            $confirm_password = $_POST['SiteConfig']['new_password'];          
            
            if (($old_password != '') || ($new_password != '') || ($confirm_password != '')){
                if (($old_password != '') && ($new_password != '') && ($confirm_password != '')){
                    if ($model->password != password($old_password)){
                        Yii::app()->user->setFlash('error','Текущий пароль введен не верно.');
                        $this->render('index', array('model'=>$model));
    		            return null;
                    }
                    if($new_password != $confirm_password){
                        Yii::app()->user->setFlash('error','Новый пароль и повтор пароля на совпадают');
                        $this->render('index', array('model'=>$model));
    		            return null;
                    }
                    $model->password = password($new_password);
                }else{
                    Yii::app()->user->setFlash('error','Не все поля заполнены для смены пароля.');
    		        $this->render('index', array('model'=>$model));
    		        return null;
                }
            }
            $model->save();
            Yii::app()->user->setFlash('success','Данные успешно сохранены');
            $this->render('index', array('model'=>$model));		
	        return null;

		}
		

		$this->render('index', array('model'=>$model));
	}
}