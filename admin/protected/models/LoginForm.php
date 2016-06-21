<?php

class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
    public $email;

	private $_identity;


	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'rememberMe' =>   'Запомнить меня',
		);
	}


	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity = new AdminUserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Не верное имя пользователя или пароль');
		}
	}


	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity = new AdminUserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode === AdminUserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; 
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
