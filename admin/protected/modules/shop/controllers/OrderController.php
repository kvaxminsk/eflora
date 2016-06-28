<?php

class OrderController extends BackController
{
    public $h1 = "Заказы";

    public $title = "Заказы";

    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'Order';


    #Функция не реализована
    public function actionCreate()
    {
        $model = new Order;
        $model->date = date('Y-m-d');

        if (isset($_POST['Order'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }
            $model->attributes = $_POST['Order'];
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
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Order'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }
            $model->attributes = $_POST['Order'];

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
            'model' => $model
        ));

    }

    public function loadModel($id)
    {
        $model = Order::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionIndex($status = null)
    {

        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Order']))
            $model->attributes = $_GET['Order'];

        $this->render('index', array(
            'model' => $model,
        ));
    }


    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
