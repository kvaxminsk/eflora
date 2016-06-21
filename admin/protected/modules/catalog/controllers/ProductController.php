<?php

class ProductController extends BackController
{
	public $h1 = "Товары";
    
    public $title = "Товары";
    
    public $modulerun = 'Product';
 

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
  
        if (empty($model->metatag)) {
            $model->metatag = new MetaTag;
        }
        
		if(isset($_POST['Product']))
		{
            //p($_POST,0);
            //p($_FILES);
             
		    if((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')){
                $this->redirect(array('index'));
            }
			$model->attributes = $_POST['Product'];
            
			$model->metatag->module = 'catalog';
            $model->metatag->controller = 'front_catalog_controller';
            $model->metatag->action = 'product';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Product']['name']);
            }
            
            $old_model = $this->loadModel($id);
            $model->metatag->uri = MetaTag::model()->updateUri($old_model, $model, 'Category');
            
                
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Product::model()->imagefolder);
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
        
		$categories = Category::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;
        
        $brands = Subjects::model()->findAll();
        $brands = array('0' => 'Нет') + CHtml::listData($brands, 'id', 'name');

		$this->h1 = "Редактировать товар";
        
		$this->render('update', array(
			'model'      => $model,
			'categories'   => $categories,
            'brands' => $brands,
		));
	}


	public function actionCreate()
	{
		$model=new Product;
        $model->active = 1;
        $model->metatag = new MetaTag;
        
		if(isset($_POST['Product']))
		{
		    if((!empty($_POST['save'])) && ($_POST['save'] == 'cancel')){
                $this->redirect(array('index'));
            }  
			$model->attributes = $_POST['Product'];
            
			$model->metatag->module = 'catalog';
            $model->metatag->controller = 'front_catalog_controller';
            $model->metatag->action = 'product';

            #передача параметров для модели метатегов
            $model->metatag->attributes = $_POST['MetaTag'];

            #формирование псевдонима, если нет
            if (empty($model->metatag->alias) || ($model->metatag->alias == '')) {
                $model->metatag->alias = MetaTag::model()->createAlias($_POST['Product']['name']);
            }
            
            $model->metatag->uri = MetaTag::model()->createUri($model, 'Category');
            
            #сохранение со связующей моделью    
            if ($model->withRelated->save(true, array('metatag'))) {
                #сохранение фото
                if (!empty($_FILES['Image'])) {
                    Image::model()->savephoto($_FILES['Image'], $model->id, Product::model()->imagefolder);
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
        
		$categories = Category::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;
        $brands = Subjects::model()->findAll();
        $brands = array('0' => 'Нет') + CHtml::listData($brands, 'id', 'name');

		$this->h1 = "Новый товар";
        
		$this->render('create', array(
			'model'      => $model,
			'categories'   => $categories,
            'brands' => $brands,
		));
	}


	public function actionIndex()
	{        
        $categories = Category::model()->getTreeList('..');
        $categories = array('0' => 'Нет') + $categories;
                
		$model=new Product('search');
		$model->unsetAttributes(); 
		
        $flags = Product::model()->product_flags;
        
		if(isset($_GET['Product'])){
			$model->attributes=$_GET['Product'];
		}
		$this->render('index',array(
			'model'        =>  $model,
			'categories'   =>  $categories,
            'flags'        =>  $flags             
		));
	}



	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionAjaxProducts() {

    }
    public function getProductsByCategoryId() {

    }
}
