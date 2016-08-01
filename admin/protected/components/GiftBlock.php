<?php

class GiftBlock extends CWidget
{

    public $file;
    public $pstart = 0;
    public $pend = 999;
    public $uri;

    public function run()
    {
        Yii::import('application.modules.catalog.models.Product');
        Yii::import('application.modules.variables.models.Variables');

        $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('#\?(.*)#si', '', $uri);
        $this->uri = $uri;


        $criteria = new CDbCriteria;
        $criteria->addCondition('t.gift=1');

        $products = Product::model()->findAll($criteria);
        $variables = Variables::getAll();
        $this->render('webroot.templates.shop.' . $this->file, array('products' => $products, 'kurs' => $variables['kurs']*10000));
    }


}