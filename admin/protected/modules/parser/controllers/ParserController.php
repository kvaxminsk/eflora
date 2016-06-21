<?php

class ParserController extends BackController
{
    
    public $h1 = "Выгрузка";
	public $title = "Выгрузка";
	
    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'Parser';
    
	/*public function actionCreate()
	{
		$model = new Parser;

		if(isset($_POST['Parser']))
		{
			$model->attributes=$_POST['Parser'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model' => $model,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['Parser']))
		{
			$model->attributes=$_POST['Parser'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model' => $model,
		));
	}*/

	

	public function actionIndex()
	{
		$model = new Parser();
		
		if (!empty($_FILES['file'])) {
			$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/upload/files/';
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);

			$info = new SplFileInfo($_FILES['file']['name']);
			if ($info->getExtension() == 'xls') {
				if (copy($_FILES['file']['tmp_name'], $uploadfile)) {
					if (!empty($_POST['kurs']))
						$this->redirect(array('create', 'file' => $uploadfile, 'k' => $_POST['kurs'], 'p' => 1));
					else $error = "<h3>Ошибка! Не верно введен курс доллара!</h3>";
				} else $error = "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
			} else {
				$error = "<h3>Ошибка! Не верное расширение файла</h3>";
			}
		}
		
		$this->render('index',array(
			'model' => $model,
			'error' => $error
		));
	}
	
	public function actionCreate($file, $k, $p) {
		$model = new Parser();
		
		$info = $model->parserFile($file, $k, $p);
		
		$this->render('create',array(
			'model' => $model,
			'info' => $info['info'],
			'redirect' => $info['redirect']
		));
	}


	public function loadModel($id)
	{
		$model = Parser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='parser-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
