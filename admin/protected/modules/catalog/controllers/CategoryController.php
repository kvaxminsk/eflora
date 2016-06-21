<?php

class CategoryController extends BackController {

    public $h1 = "Категории каталога";
    
    public $title = "Категории каталога";

    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'Category';


    public function actionIndex() {

        $categories = Category::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;

        $model = new Category('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Category']))
            $model->attributes = $_GET['Category'];

        $this->render('index', array('model' => $model, 'categories' => $categories));
    }

    public function actionCreate() {
        $model = new Category;

        $model->metatag = new MetaTag;

        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];

            $model->metatag->module = 'catalog';
            $model->metatag->controller = 'front_catalog_controller';
            $model->metatag->action = 'category';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Category']['name']);
            }
            
            $model->metatag->uri = MetaTag::model()->createUri($model, 'Category');
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Category::model()->imagefolder);
                }
                $this->redirect(array('index'));
            }
        }

        $categories = Category::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;

        $this->title = 'Новая категория';

        $this->render('update', array(
            'model' => $model,
            'categories' => $categories,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (empty($model->metatag)) {
            $model->metatag = new MetaTag;
        }


        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];

            $model->metatag->module = 'catalog';
            $model->metatag->controller = 'front_catalog_controller';
            $model->metatag->action = 'category';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Category']['name']);
            }
            
            $old_model = $this->loadModel($id);
            $model->metatag->uri =  MetaTag::model()->updateUri($old_model, $model, 'Category');
          
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Category::model()->imagefolder);
                }
                $this->redirect(array('index'));
            }
        }

        $categories = Category::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;

        $this->title = 'Редактировать категорию';

        $this->render('update', array(
            'model' => $model,
            'categories' => $categories,
        ));
    }

    public function loadModel($id) {
        $model = Category::model()->with('metatag', 'images')->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
