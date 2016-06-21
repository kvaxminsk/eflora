<?php

class Menu extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return '{{menu}}';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('active, alias', 'safe'),
		);
	}

	public function relations()
	{
		return array(
                    'material' => array(self::MANY_MANY, 'Material',
                    Yii::app()->db->tablePrefix . 'menu_material(menu_id, material_id)'),
		);
	}
	public function attributeLabels()
	{
		return array(
                    'name' => 'Название',
                    'alias' => 'Переменная',
                    'active' => 'Активность',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
    
    protected function afterSave()
    {
        $this->refreshMaterial();
        parent::afterSave();
    }
 
    protected function refreshMaterial()
    {
        $materilas = $this->material;
 
        if (is_array($materilas) && (sizeof($materilas) > 0)){
            if(is_numeric($materilas[0])){
                
                MenuMaterial::model()->deleteAllByAttributes(array('menu_id'=>$this->id));
                    
                foreach ($materilas as $id)
                {
                    if (Material::model()->exists('id=:id', array(':id'=>$id)))
                    {                
                        $mm = new MenuMaterial();
                        $mm->menu_id = $this->id;
                        $mm->material_id = $id;
                        $mm->save();
                    }
                }
            }
        }
    }
}