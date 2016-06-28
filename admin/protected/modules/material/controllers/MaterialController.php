<?php

class MaterialController extends BackController
{

    public $h1 = "Страницы";

    public $title = "Страницы";

    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'Material';

    #создание страницы

    public function actionCreate()
    {
        $materials = array(0 => 'Нет') + Material::model()->getTreeList('..');
        $model = new Material;
        $model->metatag = new MetaTag;
        $model->active = 1;

        $menu = Menu::model()->findAll();
        $menu = CHtml::listData($menu, 'id', 'name');

        if (isset($_POST['Material'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }

            #передача параметров для основной модели
            $model->attributes = $_POST['Material'];

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #получаем тип страницы и для метатэга указываем соответствующие свойства
            $type = MaterialType::model()->getType($_POST['Material']['type_id']);
            $model->metatag->module = $type->module;
            $model->metatag->controller = $type->controller;
            $model->metatag->action = $type->action;

            if ($model->parent_id > 0) {
                $parent_model = Material::model()->with('metatag')->findByPk($model->parent_id);
                $uri = '/' . $parent_model->metatag->uri . '/' . $parent_model->metatag->alias . '/';
                $uri = str_replace('//', '/', $uri);
                $model->metatag->uri = $uri;
            }

            #формирование псевдонима
            $model->metatag->alias = MetaTag::model()->createAlias($_POST['Material']['name']);

            $model->metatag->uri = MetaTag::model()->createUri($model, 'Material');

            #данные для связки с меню
            if (!empty($_POST['Material']['menu_id']))
                $model->menu = $_POST['Material']['menu_id'];

            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {

                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Material::model()->imagefolder);
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

        $this->title = $this->title . ' - Новая страница';

        #получаем типы страниц
        $types = MaterialType::model()->getList();

        $this->render('create', array(
            'model' => $model,
            'types' => $types,
            'menu' => $menu,
            'materials' => $materials
        ));
    }

    public function actionUpdate($id)
    {
        $materials = array(0 => 'Нет') + Material::model()->getTreeList('..');

        $model = $this->loadModel($id);

        $menu = Menu::model()->findAll();
        $menu = CHtml::listData($menu, 'id', 'name');

        if (empty($model->metatag)) {
            $model->metatag = new MetaTag;
        }

        if (isset($_POST['Material'])) {
            if ((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')) {
                $this->redirect(array('index'));
            }

            #передача параметров для основной модели
            $model->attributes = $_POST['Material'];

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #получаем тип страницы и для метатэга указываем соответствующие свойства
            $type = MaterialType::model()->getType($_POST['Material']['type_id']);
            $model->metatag->module = $type->module;
            $model->metatag->controller = $type->controller;
            $model->metatag->action = $type->action;


            if ($model->parent_id > 0) {
                $parent_model = Material::model()->with('metatag')->findByPk($model->parent_id);
                $uri = '/' . $parent_model->metatag->uri . '/' . $parent_model->metatag->alias . '/';
                $uri = str_replace('//', '/', $uri);
                $model->metatag->uri = $uri;
            }

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Material']['name']);
            }

            $old_model = $this->loadModel($id);
            $model->metatag->uri = MetaTag::model()->updateUri($old_model, $model, 'Material');

            #данные для связки с меню
            if (!empty($_POST['Material']['menu_id']))
                $model->menu = $_POST['Material']['menu_id'];
            else
                $model->menu = '#0#';

            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото

                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Material::model()->imagefolder);
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

        #передача заголовка страницы
        $this->title = $this->title . ' - Изменить страницу';

        #получаем типы страниц
        $types = MaterialType::model()->getList();

        $this->render('update', array(
            'model' => $model,
            'types' => $types,
            'menu' => $menu,
            'materials' => $materials
        ));
    }

    /**
     * Список всех страниц
     */
    public function actionIndex()
    {
        $model = new Material('search');
        $model->unsetAttributes();  // clear any default values

        $materials = array(0 => 'Нет') + Material::model()->getTreeList('..');

        if (isset($_GET['Material']))
            $model->attributes = $_GET['Material'];

        $this->render('index', array(
            'model' => $model,
            'materials' => $materials
        ));
    }

    public function loadModel($id)
    {
        $model = Material::model()->with('metatag', 'menu')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cmaterial-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
