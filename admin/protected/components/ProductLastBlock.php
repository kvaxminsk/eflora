<?php

class ProductLastBlock extends CWidget
{

    public $file;


    public $limit = 4;

    public $shop = array();

    public function run()
    {
        Yii::import('application.modules.catalog.models.*');
        Yii::import('application.modules.material.models.*');
        $criteria = new CDbCriteria;
        $criteria->addCondition('active=1');

        $criteria->order = 't.id DESC, t.order ASC';

        $criteria->with = 'metatag';
        $criteria->limit = $this->limit;
        $products = Product::model()->findAll($criteria);


        $this->render('webroot.templates.catalog.' . $this->file, array('products' => $products, 'shop' => $this->shop));
    }
}