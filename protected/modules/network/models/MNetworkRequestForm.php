<?php
class MNetworkRequestForm extends MNetworkRequest
{	
	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'unique', 'className' => 'MNetworkRequest', 'message' => $this->t('You have already requested invitation. Your request is in the queue and we will send your invite as soon as it will become possible.')),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'email' => $this->t('Email Address'),
		);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}