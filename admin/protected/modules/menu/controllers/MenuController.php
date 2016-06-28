<?php

class MenuController extends BackController
{

    public $h1 = "Меню";

    public $title = "Меню";

    public $modulerun = "Menu";

    public function actionCreate()
    {
        $materials = Material::model()->getTreeList('..');
        $model = new Menu;
        $model->active = 1;

        if (isset($_POST['Menu'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }

            $model->attributes = $_POST['Menu'];

            if (!empty($_POST['Menu']['material_id']))
                $model->material = $_POST['Menu']['material_id'];

            if ($model->save()) {
                if (!empty($_POST['save'])) {
                    switch ($_POST['save']) {
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

        $this->render('create', array(
            'model' => $model,
            'materials' => $materials
        ));
    }

    public function actionUpdate($id)
    {
        $materials = Material::model()->getTreeList('..');

        $model = $this->loadModel($id);

        if (isset($_POST['Menu'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }

            $model->attributes = $_POST['Menu'];

            if (!empty($_POST['Menu']['material_id']))
                $model->material = $_POST['Menu']['material_id'];

            if ($model->save()) {
                if (!empty($_POST['save'])) {
                    switch ($_POST['save']) {
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

        $this->render('update', array(
            'model' => $model,
            'materials' => $materials
        ));
    }


    public function actionIndex()
    {
        $model = new Menu('search');
        $model->unsetAttributes();

        if (isset($_GET['Menu']))
            $model->attributes = $_GET['Menu'];

        $this->render('index', array(
            'model' => $model,
        ));
    }


    public function loadModel($id)
    {
        $model = Menu::model()->with('material')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
