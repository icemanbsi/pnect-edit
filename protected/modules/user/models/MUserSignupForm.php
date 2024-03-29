<?php

class MUserSignupForm extends MUser {

	public $termsAgree;
	public $passwordRepeat;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return array(
			array('email, password, passwordRepeat, firstName, lastName, username', 'required'),
			array('firstName, lastName, email', 'length', 'max' => 250),
			array('email', 'email'),
			array('email', 'unique', 'className' => 'MUser', 'message' => $this->t('This email is already in use.')),
			array('username', 'unique', 'className' => 'MUser', 'message' => $this->t('This username is already in use.')),
			array('username', 'uniprogy.framework.yii.validators.UAlphaNumericValidator', 'minChars' => 4, 'maxChars' => 24,
				'allowNumbers' => true, 'extra' => array('-','_')),
			array('username', 'UUsernameValidate'),
			array('password', 'length', 'min' => 6),
			array('passwordRepeat', 'compare', 'compareAttribute' => 'password'),
			array('termsAgree', 'required', 'message' => $this->t('You must be agree to our Terms of Use and Privacy Policy to join this site.'))
		);
	}

	public function attributeLabels() {
		$terms = '<a class="uDialog" target="_blank" href="' . url('/base/page', array('view' => 'terms')) . '">' . $this->t('Terms of Use') . '</a>';
		$privacy = '<a class="uDialog" target="_blank" href="' . url('/base/page', array('view' => 'privacy')) . '">' . $this->t('Privacy Policy') . '</a>';
		return array(
			'firstName' => $this->t('First Name'),
			'lastName' => $this->t('Last Name'),
			'username' => $this->t('Username'),
			'email' => $this->t('Email'),
			'password' => $this->t('Password'),
			'passwordRepeat' => $this->t('Password again'),
			'termsAgree' => $this->t('I have read and agree to the {terms} and {privacy}', array('{terms}' => $terms, '{privacy}' => $privacy))
		);
	}

	public function beforeSave() {
		if ($this->isNewRecord) {
			// set the right role
			if (m('user')->params['emailVerification'])
				$this->role = 'unverified';
			elseif (m('user')->params['approveNewAccounts'])
				$this->role = 'unapproved';
			else
				$this->role = 'user';

			// encrypt password
			$this->salt = UHelper::salt();
			$this->password = UHelper::password($this->password, $this->salt);
		}
		return parent::beforeSave();
	}

	public function beforeValidate() {
		$this->firstName = strip_tags($this->firstName);
		$this->lastName = strip_tags($this->lastName);
		return parent::beforeValidate();
	}

}