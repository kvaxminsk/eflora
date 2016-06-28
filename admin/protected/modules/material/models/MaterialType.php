<?php

class MaterialType extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{material_types}}';
    }


    public function rules()
    {
        return array(
            #указываем все остальные поля, у которых нет правил
            array('name, order, active', 'module', 'controller', 'action'),
        );
    }


    public function attributeLabels()
    {
        return array();
    }

    public function getList()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 't.order ASC';
        $criteria->addCondition('active=1');
        $types = MaterialType::model()->findAll($criteria);
        $types = CHtml::listData($types, 'id', 'name');
        return $types;
    }

    public function getTypes()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 't.order ASC';
        $criteria->addCondition('t.active=1');
        $types = MaterialType::model()->findAll($criteria);
        $result = array();
        foreach ($types as $i => $k) {
            $result[$k->id] = $k->attributes;
        }

        return $result;
    }

    public function getTypesSitemap()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 't.order ASC';
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('on_sitemap=1');
        $types = MaterialType::model()->findAll($criteria);
        $types = CHtml::listData($types, 'id', 'id');
        return $types;
    }

    public function getType($id)
    {
        $type = MaterialType::model()->findByPk($id);
        return $type;
    }


    public function search()
    {
        $criteria = new CDbCriteria;

        if (!isset($_GET['Material_sort'])) {
            $criteria->order = 'id DESC';
        }

        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));
    }

}