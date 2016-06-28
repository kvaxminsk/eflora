<?php

class SlideBlock extends CWidget
{

    public $file;
    public $sliderN = 1;

    public function run()
    {
        Yii::import('application.modules.slider.models.Slide');
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('t.slider_n=' . $this->sliderN);
        $criteria->addCondition('t.img <> ""');
        $criteria->order = 't.order';

        $slides = Slide::model()->findAll($criteria);
        $this->render('webroot.templates.blocks.' . $this->file, array('slides' => $slides));
    }
}