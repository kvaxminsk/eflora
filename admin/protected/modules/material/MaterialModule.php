<?php

class MaterialModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'material.models.*',
			'material.components.*',
			'menu.models.*'
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
