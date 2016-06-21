<?php


class SiteConfig extends CActiveRecord
{
	
	public $old_password = '';
	public $new_password;
	public $confirm_password;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function tableName()
	{
		return '{{admins}}';
	}

	public function rules()
	{
		return array(
			array('user, email', 'required'),

			array('id, password, email', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user' => 'User',
			'password' => 'Password',
		);
	}
    
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}