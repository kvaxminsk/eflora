<?php

class CatalogCategoryMainBlock extends CWidget
{

    public $file;

    public $limit = 3;

    public function run()
    {
        Yii::import('application.modules.catalog.models.Category');

        $criteria = new CDbCriteria;
        $criteria->order = "t.order ASC";
        $criteria->with = 'metatag';
        $criteria->limit = $this->limit;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('t.is_main=1');

        $categories = Category::model()->findAll($criteria);

        $this->render('webroot.templates.catalog.' . $this->file, array('categories' => $categories));
    }

}