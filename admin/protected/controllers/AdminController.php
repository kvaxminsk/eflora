<?php

class AdminController extends CController {
	public function actionIndex() {
		$this->redirect('/admin/material/material');
	}
    
    public function init() {
        parent::init();
      
    }

	public function actionError() {
		if($error = Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->renderPartial('error', array('data' => $error));
		}
	}
	
	public function actionLogin() {
		$model = new LoginForm;
		$this->layout = "main";
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['LoginForm'])) {        
			$model->attributes = $_POST['LoginForm'];
            $model->password = password($_POST['LoginForm']['password']);
			if($model->validate() && $model->login()) {
			    $_SESSION['adminsmby'] = true; 
				$this->redirect(Yii::app()->user->returnUrl);
			}
			$model->password = false;
		}
		$this->render('login', array('model' => $model));
	}
    
    public function actionPassword() {
		$model = new LoginForm;
		$this->layout = "main";

		if(isset($_POST['LoginForm']['email'])) {
		    $criteria=new CDbCriteria;
            $criteria->compare('email', $_POST['LoginForm']['email']);
            $admin = Admin::model()->find($criteria);
			if(!empty($admin->id)) {
			    
                $password = Admin::model()->generatePassword(); 
			    $host = str_replace('www.', '', getEnv('HTTP_HOST'));
                $subject = 'Восстановление пароля от администраторской панели на сайте www.' . $host;
      
                
    			$message = '<p>Восстановление пароля от администраторской панели на сайте www.' . $host . '</p>';
    			$message .= 'Логин: <b>' . $admin->user . '</b>';
    			$message .= '<br>Новый пароль: <b>' . $password . '</b><br />';
                $message .= '<a href="http://' . $host. '/admin/login">Войти в админ панель</a>';
                
    
    			if(sendEmail($message, $subject, $admin->email, $admin->email)) {
    			     $admin->password = password($password);
                     $admin->save();
    			     $this->redirect('/admin/password?result=ok');
    			} else {
    			     $this->redirect('/admin/password?result=no'); 
    			}          				
			} else {
			    $this->redirect('/admin/password?result=no'); 
			}
		}
		$this->render('password', array('model' => $model));
	}
	
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}