<?php

class VariableController extends BackController
{

    public $h1 = "Параметры";

    public $title = "Параметры";

    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'Variables';

    public function actionCreate()
    {
        $model = new Variables;

        if (isset($_POST['Variables'])) {
            $model->attributes = $_POST['Variables'];
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Variables'])) {
            $model->attributes = $_POST['Variables'];
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }


    public function actionIndex()
    {
        $model = new Variables('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Variables']))
            $model->attributes = $_GET['Variables'];

        $this->render('index', array(
            'model' => $model,
        ));
    }


    public function loadModel($id)
    {
        $model = Variables::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'variables-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
