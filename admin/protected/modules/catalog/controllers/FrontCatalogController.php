<?php

class FrontCatalogController extends FrontController
{
    #количество товаров на страницу
    CONST PAGE = 12;
    public $layout = 'webroot.templates.layoutOld';
    public $conditions = array();
    
    public function start($meta)
	{
	    $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        
        $type_id = 5;
        switch ($meta->action){
            case 'brands':
            case 'brand':
                $type_id = 10;            
                break;
            case 'search':
                $type_id = 19;
                break;
            case 'new':
                $type_id = 20;
                break;
            case 'top':
                $type_id = 21;
                break;
            case 'sale':
                $type_id = 22;
                break;
            case 'popular':
                $type_id = 23;
                break;
        }
        
        $criteria->addCondition('type_id=' . $type_id);
             
        $material = Material::model()->with('metatag')->find($criteria);
        if(!empty($material)){
            $urlroot = '/'. $material->metatag->uri. '/' . $material->metatag->alias;
            $urlroot = str_replace('//', '/', $urlroot);
            $this->urlroot = $urlroot; 
            $this->breadcrumbs[] = array(
                'meta_id'   => $material->metatag->id,
                'name'      => $material->name,
                'url'       => $urlroot, 
            ); 
        }
	}
    
	public function accessRules()
	{
 
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('products1','index', 'top', 'new', 'popular', 'sale', 'search', 'product', 'category', 'brands', 'brand'),
				'users'=>array('*'),
			),
		);
	}
    
    /**
     *  Главная страница каталога  
     **/
    public function actionIndex($alias, $meta){
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
        
        list($products, $pages) = $this->getProducts();
        
        $categories = Category::model()->getTreeDataActive();
               
        $this->render('index', array(
	       'model'         => $model,
           'meta'          => $meta,
           'products'      => $products,
           'pages'         => $pages,
           'categories'    => $categories
        ));  
    }

    public function actionProducts1 (){ die('fsaf');
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        list($products, $pages) = $this->getProducts();

        $categories = Category::model()->getTreeDataActive();

        $this->render('index', array(
            'model'         => $model,
            'meta'          => $meta,
            'products'      => $products,
            'pages'         => $pages,
            'categories'    => $categories
        ));
    }
    /**
     *  страница товара  
     **/
    public function actionProduct($alias, $meta){
        
        $criteria=new CDbCriteria;
        $criteria->addCondition('t.meta_id=' . $meta->id);
		
        $model = Product::model()->with('brand')->find($criteria);
        
        if($model->category_id > 0){
            $brc_category = self::metaCategory($model->category_id);
            $brc_category = array_reverse($brc_category);
            $this->breadcrumbs = array_merge($this->breadcrumbs, $brc_category);
        }
        
        if(!empty($meta)){
            $url = $this->urlroot . '/' . $meta->uri . '/' . $meta->alias;
            $url = str_replace('//', '/', $url); 
            $this->breadcrumbs[] = array(
                'meta_id'   => $meta->id,
                'name'      => $model->name,
                'url'       => $url, 
            );
        }
        
        
        parent::meta($model, $meta);
        
        $this->render('product',array(
	       'model' => $model,
           'meta'  => $meta,
        ));  
    }
    
    /**
     *  страница категории  
     **/
    public function actionCategory($alias, $meta){
        $model = Category::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        $brc_category = self::metaCategory($model->id);
        $brc_category = array_reverse($brc_category);
        $this->breadcrumbs = array_merge($this->breadcrumbs, $brc_category);
        
        parent::meta($model, $meta);
        
        $categories = array();
        $categories[] = $model->id;
        
        $sub_categories = Category::getChildsId($model->id);
        if(!empty($sub_categories))
            $categories = array_merge($categories, $sub_categories);
        
        
        $this->conditions['addInCondition'][] = array('category_id', $categories);
        
        list($products, $pages) = $this->getProducts();
        
        $criteria = new CDbCriteria;        
        $criteria->addCondition('t.active=1');
		$criteria->addCondition('t.parent_id=' . $model->id);
		$criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';
		
		$subcategories = Category::model()->findAll($criteria);
                        
        $this->render('category',array(
	       'model'             => $model,
           'meta'              => $meta,
           'products'          => $products,
           'pages'             => $pages,
           'subcategories'     => $subcategories
        ));  
    }
    
    public function actionTop($alias, $meta){
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
        
        $this->conditions['addCondition'][] = 't.is_top=1';
        
        list($products, $pages) = $this->getProducts();
                             
        $this->render('top',array(
	       'model'             => $model,
           'meta'              => $meta,
           'products'          => $products,
           'pages'             => $pages, 
        ));  
    }
    
    public function actionNew($alias, $meta){
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
        
        $this->conditions['addCondition'][] = 't.is_new=1';
        
        list($products, $pages) = $this->getProducts();
                             
        $this->render('top',array(
	       'model'             => $model,
           'meta'              => $meta,
           'products'          => $products,
           'pages'             => $pages, 
          
        ));  
    }
    
    public function actionPopular($alias, $meta){
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
        
        $this->conditions['addCondition'][] = 't.is_pop=1';
        
        list($products, $pages) = $this->getProducts();
                             
        $this->render('top',array(
	       'model'             => $model,
           'meta'              => $meta,
           'products'          => $products,
           'pages'             => $pages, 
          
        ));  
    }
    
    public function actionSale($alias, $meta){
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
        
        $this->conditions['addCondition'][] = 't.is_sale=1';
        
        list($products, $pages) = $this->getProducts();
                             
        $this->render('top',array(
	       'model'             => $model,
           'meta'              => $meta,
           'products'          => $products,
           'pages'             => $pages, 
          
        ));  
    }
    
    public function actionSubjects($alias, $meta){
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        
        parent::meta($model, $meta);
                
        $criteria = new CDbCriteria;
		$criteria->addCondition('t.active=1');
		$criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';
        
        $brands = Subjects::model()->findAll($criteria);
                            
        $this->render('brands',array(
	       'model' => $model,
           'meta'  => $meta,
           'brands' => $brands,
        ));  
    }
    
    public function actionSubject($alias, $meta){
        $model = Subjects::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        if(!empty($meta)){
            $url = $this->urlroot. '/' . $meta->uri. '/' . $meta->alias;
            $url = str_replace('//', '/', $urlroot);
          
            $this->breadcrumbs[] = array(
                'meta_id'   => $meta->id,
                'name'      => $model->name,
                'url'       => $url, 
            ); 
        }
        
        parent::metasub($model, $meta);
                
        $criteria=new CDbCriteria;
		$criteria->addCondition('brand_id=' . $model->id);
		$criteria->addCondition('t.active=1');
		$criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';
        
        
        $count = Product::model()->count($criteria);
        
        $pages=new CPagination($count);
        $pages->pageSize = self::PAGE;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];
    
	    $products=new CActiveDataProvider('Product', array(
	        'pagination' => array(
	            'pageSize' => self::PAGE,
	            'pageVar' => 'page',
                'route' => $_SERVER['REDIRECT_URL']
	        ),
	        'criteria' => $criteria,
	    ));
                
        $this->render('brand',array(
	       'model' => $model,
           'meta'  => $meta,
           'products' => $products,
           'pages' => $pages
        ));  
    }
    
    

    public function metaCategory($id , $result = array()){
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('t.id=' . $id);    
        $criteria->with = 'metatag';
        
        $category = Category::model()->find($criteria);
        if(!empty($category)){
            $url = $this->urlroot . '/' . $category->metatag->uri . '/' . $category->metatag->alias;
            $url = str_replace('//', '/', $url); 
            $result[] = array(
                'meta_id'   => $category->metatag->id,
                'name'      => $category->name,
                'url'       => $url, 
            ); 
            if($category->parent_id > 0){
                $result = self::metaCategory($category->parent_id, $result);
            }
        }
        return $result;
    }
	
    
	public function getViewPath() {
        $controllername = $this->getId();
        $newPath = "webroot.templates.catalog";
        $newPath = YiiBase::getPathOfAlias($newPath);
        return $newPath;
    }

    public function actionSearch($alias, $meta){
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
                
        parent::meta($model, $meta);       
        
        $query = $_GET['query'];
        if ($query)
        {
        	$w = explode(' ', $query);    
        	foreach ($w as $k=>$v)
        	{
        		$w[$k] = preg_replace('#(ый|ий|ая|ое|оя|ои|о|ие|ые|ья|ье|ьи|ые|а|у|е|э|я|и|ю|ы|ь|ЫЙ|ИЙ|АЯ|ОЕ|ОЯ|ОИ|О|ИЕ|ЫЕ|ЬЯ|ЬЕ|ЬИ|ИЕ|А|У|Е|Э|Я|И|Ю|Ы|Ь )$#sim', '', $v);
                
                #Раскомментировать нижнюю строку, если необходимо исключить короткие поисковые запросы
       	    	//if (mb_strlen($w[$k], 'UTF-8') < 3) unset($w[$k]);
        	}
            
        	if ($w)
        	{
	        	$query = join(' ', $w);

	        	$query = '%' . str_replace(' ', '%', $query) . '%';
	        	$q = explode('%', $query);
	        	$q = join('%', array_reverse($q));

	        	$q = mb_strtolower($q, 'utf-8');
	        	$query = mb_strtolower($query, 'utf-8');
                
                $this->conditions['addCondition'][] = "t.name LIKE '$query' or t.content LIKE '$query' or t.brand_model LIKE '$query'  or t.original LIKE '$query'  or t.manufacturer LIKE '$query'";
            }
        }
        list($products, $pages) = $this->getProducts();
             
        $this->render('search',array(
	       'model'     => $model,
           'meta'      => $meta,
           'products'  => $products,
           'pages'     => $pages
        ));  
    }
    
    public function getProducts($group = false){
        
        $criteria = new CDbCriteria;
        if(!empty($this->conditions)){
            foreach($this->conditions as $name => $value){
                switch ($name){
                    case 'addInCondition':
                        foreach($value as $i => $param){
                            $criteria->addInCondition($param[0] , $param[1]);
                        }
                        break;
                    case 'addCondition':
                        foreach($value as $i => $param){
                            $criteria->addCondition($param);
                        }
                        break;
                }
            }
        }
        
		$criteria->addCondition('t.active=1');
		$criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';
		
		if ($_GET['brand_id']) $criteria->addCondition('t.brand_id=' . $_GET['brand_id']);
		if ($_GET['brand_model']) $criteria->addCondition('t.brand_model=\'' . $_GET['brand_model'] . "'");
		if ($_GET['count']) $criteria->addCondition('t.manufacturer=\'' . $_GET['count'] . "'");
		if ($_GET['year']) $criteria->addCondition('t.original=\'' . $_GET['year'] . "'");
		
        #сортировка      
        if ($_GET['sort']) $criteria->order = "t." . $_GET['sort'] . " ASC, t.name ASC";
        
			
        $criteria->with = 'brand';
  
        
        $count = Product::model()->count($criteria);
        
		if ($_GET['page_list']) $page_count = $_GET['page_list'];
        else $page_count = self::PAGE;
		
        if(!empty($_GET['count'])){
            $page_count = $_GET['count'];
        }
        
        $pages = new CPagination($count);
        $pages->pageSize = $page_count;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];
        
        
        
	    $products = new CActiveDataProvider('Product', array(
	        'pagination' => array(
	            'pageSize'     => $page_count,
	            'pageVar'      => 'page',
	        ),
	        'criteria' => $criteria,
	    ));//p($products);
        
        return array($products, $pages);
    }
    public function actionAjaxProducts2(){
////        var_dump($_POST);
////       die($_POST);
//        if (empty($_POST))
//        {
//            $criteria = new CDbCriteria();
//
////            $count=Product::model()->count($criteria);
////            if ($_POST['category'] && ($_POST['category'] != 17)) {
////                $criteria->addCondition('t.category_id=\'' . $_POST['category'] . "'");
////            }
////            else {
////                $criteria->addCondition('t.stock=\'1\'');
////            }
//            $criteria=new CDbCriteria;
//            $criteria->addCondition('t.active=1');
//            $count = Article::model()->count($criteria);
//
//            $pages=new CPagination($count);
//            $pages->pageSize = self::PAGE;
//            $pages->applyLimit($criteria);
//            $pages->route = $_SERVER['REDIRECT_URL'];
//
//            $models = new CActiveDataProvider('Article', array(
//                'pagination' => array(
//                    'pageSize' => self::PAGE,
//                    'pageVar' => 'page',
//                ),
//                'criteria' => $criteria,
//            ));
//            
////            $models = Product::model()->findAll($criteria);
////            $pages=new CPagination($count);
////            $pages->pageSize = 1;
////            $pages->applyLimit($criteria);
////            $pages->route = $_SERVER['REDIRECT_URL'];
////
////            $models = new CActiveDataProvider('Product', array(
////                'pagination' => array(
////                    'pageSize' => self::PAGE,
////                    'pageVar' => $_POST['pageCount']+1,
////                ),
////                'criteria' => $criteria,
////            ));
//            // элементов на страницу
////            if ($_POST['pageCount']) {
////                $pages->pageSize=1 * ($_POST['pageCount']+1);
////            }
////            else {
////                $pages->pageSize=1;
////            }
////            $pages->pageSize=1;
////            $pages->pageVar =  $_POST['pageCount']+1;
////            $pages->applyLimit($criteria);
//
//            
//
////            foreach($models as $model) {
////
////            }
////            die('fdsaf');
//            $this->render('ajax_product', array(
//                'models' => $models,
//                'pages' => $pages
//            ));
//
//
//////            foreach($models as $model) {
//////                var_dump($model->name);
//////            }
////
////
//            $html = '';
//            $kurs = 20100;
//            foreach($models as $model) {
//                $html .=  ' <li class = "product">
//						<div class="product_wrap">
//						<div class="flower">
//					';
//
//                if($model->discount > 0) {
//                    $html .= '
//                                <div class="discount">
//                                    <p>-' . $model->discount . '%</p>
//                                </div>';
//
//                }
////                    die('ddd');
//                $html .= '<img class ="flower_pic"  src="' . $model->img['medium'] . '" alt="' . $model->name . '" />
//                            </div>
//                                <div class="old_price">
//                                    <span class="um">BR </span>
//                                           ' . (int)($model->price * $kurs / 1000) . '
//                                    <div class = "line"></div>
//                                    <span class="zero_old_price"> '.  round (($model->price * $kurs / 1000 -  ((int)($model->price * $kurs / 1000)) ) *1000) . '</span>
//                                </div>
//                                <div class="new_price">
//                                    <span class="um">BR </span>
//                                        ' . (int)($model->price * $kurs / 1000) . '
//                                    <span class="zero_old_price">' . round (($model->price * $kurs / 1000 -  ((int)($model->price * $kurs / 1000)) ) *10) . ' коп</span>
//                                </div>
//                                <div class="flower_discribe">
//                                    <p>' . $model->name . '</p>
//                                </div>
//                                <div class="count_product_selector">
//                                    <div class="decrement">-</div>
//                                    <div class="count_product"><input type="text" value="0" maxlength="4"> </div>
//                                    <div class="increment">+</div>
//                                </div>
//                                <div class="in_cart_wrap">
//                                    <a href="" class="in_cart"><p> В КОРЗИНУ </p></a>
//                                </div>
//                                <div class="hover_description">
//                                    ' . $model->content . '
//                                </div>
//                            </div>
//                        </li>';
//            }
//            $html .= "<li class = \"product\" id=\"show_more_item\">
//						<div class=\"download_more\">
//							<div class=\"download_icon\">
//								+
//							</div>
//                            <span >
//								ПОКАЗАТЬ ЕЩЕ
//							</span>
//						</div>
//					</li>";
//            $html .= '<script>
//
//$("#show_more_item").click(function(){
//		var pageCount = ' . ($_POST['pageCount'] + 1) . ';
//		alert(' .  ($_POST['pageCount']+1) . ' );
//		var category = $(this).attr(\'data-category\');
//
//		$.ajax({
//			type: \'POST\',
//			data:\'pageCount=\' + 1,
//			url: \'/ajax-products\',
//			success: function(data){
//				//document.write();
//				$(\'#show_more_item\').remove();
//				$(\'.flower_products\').append(data);
//			}
//		});
//	});
//</script>';
//            echo ($html);
//            //die('ddd');
//            //return $html;
////            $count = Product::model()->count(/*$criteria*/);
//////            var_dump($count);
////            if ($_GET['page_list']) $page_count = $_GET['page_list'];
////            else $page_count = self::PAGE;
////
////            if(!empty($_GET['count'])){
////                $page_count = $_GET['count'];
////            }
////
////            $pages = new CPagination($count);
////            $pages->pageSize = $page_count;
//////            $pages->applyLimit($criteria);
////            $pages->route = $_SERVER['REDIRECT_URL'];
////
////
////
//////            $products = new CActiveDataProvider('Product', array(
//////                'pagination' => array(
//////                    'pageSize'     => 10,
//////                    'pageVar'      => 'page',
//////                ),
////////                'criteria' => $criteria,
//////            ));
//////            foreach($products as $product) {
//////                var_dump($product->name);
//////            }
////            $criteria=new CDbCriteria;
////            $criteria->addCondition('t.meta_id=' . 11);
////
////            $products = new CActiveDataProvider('Product', array(
////                'pagination' => array(
////                    'pageSize'     => 10,
////                    'pageVar'      => 'page',
////                ),
////                'criteria' => $criteria,
////            ));
//////            $models = Product::model()->findAll();
////            foreach($products as $model) {
////                var_dump($model->name);
////            }
////
////            die();//p($products);
////            return 'fadsfdsa';
//            //return array($products, $pages);
//        }


        $criteria=new CDbCriteria;
//        $criteria->addCondition('t.active=1');



        $count = Article::model()->count($criteria);

        $pages=new CPagination($count);
        $pages->pageSize = self::PAGE;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];
        $articles = new CActiveDataProvider('Article', array(
            'pagination' => array(
                'pageSize' => self::PAGE,
                'pageVar' => 'page',
            ),
            'criteria' => $criteria,
        ));
