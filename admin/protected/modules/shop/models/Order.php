<?php

class Order extends CActiveRecord
{

    var $cartCookie = '__shop';

    var $cookie = '';

    var $products = array();

    var $price = 0;

    var $count = 0;

    var $ids = array();

    function __construct($scenario = 'insert')
    {
        parent::__construct($scenario);

        if (!empty($_COOKIE[$this->cartCookie])) {
            $this->cookie = $_COOKIE[$this->cartCookie];
        }

    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{shop_orders}}';
    }

    public function rules()
    {
        return array(
            array('id, user_id, currency_id, active, status_id', 'numerical'),

            array('price, comment, date, user_name, user_address, user_email, user_phone, user_comment, user_city, user_come, user_time', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'products' => array(self::HAS_MANY, 'OrderProducts', 'order_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => '№',
            'price' => 'Сумма',
            'date' => 'Дата создания заказа',
            'user_id' => 'Пользователь',
            'currency_id' => 'Валюта',
            'status_id' => 'Статус заказа',
            'active' => 'Обработан',
            'comment' => 'Информация',
            'user_name' => 'Имя',
            'user_phone' => 'Телефон',
            'user_email' => 'E-mail',
            'user_address' => 'Адрес',
            'user_comment' => 'Комментарий',
            'user_city' => 'Город доставки',
            'user_come' => 'Способ доставки',
            'user_time' => 'Предпочитаемое время',

            'name_to' => 'Имя заказчика',
            'phone_to' => 'Телефон заказчика',
            'country_to' => 'Страна заказчика',
            'email_to' => 'Email заказчика',
            'text_postcard' => 'Сообщение от заказчика',


            'name_from' => 'Имя получателя',
            'phone_from' => 'Телефон получателя',
            'country_from' => 'Страна получателя',
            'city_from' => 'Город получателя',
            'address_from' => 'Адрес получателя',

            'date_delivery' => 'Дата доставки',
            'method_pay' => 'Метод оплаты',
            'currency' => 'Валюта',
            'total_amount' => 'Итоговая сумма',


        );
    }

    public function clean()
    {
        unset($_COOKIE[$this->cartCookie]);
        setcookie($this->cartCookie, '', time() + 86400 * 7, '/');
        $this->cookie = '';
    }


    public function initshop()
    {
        if (!empty($this->cookie)) {
            $prods = json_decode($this->cookie);

            $ids = array();

            if ($prods) {
                foreach ($prods as $p) {

                    $id = $this->checkId($p->id);

                    if (!$id) continue;

                    $count = !empty($p->count) ? (int)$p->count : 1;
                    if ($count < 0) $count = 1;

                    $ids[$id] = $count;
                }

                $products = $this->loadProducts(array_keys($ids));
                $this->ids = array_keys($ids);
                if ($products) {
                    foreach ($products as $k => $pr) {
                        $id = $pr['id'];
                        $price = $pr['price'];

                        $products[$k]['id'] = $id;
                        $products[$k]['shop_count'] = $ids[$id];
                        $products[$k]['shop_price'] = $price;
                        $products[$k]['shop_total'] = $price * $products[$k]['shop_count'];


                        $this->price += $products[$k]['shop_count'] * $products[$k]['shop_price'];
                        $this->count += $products[$k]['shop_count'];
                    }

                    $this->products = $products;
                }
            }
        }

        $this->saveCookie();
    }

    public function checkId($id)
    {
        $id = strtolower($id);

        if (!preg_match('#[0-9vm]#si', $id)) return false;

        return $id;
    }

    function saveCookie()
    {
        $cookie = array();
        if ($this->products) {
            foreach ($this->products as $k => $p) {
                $cookie[$k]['id'] = $p['id'];
                $cookie[$k]['count'] = $p['shop_count'];
                $cookie[$k]['price'] = $p['shop_price'];
            }
        }

        setcookie($this->cartCookie, json_encode($cookie), time() + 86400 * 7, '/');
    }


    public function loadProducts($ids)
    {
        Yii::import('application.modules.catalog.models.Product');

        $criteria = new CDbCriteria;
        $criteria->addInCondition('t.id', $ids);
        $criteria->addCondition('t.active=1');
        $criteria->order = "t.order ASC, t.name ASC";
        $criteria->with = 'metatag';

        $products = Product::model()->findAll($criteria);
        $product_result = array();

        foreach ($products as $i => $pr) {
            $product_result[$i] = $pr->attributes;
            if (!empty($pr->url)) {
                $product_result[$i]['url'] = $pr->url;
            }
            $product_result[$i]['metatag'] = $pr->metatag->attributes;
        }

        $products = $product_result;

        return $products;
    }

    public function loadProduct($id)
    {
//        var_dump($id);die();
        Yii::import('application.modules.catalog.models.Product');

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', (int) $id);
//        $criteria->addInCondition('t.id='. (int) $id);
//        var_dump($id);die();
        $criteria->addCondition('t.active=1');
//        var_dump($id);die();
        $model = Product::model()->find($criteria);


//        $criteria = new CDbCriteria;

//        $criteria->order = "t.order ASC, t.name ASC";
//        $criteria->with = 'metatag';

//        $products = Product::model()->find($criteria);
        return $model;
    }

    public function getCookie()
    {
        $cookie = Order::model()->cartCookie;
        $result = array();
        if (!empty($_COOKIE[$cookie])) {
            $products_cookie = json_decode($_COOKIE[$cookie]);
            foreach ($products_cookie as $i => $pr) {
                $result[$pr->id]['shop_price'] = $pr->price;
                $result[$pr->id]['shop_count'] = $pr->count;
            }
        }
        return $result;
    }

    public function getOrderNumberAll()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $count = Order::model()->count($criteria);
        return $count;
    }

    public function getOrderNumberToday()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('t.date LIKE :test','AND');
        $criteria->params=array(
            ':test'=>'%' .  date('Y-m-d') . '%',
        );
//		var_dump(Order::model()->findAll($criteria));die();
        $count = Order::model()->count($criteria);
//        var_dump(date('Y-m-d'));
        return $count;
    }

    public function getOrderNumberYesterday()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
//        $criteria->addCondition('t.date LIKE `%' .  . '%`');
//        $criteria->addCondition('t.date=' . date("Y-m-d", time() - (60 * 60 * 24)));
        $criteria->addCondition('t.date LIKE :test','AND');
        $criteria->params=array(
            ':test'=>'%' . date("Y-m-d", time() - (60 * 60 * 24)) . '%',
        );
        $count = Order::model()->count($criteria);
//        var_dump($count);
//        var_dump(date("Y-m-d", time()));
//        var_dump(date("Y-m-d", time() - (60 * 60 * 24)));
//        die();
        return $count;
    }

    public function getShop()
    {
        return array(
            'count' => $this->count,
            'price' => $this->price,
            'products' => $this->products,
            'ids' => $this->ids
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        if (!isset($_GET['Order_sort'])) {
            $criteria->order = 'id DESC';
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date);
        $criteria->compare('user_name', $this->user_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}