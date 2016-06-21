<?php

class SubjectsBlock extends CWidget {
    
    public $file;
    
    public $limit = 17;
    
    public function run()
    {
        Yii::import('application.modules.catalog.models.*');
        Yii::import('application.modules.material.models.*');
        $criteria = new CDbCriteria;
        $criteria->addCondition('active=1');
        
        if(!empty($this->type))
            $criteria->addCondition($this->type . '=1');
            
        $criteria->order = "t.order ASC";
        $criteria->with = 'metatag';
        $criteria->addCondition('t.active=1');
        $criteria->limit = $this->limit;
        $brands = Subjects::model()->findAll($criteria);
        
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=10');
        $material = Material::model()->with('metatag')->find($criteria);
        $urlroot = '';
        if(!empty($material)){
            $urlroot = '/'. $material->metatag->uri. '/' . $material->metatag->alias;
            $urlroot = str_replace('//', '/', $urlroot);
        }
            	
        $this->render('webroot.templates.catalog.'.$this->file , array('brands' => $brands, 'urlroot' => $urlroot));	
    }
}