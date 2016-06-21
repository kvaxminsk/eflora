<?php

class Variables extends Back
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{variables}}';
	}

	public function rules()
	{
		return array(
			array('name, text', 'required'),
            
			array('id, name, text, label, delete_allow, smart_edit, active', 'safe'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'             => 'ID',
			'name'           => 'Переменная',
			'text'           => 'Значение',
			'label'          => 'Название',
            'active'         => 'Отображать',
			'delete_allow'   => 'Разрешить удаление',
			'smart_edit'     => 'Включить текстовый редактор',
		);
	}

	
	public function search()
	{
		$filter = $this->saveFilterParam('Variables', array(
			'label' => $this->label,
			'name' => $this->name,
		));
		$this->label = $filter['label'];
		$this->name = $filter['name'];
		
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('label',$this->label,true);

		return new CActiveDataProvider($this, array(
			'criteria'   =>  $criteria,
			'pagination' =>  array(
					'pageSize'=>40,
			),
		));
	}
    
    public static function getAll(){
        $criteria=new CDbCriteria;
        $criteria->addCondition('t.active=1');
		$variables = Variables::model()->findAll($criteria);
		$variables = CHtml::listData($variables, 'name', 'text');
        
        return $variables;
    } 
}