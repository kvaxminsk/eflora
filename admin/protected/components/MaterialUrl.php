<?php

class MaterialUrl extends CWidget
{

    public $module;

    public $action;

    public $id = 0;

    public function run()
    {

        Yii::import('application.modules.material.models.*');

        $url = '#';
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        if ($this->id > 0) {
            $criteria->addCondition('t.id=' . $this->id);
        } else {
            if ((!empty($this->module)) && (!empty($this->action))) {
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition("module='$this->module'");
                $criteria2->addCondition("action='$this->action'");
                $type = MaterialType::model()->find($criteria2);
                if (!empty($type)) {
                    $type_id = $type->id;
                } else {
                    echo $url;
                    return;
                }
            }
            $criteria->addCondition('type_id=' . $type_id);
        }

        $material = Material::model()->find($criteria);

        if (!empty($material)) {
            $url = $material['url'];
        }
        echo $url;
        return;
    }

}