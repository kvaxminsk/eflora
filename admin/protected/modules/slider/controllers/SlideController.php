<?php

class SlideController extends BackController
{

    public $h1 = "Слайдшоу";

    public $title = "Слайдшоу";

    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'Slide';

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model = new Slide;

        if (isset($_POST['Slide'])) {
            $model->attributes = $_POST['Slide'];

            if ($model->save()) {
                $this->redirect(array('/slider/slide/index'));
            }
        }

        $this->title = 'Новый слайд';

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Slide'])) {
            $model->attributes = $_POST['Slide'];
            if ($model->save()) {
                $this->redirect(array('/slider/slide/index'));
            }
        }
        $this->title = 'Изменить слайд';

        $this->render('update', array(
            'model' => $model,
        ));

    }


    public function actionIndex()
    {
        $model = new Slide('search');
        $model->unsetAttributes();

        if (isset($_GET['Slide']))
            $model->attributes = $_GET['Slide'];

        $this->render('index', array('model' => $model));
    }


    public function loadModel($id)
    {
        $model = Slide::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'slide-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
