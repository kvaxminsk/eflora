<?php

class FrontController extends CController
{
    /**
     * с помощью изменения значения layout, можно установить для каждого контроллера своё отображение
     */
    public $layout = "webroot.templates.layout";
    
    /**
     * массив из модуля переменные
     */
    public $variables = array();

    public $kurs;
    public $kurs_rus_byn;
    public $kurs_rus_dollar;
    /**
     * Описание сайта, меняется в админке
     */
    public $description;

    /**
     * Ключевые слова сайта, меняется в админке
     */
    public $keywords; 
    
    /**
     * Заголовок страницы, title, меняется в админке
     */
    public $title = 'Сайт';  
    
    /**
     * H1, меняется в админке
     */
    public $h1;
    
    public $modelrun;
    
    public $urlroot;
    
    public $breadcrumbs = array();
    
    public $shop = array();
    
    /**
     * Вызывается при инициализации FrontController
     * Присваивает значения, необходимым переменным
     */
     
    public function __construct()
	{
		$variables = Variables::getAll();
        $this->variables = $variables;
        $this->kurs = $this->variables['kurs']*10000;
        $this->kurs_rus_byn = $this->variables['kurs_rus_byn']*100;
        $this->kurs_rus_dollar = $this->variables['kurs_rus_dollar'];

	}
    
    public function start($meta){
        #получение хлебных крошек
        $this->getBreadcrumbs($meta);
        $this->breadcrumbs = array_reverse($this->breadcrumbs);
    }
    
    /**
     * Все запросы на фронте идут через эту функцию
     */
    public function actionAlias($alias)
	{ 
	    if($alias == '') {
	        $object = new FrontMaterialController();   
            $object->actionHome();
        } else if($alias == 'mailing') {
			$phone = strip_tags($_POST[emaila]);
			
			$message = strip_tags($_POST[msg]);
			
			$host = str_replace('www.', '', getEnv('HTTP_HOST'));
            $subject = 'Сообщение через форму обратной связи на сайте www.' . $host;
  
            $email = $this->variables['email'];;
            $email = explode(',' , $email);
            $from = $email[0];
            $to = $email;
            
			$message = '<p>Новое обратный звонок на сайте www.' . $host . '</p>';
			$message .= '<br> Имя: <b>' . $_POST['name'] . '</b>';
			$message .= '<br>email: <b>' . (!empty($_POST['emailс']) ? $_POST['emailс'] : 'не указаны') . '</b>';
			$message .= '<br>Телефон: <b>' . (!empty($_POST['emaila']) ? $_POST['emaila'] : 'не указаны') . '</b>';
			$message .= '<br>Примечание: <br>' . $_PT['msg']. '<hr>';

			if(sendEmail($message, $subject, $from, $to)){
			     //$this->redirect($redirect . '?result=yes');
				 echo '<br><p style="color:green;" >Спасибо за обращение, мы свяжемся с вами в ближайшее время</p>';
			     
			}else{
			     echo '<br><h2 color="red">Письмо не отправленно, пожалуйста свяжитесь с нами по указанным телефонам</h2>';
			     //$this->redirect($redirect . '?result=no'); 
			}
			    
	    } else {

            $mas = explode('/', $alias);
    	    $lastElem = end($mas);
            $meta = MetaTag::model()->find('alias=:alias', array('alias' => $lastElem));
			
			$url = $meta->uri . '/' . $lastElem;
            $url = str_replace('//', '/', $url);
			$haystack = str_replace('//', '/', '/' . $alias);
			
            if(!empty($meta) && strripos($haystack, $url) !== false) {
                #подключаем необходимый модуль
                Yii::import('application.modules.'.$meta->module.'.models.*');
                Yii::import('application.modules.'.$meta->module.'.controllers.*');
                
                #формируем класс контроллера
                $controller = $this->getController($meta->controller);
             
                #создаём объект контроллера                
                $object = new $controller();
              
                #формируем действие для контроллера   
                $action = 'action' . ucfirst($meta->action);
                
                
                $object->start($meta);
     
                #вызываем необходимое действие
                $object->$action($alias, $meta);
                
            } else {
                $meta = MetaTag::model()->find('module=:module AND action=:action', array('module' => 'material', 'action' => 'error'));
        
                if (!empty($meta)) {
                    if($alias != $meta->alias){
                        $this->redirect('/' . $meta->alias);
                    }
                    $object = new FrontMaterialController();
                    $object->start($meta);          
                    $object->actionError($alias, $meta);  
                } else {
                    $this->redirect('/');
                }                  
            }
        }
	}
    
