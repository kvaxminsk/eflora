<?php

class catalogIndex extends CWidget
{

    public $file = 'catalogIndex';

    public function run()
    {
        Yii::import('application.modules.catalog.product.*');

        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->select = 't.brand_model, t.brand_id';
        $criteria->group = 't.brand_model';
        $brand_models = Product::model()->findAll($criteria);

        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->select = 't.manufacturer';
        $criteria->group = 't.manufacturer';
        $count = Product::model()->findAll($criteria);

        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->select = 't.original';
        $criteria->group = 't.original';
        $year = Product::model()->findAll($criteria);

        $this->render('webroot.templates.catalog.' . $this->file, array('brand_models' => $brand_models, 'count' => $count, 'year' => $year));
    }

}