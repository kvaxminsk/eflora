<?php

class ArticleBlock extends CWidget
{

    public $file;

    public $type = 'is_main';

    public $limit = 4;

    public function run()
    {
        Yii::import('application.modules.articles.models.*');
        $criteria = new CDbCriteria;
        $criteria->order = "date DESC";
        $criteria->limit = $this->limit;

        $articles = Article::model()->findAll($criteria);
        $this->render('webroot.templates.articles.' . $this->file, array('articles' => $articles));
    }
}