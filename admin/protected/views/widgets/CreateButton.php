<?php

class CreateButton extends CWidget{
	
	function run(){
		
        $criteria = new CDbCriteria;
        $criteria->compare('create_button_show', 1);
        $criteria->order = 'create_button_sort ASC';
        
        $modules = Module::model()->findAll($criteria);
        $modules_array = array();
        foreach($modules as $i => $mod){
            $modules_array[] = $mod->attributes['module'];
        }
        if(in_array(Yii::app()->controller->id, $modules_array)){
            $module = Yii::app()->controller->id; 
        }elseif(isset(Yii::app()->controller->module->id)){
			$module = Yii::app()->controller->module->id;
		}
        
	    $module_result = array();
        $module_create = array();
        foreach($modules as $i => $mod){
            $attr = $mod->attributes;
            if($attr['module'] == $module){
                $module_create[] = $attr;
            }else{
                $module_result[] = $attr;
            }
        }
        
        $module_result = array_merge($module_create, $module_result);
        
        $this->render('application.views.widgets.views.create_button' , array('modules' => $module_result));
		
	}
	
}