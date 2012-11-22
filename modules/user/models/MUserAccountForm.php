<?php
class MUserAccountForm extends MUser
{
	public $newPassword;
	public $passwordRepeat;
	public $notifications;
	
	public function rules()
	{
		return array(
			array('firstName,lastName,email,password','required'),
			array('firstName,lastName,email', 'length', 'max' => 250),
			array('avatar,timeZone,notifications', 'safe'),
			array('email', 'email'),
			array('email', 'unique', 'className' => 'MUser', 'message' => $this->t('This email is already in use.')),
			array('newPassword', 'length', 'min' => 6),
			array('passwordRepeat', 'compare', 'compareAttribute' => 'newPassword'),
			array('role','safe','on'=>'admin'),
			array('username','required','on'=>'admin'),
			array('username', 'unique', 'className' => 'MUser',
				'message' => $this->t('This username is already in use.'), 'on'=>'admin'),
			array('username', 'uniprogy.framework.yii.validators.UAlphaNumericValidator', 'minChars' => 4, 'maxChars' => 24,
				'allowNumbers' => true, 'extra' => array('-','_'), 'on'=>'admin'),
			array('username', 'UUsernameValidate', 'on'=>'admin'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'avatar' => $this->t('Avatar'),
			'firstName' => $this->t('First Name'),
			'lastName' => $this->t('Last Name'),
			'email' => $this->t('Email'),
			'password' => $this->t('Password'),
			'newPassword' => $this->t('New Password'),
			'passwordRepeat' => $this->t('New Password Confirm'),
			'timeZone' => $this->t('Time Zone'),
			'username' => $this->t('Username'),
			'notifications' => $this->t('Notifications'),
		);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeValidate()
	{
		if(!$this->avatar)
			$this->avatar = null;
			
		if($this->newPassword && $this->scenario != 'admin')
		{
			$this->password = $this->newPassword;
			$this->changePassword = null;
			$this->scenario = 'password';
		}		
		
		$this->firstName = strip_tags($this->firstName);
		$this->lastName = strip_tags($this->lastName);
		
		return parent::beforeValidate();
	}
}