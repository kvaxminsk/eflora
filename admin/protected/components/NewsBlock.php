<?php

class NewsBlock extends CWidget
{

    public $file;

    public $limit = 4;

    public function run()
    {
        Yii::import('application.modules.news.models.*');
        $criteria = new CDbCriteria;
        $criteria->order = "date DESC, t.order ASC, t.id DESC";
        $criteria->limit = $this->limit;

        $news = News::model()->findAll($criteria);
        $this->render('webroot.templates.news.' . $this->file, array('news' => $news));
    }
}