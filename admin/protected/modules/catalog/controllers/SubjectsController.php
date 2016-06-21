<?php

class SubjectsController extends BackController {

    public $h1 = "Тематика";
    
    public $title = "Тематика";

    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'Subjects';

    public function actionIndex() {

        $model = new subjects('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Subjects']))
            $model->attributes = $_GET['Subjects'];

        $this->render('index', array('model' => $model));
    }

    public function actionCreate() {
        $model = new Subjects;

        $model->metatag = new MetaTag;

        if (isset($_POST['Subjects'])) {
            $model->attributes = $_POST['Subjects'];

            $model->metatag->module = 'catalog';
            $model->metatag->controller = 'front_catalog_controller';
            $model->metatag->action = 'subjects';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Subjects']['name']);
            }
            
            $model->metatag->uri = MetaTag::model()->createUri($model, 'Subjects');
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Subjects::model()->imagefolder);
                }
                $this->redirect(array('index'));
            }
        }
        
        $this->title = 'Новая марка автомобиля';

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (empty($model->metatag)) {
            $model->metatag = new MetaTag;
        }


        if (isset($_POST['Subjects'])) {
            $model->attributes = $_POST['Subjects'];

            $model->metatag->module = 'catalog';
            $model->metatag->controller = 'front_catalog_controller';
            $model->metatag->action = 'subjects';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Subjects']['name']);
            }
            
            $old_model = $this->loadModel($id);
            $model->metatag->uri =  MetaTag::model()->updateUri($old_model, $model, 'Subjects');
          
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Subjects::model()->imagefolder);
                }
                $this->redirect(array('index'));
            }
        }

        $this->title = 'Редактировать марку автомобиля';

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Subjects::model()->with('metatag', 'images')->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subjects-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
