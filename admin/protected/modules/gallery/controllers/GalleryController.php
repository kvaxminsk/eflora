<?php

class GalleryController extends BackController {
    
  
    public $h1 = "Примеры работ";
    	
    public $title = "Примеры работ";
    
    #указываем модель, по которой должны работать массовые элементы
    public $modulerun = 'Gallery';
        
    public function actionIndex() {
        $categories = Gallery::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;
        
        $model = new Gallery('search');
        $model->unsetAttributes();  
        
        if (isset($_GET['Gallery']))
            $model->attributes = $_GET['Gallery'];

        $this->render('index', array(
            'model' => $model,
            'categories' => $categories
        ));
    }
    

    public function actionCreate() {
        $model = new Gallery;
        $model->metatag = new MetaTag;
        $model->active = 1;

        if (isset($_POST['Gallery'])) {
            if((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')){
                $this->redirect(array('index'));
            }
                
            #передача параметров для основной модели
            $model->attributes = $_POST['Gallery'];

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #получаем тип страницы и для метатэга указываем соответствующие свойства
            $model->metatag->module     = 'gallery';
            $model->metatag->controller = 'front_gallery_controller';
            $model->metatag->action     = 'view';
            
            #формирование псевдонима
            $model->metatag->alias = MetaTag::model()->createAlias($_POST['Gallery']['name']);
            
            $model->metatag->uri = MetaTag::model()->createUri($model, 'Gallery');
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                $model->detachBehavior('imageUpload');
                if (!empty($_FILES['GalleryPhoto'])) {
                    GalleryPhoto::model()->savephoto($_FILES['GalleryPhoto'], $model->id, Gallery::model()->imagefolder);
                }
                if(!empty($_POST['save'])){
                    switch ($_POST['save']){
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
        
        $this->title .= ' - добавить';
        
        $categories = Gallery::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;
        
        $this->render('create', array(
            'model' => $model,
            'categories' => $categories
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (empty($model->metatag)) {
            $model->metatag = new MetaTag;
        }
        
        if (isset($_POST['Gallery'])) {
            if((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')){
                $this->redirect(array('index'));
            }
            
            #передача параметров для основной модели
            unset($_POST['Gallery']['img']);
            $model->attributes = $_POST['Gallery'];

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #получаем тип страницы и для метатэга указываем соответствующие свойства
            $model->metatag->module     = 'gallery';
            $model->metatag->controller = 'front_gallery_controller';
            $model->metatag->action     = 'view';            

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Gallery']['name']);
            }
            
            $old_model = $this->loadModel($id);
            $model->metatag->uri =  MetaTag::model()->updateUri($old_model, $model, 'Gallery');
            
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                $model->detachBehavior('imageUpload');
                if (!empty($_FILES['GalleryPhoto'])) {
                    GalleryPhoto::model()->savephoto($_FILES['GalleryPhoto'], $model->id);
                }
                
                if(!empty($_POST['save'])){
                    switch ($_POST['save']){
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

        $this->title .= ' - изменить';
        
        $categories = Gallery::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;
        
        $this->render('update', array(
            'model' => $model,
            'categories' => $categories
        ));
    }


    public function loadModel($id) {
        $model = Gallery::model()->with('metatag')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gallery-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
