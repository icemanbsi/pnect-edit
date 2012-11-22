<?php
class UserModule extends UWebModule
{
	public function getTitle()
	{
		return 'User';
	}
	
	public function preinit()
	{
		Yii::addCustomClasses(array(
			'UUsernameValidate' => $this->basePath.'/components/UUsernameValidate.php',
		));
		
		return parent::preinit();
	}
}
