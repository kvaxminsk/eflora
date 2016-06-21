<?php

class CatalogCategoryBlockSub extends CWidget {
    
    public $file;
    
    public $uri;
    
    public $parent_id;
    
    public function run()
    {
        Yii::import('application.modules.catalog.models.Category');
        
        $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('#\?(.*)#si', '', $uri);
        $this->uri = $uri;
    
        $categories = Category::model()->getTreeData();
        $categories = $this->getCategoryTree($categories, $this->parent_id); 
        
        $this->render('webroot.templates.catalog.'.$this->file , array('categories' => $categories));	
    }
    
    public function getCategoryTree($categories, $parent_id = 0, $result = array()){
        foreach ($categories as $k => $v){
            
            if($v['parent_id'] == $parent_id)
            {   
                if($v['active']){
                    $result[$k] = $v;
                    unset($result[$k]['children']);
                    unset($result[$k]['parent']);  
                    if(!empty($v['children'])){
                        $result[$k]['children'] = array();
                        $result[$k]['children'] = $v['children'];
                    } 
                }
            }            
        }
        
        if(sizeof($result) == 0){            
            foreach ($categories as $k => $v){
                if($v['active']){
                    if(!empty($v['children'])){
                        $result = $this->getCategoryTree($v['children'], $parent_id);
                        if(sizeof($result) != 0){
                            return $result;
                        }
                    }
                }
            }
        }
        return $result;
    }
    
}