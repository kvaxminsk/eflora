<?php

class AdminUserIdentity extends CUserIdentity
{
	public function authenticate()
	{
		
		$res      =   Yii::app()->db->createCommand()->select('*')->from('sm_admins')->queryAll();
		$users    =   array();
		for($i = 0; $i < count($res); $i++){
			$users[$res[$i]['user']] = $res[$i]['password'];
		}
		
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}
}