    public function actionOnline(){
        if (!empty($_POST))
		{
			$host = str_replace('www.', '', getEnv('HTTP_HOST'));
            $subject = 'Запрос на сайте www.' . $host;
  
            $from = $this->variables['email'];
            $to = array($this->variables['email']);
            
			$message = '<p>Запрос  на сайте www.' . $host . '</p>';
			$message .= 'Имя: <b>' . $_POST['name'] . '</b>';
			$message .= '<br>Телефон: <b>' . $_POST['phone']  . '</b>';
            $message .= '<br>E-mail: <b>' . $_POST['email']  . '</b>';
			$message .= '<br>Сообщение: <br>' . $_POST['msg'];

			if(sendEmail($message, $subject, $from, $to)){
			     die('ok');
			}else{
			     die('no'); 
			}            
		}
    }
//    public function actionAjaxProducts(){
////        var_dump($_POST);
////       die($_POST);
//        if (!empty($_POST))
//		{
//            $criteria = new CDbCriteria;
//            if(!empty($this->conditions)){
//                foreach($this->conditions as $name => $value){
//                    switch ($name){
//                        case 'addInCondition':
//                            foreach($value as $i => $param){
//                                $criteria->addInCondition($param[0] , $param[1]);
//                            }
//                            break;
//                        case 'addCondition':
//                            foreach($value as $i => $param){
//                                $criteria->addCondition($param);
//                            }
//                            break;
//                    }
//                }
//            }
//
//            $criteria->addCondition('t.active=1');
//            $criteria->order = "t.order ASC, t.name ASC";
//            $criteria->with = 'metatag';
//
//            if ($_GET['brand_id']) $criteria->addCondition('t.brand_id=' . $_GET['brand_id']);
//            if ($_GET['brand_model']) $criteria->addCondition('t.brand_model=\'' . $_GET['brand_model'] . "'");
//            if ($_GET['count']) $criteria->addCondition('t.manufacturer=\'' . $_GET['count'] . "'");
//            if ($_GET['year']) $criteria->addCondition('t.original=\'' . $_GET['year'] . "'");
//
//            #сортировка
//            if ($_GET['sort']) $criteria->order = "t." . $_GET['sort'] . " ASC, t.name ASC";
//
//
//            $criteria->with = 'brand';
//
//
//            $count = Product::model()->count($criteria);
////            var_dump($count);die('dsfsdaf');
//            if ($_GET['page_list']) $page_count = $_GET['page_list'];
//            else $page_count = self::PAGE;
//
//            if(!empty($_GET['count'])){
//                $page_count = $_GET['count'];
//            }
//
//            $pages = new CPagination($count);
//            $pages->pageSize = $page_count;
//            $pages->applyLimit($criteria);
//            $pages->route = $_SERVER['REDIRECT_URL'];
//
//
//
//            $products = new CActiveDataProvider('Product', array(
//                'pagination' => array(
//                    'pageSize'     => $page_count,
//                    'pageVar'      => 'page',
//                ),
//                'criteria' => $criteria,
//            ));//p($products);
//
//            return array($products, $pages);
//        }
//    }
    
    
    protected function beforeRender($view)
	{  
		# Корзина
	    Yii::import('application.modules.shop.models.Order');
        Order::model()->initshop();
		$this->shop = Order::model()->getShop();
	
        return $view;
	}

    
    /**
     * Получаем полное название контроллера
     */
    public function getController($string){
        $params = explode('_', $string);
        $result = '';
        foreach($params as $k => $v){
            $result .= ucfirst($v);
        } 
        return $result;
    }
    
    /**
     * Формирование хлебных крошек
     */
    public function getBreadcrumbs($meta){
        
        $class = ucfirst($meta->module);
        $model = $class::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        if(!$model){
            $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        }
        if($model){
            $url = '/' . $meta->uri . '/' . $meta->alias;
            $url = str_replace('//', '/', $url); 
                 
            $this->breadcrumbs[] = array(
                'meta_id'   => $meta->id,
                'name'      => $model->name,
                'url'       => $url, 
            ); 
            if(trim($meta->uri) != ''){
                $mas = explode('/', trim($meta->uri, '/'));
                $alias = end($mas);
                $meta = MetaTag::model()->find('alias=:alias', array('alias' => $alias));
                if(!empty($meta)){
                    $this->getBreadcrumbs($meta);
                }
            }
        }
        
    }
        
    public function meta($model, $meta){
        if ($meta->h1 == '') $this->h1 = $model->name; else $this->h1 = $meta->h1;
        if ($meta->title == '') $this->title = $model->name; else $this->title = $meta->title;
        if ($meta->description == '') $this->description = $model->name; else $this->description = $meta->description;
        if ($meta->keywords == '') $this->keywords = $model->name; else $this->keywords = $meta->keywords;
    }
    
    public function getViewPath() {
        $controllername = $this->getId();
        $newPath = "webroot.templates.{$controllername}";
        $newPath = YiiBase::getPathOfAlias($newPath);
        return $newPath;
    }
    
  
}