//        $_GET['page'] = 1;
//        $models = new CActiveDataProvider('Article', array(
//            'pagination' => array(
//                'pageSize' => 10,
//                'pageVar' => 'page',
//            ),
//            'criteria' => $criteria,
//        ));
//        $_GET['page'] = 1;
        foreach ($articles as $model) {
            var_dump($model->name);
        }
        die('sdafds');
        $this->render('ajax_product', array(
            'models'      => $models,
            'pages'         => $pages,
        ));
    }
    public function actionAjaxProducts(){
        if (!empty($_GET)) {
//            $this->layout = '';
            $this->layout = 'webroot.templates.layoutAjax';
            $criteria=new CDbCriteria;
            if ($_GET['category'] && ($_GET['category'] != 17)) {
                $criteria->addCondition('t.category_id=\'' . $_GET['category'] . "'");
            }
            else {
                $criteria->addCondition('t.stock=\'1\'');
            }
            $count = Product::model()->count($criteria);

            $pages=new CPagination($count);
            $pages->pageSize = 1;

//            die(($_GET));
            if(!empty($_GET['page'])) {
                $pageVar = $_GET['page'];
            }
            else {
                $pageVar = 1;
            }
            if($count == 1) {
                if($pageVar > $count ) {
                    die();
                }
            }
            if($pageVar > $count ) {
                die();
            }
            $pages->applyLimit($criteria);
            $pages->route = $_SERVER['REDIRECT_URL'];

            $articles = new CActiveDataProvider('Product', array(
                'pagination' => array(
                    'pageSize' => 1,
                    'pageVar' => 'page',
                ),
                'criteria' => $criteria,
            ));



            $this->render('ajax_product', array(
                'articles'      => $articles,
                'pages'         => $pages,
                'pagevar' => $pageVar,
            ));
        }

    }
        
}