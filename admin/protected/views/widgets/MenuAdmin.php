<?php

class MenuAdmin extends CWidget
{
    public $uri;
    
	public function run()
	{
	    $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('#\?(.*)#si', '', $uri);
        $this->uri = $uri;
        
        $menu = Module::model()->getTreeDataModule();
        $menu = $this->getCategoryTree($menu); 
        
        $this->render('application.views.widgets.views.menu_admin' , array('menu' => $menu));
	}

    
    public function getCategoryTree($categories, $result = array()){
        foreach ($categories as $k => $v){
            if($v['active']){
                $v = $this->getActive($v);
                $result[$k] = $v;
                unset($result[$k]['children']);
                unset($result[$k]['parent']);
                if(!empty($v['children'])){
                    $result[$k]['children'] = array();
                    $result[$k]['children'] = $this->getCategoryTree($v['children'], $result[$k]['children']);
                }   
            }   
        }
        return $result;
    }
    
    public function getActive($v){
        $urls = explode('/', $this->uri);
        if($this->uri == '/'){
            $alias = '/';
        }else{
            $alias = end($urls);
        }
        $action = explode('/', $v['default_action']);
        
        $module = $urls[2];
        if(!empty($urls[3]))
            $controller = $urls[3];
        else
            $controller = $urls[2];
            
        $v['active'] = 0; 
        $v['current'] = 0;
        
        if(in_array($module, $action)){
            $v['current'] = 1;
        }
        if (in_array($controller, $action)){
            $v['active'] = 1; 
        }
        
        return $v;
    }
}