<?php

class Module extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{modules}}';
    }

    public function rules() {
        return array(
    
        );
    }
    public function behaviors(){
        
            return array(
            #для деревьев
            'TreeBehavior' => array(
                'class' => 'TreeBehavior',
                'order' => 't.parent_id DESC',
                'idParentField' => 'parent_id',
                'with' => 'parent'
            ));
    }
    
    public function relations(){
            return array(
                'parent'        => array(self::BELONGS_TO, 'Module', 'parent_id'),
                'childrens'     => array(self::HAS_MANY, 'Module', 'parent_id'),	
           );
	}
    
    public function getTreeData(){        
        return Module::model()->TreeBehavior->getTreeData();
    }
    
    public function getTreeDataActive(){        
        return Module::model()->TreeBehavior->getTreeDataActive();
    }
        
}
