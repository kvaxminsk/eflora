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
        switch ($meta->action) {
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
        if (!empty($material)) {
            $urlroot = '/' . $material->metatag->uri . '/' . $material->metatag->alias;
            $urlroot = str_replace('//', '/', $urlroot);
            $this->urlroot = $urlroot;
            $this->breadcrumbs[] = array(
                'meta_id' => $material->metatag->id,
                'name' => $material->name,
                'url' => $urlroot,
            );
        }
    }

    public function accessRules()
    {

        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('products1', 'index', 'top', 'new', 'popular', 'sale', 'search', 'product', 'category', 'brands', 'brand'),
                'users' => array('*'),
            ),
        );
    }

    /**
     *  Главная страница каталога
     **/
    public function actionIndex($alias, $meta)
    {
        $this->layout = 'webroot.templates.layout-internal';

        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        list($products, $pages) = $this->getProducts();

        $categories = Category::model()->getTreeDataActive();

        $this->render('index', array(
//	       'model'         => $model,
            'meta' => $meta,
            'products' => $products,
            'pages' => $pages,
//           'categories'    => $categories
        ));
    }


    /**
     *  страница товара
     **/
    public function actionProduct($alias, $meta)
    {
        $this->layout = 'webroot.templates.layout-product';
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.meta_id=' . $meta->id);

        $model = Product::model()->find($criteria);
////        var_dump($model->img);die();
//        $model->img = $model->img;
//        $model->views +=1;
//        $model->update(['views','img']);
//        $model = Product::model()->find($criteria);
        if ($model->category_id > 0) {
            $brc_category = self::metaCategory($model->category_id);
            $brc_category = array_reverse($brc_category);
            $this->breadcrumbs = array_merge($this->breadcrumbs, $brc_category);
        }

        if (!empty($meta)) {
            $url = $this->urlroot . '/' . $meta->uri . '/' . $meta->alias;
            $url = str_replace('//', '/', $url);
            $this->breadcrumbs[] = array(
                'meta_id' => $meta->id,
                'name' => $model->name,
                'url' => $url,
            );
        }


        parent::meta($model, $meta);

        $this->render('product-one', array(
            'model' => $model,
            'meta' => $meta,
        ));
    }

    /**
     *  страница категории
     **/
    public function actionCategory($alias, $meta)
    {
        $this->layout = 'webroot.templates.layout-internal';

        $model = Category::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
//        var_dump($model->name);die();
        $brc_category = self::metaCategory($model->id);
        $brc_category = array_reverse($brc_category);

        parent::meta($model, $meta);

        $categories = array();
        $categories[] = $model->id;


        $this->conditions['addInCondition'][] = array('category_id', $categories);

        list($products, $pages) = $this->getProducts();


        $this->render('category', array(
            'products' => $products,
            'pages' => $pages,
        ));
    }

    public function actionTop($alias, $meta)
    {
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $this->conditions['addCondition'][] = 't.is_top=1';

        list($products, $pages) = $this->getProducts();

        $this->render('top', array(
            'model' => $model,
            'meta' => $meta,
            'products' => $products,
            'pages' => $pages,
        ));
    }

    public function actionNew($alias, $meta)
    {
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $this->conditions['addCondition'][] = 't.is_new=1';

        list($products, $pages) = $this->getProducts();

        $this->render('top', array(
            'model' => $model,
            'meta' => $meta,
            'products' => $products,
            'pages' => $pages,

        ));
    }

    public function actionPopular($alias, $meta)
    {
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $this->conditions['addCondition'][] = 't.is_pop=1';

        list($products, $pages) = $this->getProducts();

        $this->render('top', array(
            'model' => $model,
            'meta' => $meta,
            'products' => $products,
            'pages' => $pages,

        ));
    }

    public function actionSale($alias, $meta)
    {
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $this->conditions['addCondition'][] = 't.is_sale=1';

        list($products, $pages) = $this->getProducts();

        $this->render('top', array(
            'model' => $model,
            'meta' => $meta,
            'products' => $products,
            'pages' => $pages,

        ));
    }

    public function actionSubjects($alias, $meta)
    {
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';

        $brands = Subjects::model()->findAll($criteria);

        $this->render('brands', array(
            'model' => $model,
            'meta' => $meta,
            'brands' => $brands,
        ));
    }

    public function actionSubject($alias, $meta)
    {
        $model = Subjects::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        if (!empty($meta)) {
            $url = $this->urlroot . '/' . $meta->uri . '/' . $meta->alias;
            $url = str_replace('//', '/', $urlroot);

            $this->breadcrumbs[] = array(
                'meta_id' => $meta->id,
                'name' => $model->name,
                'url' => $url,
            );
        }

        parent::metasub($model, $meta);

        $criteria = new CDbCriteria;
        $criteria->addCondition('brand_id=' . $model->id);
        $criteria->addCondition('t.active=1');
        $criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';


        $count = Product::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = self::PAGE;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];

        $products = new CActiveDataProvider('Product', array(
            'pagination' => array(
                'pageSize' => self::PAGE,
                'pageVar' => 'page',
                'route' => $_SERVER['REDIRECT_URL']
            ),
            'criteria' => $criteria,
        ));

        $this->render('brand', array(
            'model' => $model,
            'meta' => $meta,
            'products' => $products,
            'pages' => $pages
        ));
    }


    public function metaCategory($id, $result = array())
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('t.id=' . $id);
        $criteria->with = 'metatag';

        $category = Category::model()->find($criteria);
        if (!empty($category)) {
            $url = $this->urlroot . '/' . $category->metatag->uri . '/' . $category->metatag->alias;
            $url = str_replace('//', '/', $url);
            $result[] = array(
                'meta_id' => $category->metatag->id,
                'name' => $category->name,
                'url' => $url,
            );
            if ($category->parent_id > 0) {
                $result = self::metaCategory($category->parent_id, $result);
            }
        }
        return $result;
    }


    public function getViewPath()
    {
        $controllername = $this->getId();
        $newPath = "webroot.templates.catalog";
        $newPath = YiiBase::getPathOfAlias($newPath);
        return $newPath;
    }

    public function actionSearch($alias, $meta)
    {

        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $query = $_GET['query'];
        if ($query) {
            $w = explode(' ', $query);
            foreach ($w as $k => $v) {
                $w[$k] = preg_replace('#(ый|ий|ая|ое|оя|ои|о|ие|ые|ья|ье|ьи|ые|а|у|е|э|я|и|ю|ы|ь|ЫЙ|ИЙ|АЯ|ОЕ|ОЯ|ОИ|О|ИЕ|ЫЕ|ЬЯ|ЬЕ|ЬИ|ИЕ|А|У|Е|Э|Я|И|Ю|Ы|Ь )$#sim', '', $v);

                #Раскомментировать нижнюю строку, если необходимо исключить короткие поисковые запросы
                //if (mb_strlen($w[$k], 'UTF-8') < 3) unset($w[$k]);
            }

            if ($w) {
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

        $this->render('search', array(
            'model' => $model,
            'meta' => $meta,
            'products' => $products,
            'pages' => $pages
        ));
    }

    public function getProducts($group = false)
    {
//        var_dump($this->conditions);die();
        $criteria = new CDbCriteria;
        if (!empty($this->conditions)) {
            foreach ($this->conditions as $name => $value) {
//                if($value[0][1][0] == 17) {
//                    $criteria->addCondition('t.stock=1');
//                }
                switch ($name) {
                    case 'addInCondition':
                        foreach ($value as $i => $param) {
                            $criteria->addInCondition($param[0], $param[1]);
                        }
                        break;
                    case 'addCondition':
                        foreach ($value as $i => $param) {
                            $criteria->addCondition($param);
                        }
                        break;
                }
            }
        }
//        $criteria->addCondition('t.stock=1');
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

        if (!empty($_GET['count'])) {
            $page_count = $_GET['count'];
        }

        $pages = new CPagination($count);
        $pages->pageSize = $page_count;
        $pages->applyLimit($criteria);
        $pages->route = $_SERVER['REDIRECT_URL'];


        $products = new CActiveDataProvider('Product', array(
            'pagination' => array(
                'pageSize' => $page_count,
                'pageVar' => 'page',
            ),
            'criteria' => $criteria,
        ));//p($products);

        return array($products, $pages);
    }

    public function actionAjaxProducts()
    {

        if (!empty($_GET)) {
//            $this->layout = '';
            $this->layout = 'webroot.templates.layoutAjax';
            $criteria = new CDbCriteria;
            if ($_GET['category'] && ($_GET['category'] != 17)) {
                $criteria->addCondition('t.category_id=\'' . $_GET['category'] . "'");
            } else {
                $criteria->addCondition('t.stock=\'1\'');
            }


            if($_GET['price'] && $_GET['type'] == 'ASC') {
                $criteria->order = "t.price ASC";
//                die($_GET['type']);

            }
            elseif($_GET['price'] && $_GET['type'] == 'DESC') {
                $criteria->order = "t.price DESC";
//                die($_GET['type']);
            }

            $count = Product::model()->count($criteria);

            $pages = new CPagination($count);
            $pages->pageSize = 2;

//            die(($_GET));
            if (!empty($_GET['page'])) {
                $pageVar = $_GET['page'];
            } else {
                $pageVar = 1;
            }
//            if ($count == 1) {
//                if (($pageVar) > 2) {
//                    die();
//                }
//            }
//            if(($pages->pageSize < ($pageVar*$pages->pageSize - $count))  {
//
//            }
//            if (!(($pageVar*$pages->pageSize - $count) >0))
//            {
//                die();
//            }
            if (($pageVar*$pages->pageSize - $count) > 1) {
                die();
            }
            $pages->applyLimit($criteria);
            $pages->route = $_SERVER['REDIRECT_URL'];

            $products = new CActiveDataProvider('Product', array(
                'pagination' => array(
                    'pageSize' => 2,
                    'pageVar' => 'page',
                ),
                'criteria' => $criteria,
            ));
//            die($_GET['price']);
            if(!$_GET['price']) { $_GET['price']=0;}
            if(!$_GET['type']) { $_GET['type']=0;}

            $this->render('ajax_product', array(
                'products' => $products,
                'pages' => $pages,
                'pagevar' => $pageVar,
                'price' => $_GET['price'],
                'type' => $_GET['type'],
            ));
        }

    }

    public function actionAjaxProductCart()
    {
        if (!empty($_GET)) {
            $this->layout = 'webroot.templates.layoutAjax';
            $criteria = new CDbCriteria;

//            $criteria=new CDbCriteria;
//            $criteria->addCondition('t.id=' . (int)$_GET['id']);

            $product = Product::model()->findByPk((int)$_GET['id']);
            $this->render('ajax_product_cart', array(
                'product' => $product,
            ));
        }

    }

    public function actionAjaxProductReviews()
    {
        if (!empty($_GET)) {
            $this->layout = 'webroot.templates.layoutAjax';
            $criteria = new CDbCriteria;

//            $criteria=new CDbCriteria;
//            $criteria->addCondition('t.id=' . (int)$_GET['id']);

            $product = Product::model()->findByPk((int)$_GET['id']);
            $this->render('ajax_product_reviews', array(
                'product' => $product,
            ));
        }

    }

    public function actionAjaxProductReviewsCatalog()
    {
        if (!empty($_GET)) {
            $this->layout = 'webroot.templates.layoutAjax';
            $criteria = new CDbCriteria;

//            $criteria=new CDbCriteria;
//            $criteria->addCondition('t.id=' . (int)$_GET['id']);

            $product = Product::model()->findByPk((int)$_GET['id']);
            $this->render('ajax_product_reviews_catalog', array(
                'product' => $product,
            ));
        }

    }

    /**
     *  просмотренные товары
     **/
    public function actionReviews($alias, $meta)
    {
        $this->layout = 'webroot.templates.layout-internal';

        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        list($products, $pages) = $this->getProducts();

//        $categories = Category::model()->getTreeDataActive();

        $this->render('reviews', array(
//	       'model'         => $model,
            'meta' => $meta,
            'products' => $products,
            'pages' => $pages,
//           'categories'    => $categories
        ));
    }

}