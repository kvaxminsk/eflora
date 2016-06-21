<?php

class ArticleController extends BackController
{
	public $h1 = "Акции";
    
    public $title = "Акции";
    
    public $modulerun = 'Article';


    #добавление статьи
    public function actionCreate()
	{
		$model = new Article;
        $model->active = 1;
        $model->metatag = new MetaTag;
        
		if(isset($_POST['Article']))
		{
		    if((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')){
                $this->redirect(array('index'));
            }
              
			$model->attributes = $_POST['Article'];
			$model->metatag->module = 'articles';
            $model->metatag->controller = 'front_article_controller';
            $model->metatag->action = 'article';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Article']['name']);
            }
            
            $model->metatag->uri = MetaTag::model()->createUri($model, 'ArticleCategory');
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Article::model()->imagefolder);
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
        
		$categories = ArticleCategory::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;

		$this->h1 = "Новая статья";
        
		$this->render('create', array(
			'model'      => $model,
			'categories'   => $categories,
		));
	}

    
    #обновление статьи
    public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
  
        if (empty($model->metatag)) {
            $model->metatag = new MetaTag;
        }
        
		if(isset($_POST['Article']))
		{
		    if((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')){
                $this->redirect(array('index'));
            }
              
			$model->attributes = $_POST['Article'];
			$model->metatag->module = 'articles';
            $model->metatag->controller = 'front_article_controller';
            $model->metatag->action = 'article';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Article']['name']);
            }
            
            $old_model = $this->loadModel($id);
            $model->metatag->uri = MetaTag::model()->updateUri($old_model, $model, 'ArticleCategory');
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Article::model()->imagefolder);
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
        
		$categories = ArticleCategory::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;

		$this->h1 = "Редактировать статью";
        
		$this->render('update', array(
			'model'      => $model,
			'categories'   => $categories,
		));
	}


	public function actionIndex()
	{
		$categories = ArticleCategory::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;
                
		$model=new Article('search');
		$model->unsetAttributes(); 
		
		if(isset($_GET['Article'])){
			$model->attributes=$_GET['Article'];
		}
        
		$this->render('index',array(
			'model'        =>  $model,
			'categories'   =>  $categories,            
		));
	}
	

	public function loadModel($id)
	{
	    # запрос к модели с выборкой данных со сторонней таблицы
		$model=Article::model()->with('metatag')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
