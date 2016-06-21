<?php

class ProductBlock extends CWidget {
    
    public $file;
    
    public $type;
    
    public $order = 't.order';
    
    public $orderway = 'ASC';
    
    public $limit = 3;
    
    public $shop = array();
    
    public function run()
    {
        Yii::import('application.modules.catalog.models.*');
        Yii::import('application.modules.material.models.*');
        $criteria = new CDbCriteria;
        $criteria->addCondition('active=1');
        
        if(!empty($this->type))
            $criteria->addCondition($this->type . '=1');
            
        if($this->order == 'rand')
            $criteria->order = 'rand()';
        else
            $criteria->order = $this->order . ' ' . $this->orderway;
            
        $criteria->with = 'metatag';
        $criteria->limit = $this->limit;
        $products = Product::model()->findAll($criteria);
    
        //p($products);    	   
        $this->render('webroot.templates.catalog.'.$this->file , array('products' => $products, 'shop' => $this->shop));	
    }
}