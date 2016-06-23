<?php

class OrderNumberBlock extends CWidget {
    
    public $file;
    public $pstart = 0;
	public $pend = 999;
    public $uri;
    
    public function run()
    {
        Yii::import('application.modules.shop.models.Order');
        
        $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('#\?(.*)#si', '', $uri);
        $this->uri = $uri;
        
        $orderNumberAll = Order::model()->getOrderNumberAll();
        $orderNumberYesterday = Order::model()->getOrderNumberYesterday();
        $orderNumberToday = Order::model()->getOrderNumberToday();

        $this->render('webroot.templates.catalog.'.$this->file , array('orderNumberAll' => $orderNumberAll, 'orderNumberYesterday' => $orderNumberYesterday, 'orderNumberToday' => $orderNumberToday));
    }
    

    
}