<?php

class AcategoryController extends BackController
{

    public $h1 = "Категории статей";

    public $title = "Категории статей";

    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'ArticleCategory';

    public function actionIndex()
    {
        $categories = ArticleCategory::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;

        $model = new ArticleCategory('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['ArticleCategory']))
            $model->attributes = $_GET['ArticleCategory'];

        $this->render('index', array('model' => $model, 'categories' => $categories));
    }

    public function actionCreate()
    {
        $model = new ArticleCategory;

        $model->metatag = new MetaTag;

        if (isset($_POST['ArticleCategory'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }

            $model->attributes = $_POST['ArticleCategory'];

            $model->metatag->module = 'articles';
            $model->metatag->controller = 'front_article_controller';
            $model->metatag->action = 'category';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['ArticleCategory']['name']);
            }

            $model->metatag->uri = MetaTag::model()->createUri($model, 'ArticleCategory');

            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, ArticleCategory::model()->imagefolder);
                }
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

        $categories = ArticleCategory::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;

        $this->title = 'Новая категория';

        $this->render('update', array(
            'model' => $model,
            'categories' => $categories,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (empty($model->metatag)) {
            $model->metatag = new MetaTag;
        }


        if (isset($_POST['ArticleCategory'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }

            $model->attributes = $_POST['ArticleCategory'];

            $model->metatag->module = 'articles';
            $model->metatag->controller = 'front_article_controller';
            $model->metatag->action = 'category';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['ArticleCategory']['name']);
            }

            $old_model = $this->loadModel($id);
            $model->metatag->uri = MetaTag::model()->updateUri($old_model, $model, 'ArticleCategory');


            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, ArticleCategory::model()->imagefolder);
                }
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

        $categories = ArticleCategory::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;

        $this->title = 'Редактировать категорию';

        $this->render('update', array(
            'model' => $model,
            'categories' => $categories,
        ));
    }

    public function loadModel($id)
    {
        $model = ArticleCategory::model()->with('metatag', 'images')->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
