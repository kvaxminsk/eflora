<?php

class NewsController extends BackController
{
    public $h1 = "Новости";

    public $title = "Новости";

    public $modulerun = 'News';


    #добавление статьи
    public function actionCreate()
    {
        $model = new News;
        $model->active = 1;
        $model->metatag = new MetaTag;

        if (isset($_POST['News'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }

            $model->attributes = $_POST['News'];

            $model->metatag->module = 'news';
            $model->metatag->controller = 'front_news_controller';
            $model->metatag->action = 'news';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['News']['name']);
            }

            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, News::model()->imagefolder);
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

        $this->h1 = "Новая новость";

        $this->render('create', array(
            'model' => $model
        ));
    }


    #обновление статьи
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (empty($model->metatag)) {
            $model->metatag = new MetaTag;
        }

        if (isset($_POST['News'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }

            $model->attributes = $_POST['News'];

            $model->metatag->module = 'news';
            $model->metatag->controller = 'front_news_controller';
            $model->metatag->action = 'news';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['News']['name']);
            }

            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, News::model()->imagefolder);
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

        $this->h1 = "Редактировать новость";

        $this->render('update', array(
            'model' => $model,
        ));
    }


    public function actionIndex()
    {
        $model = new News('search');
        $model->unsetAttributes();

        if (isset($_GET['News'])) {
            $model->attributes = $_GET['News'];
        }

        $this->render('index', array(
            'model' => $model
        ));
    }


    public function loadModel($id)
    {
        # запрос к модели с выборкой данных со сторонней таблицы
        $model = News::model()->with('metatag')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
