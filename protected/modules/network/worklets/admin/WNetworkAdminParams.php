<?php
class WNetworkAdminParams extends UParamsWorklet
{	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function properties()
	{
		return array(
			'elements' => array(
				'invitesPerDay' => array('type' => 'text', 'label' => $this->t('Invites Per Day'), 
					'hint' => $this->t('The number of invites a user can send within 24 hours.'), 'class' => 'small'),
				'inviteTimeLimit' => array('type' => 'text', 'label' => $this->t('Invites Time Limit'), 
					'hint' => $this->t('How many hours must pass after the first invitation to allow user to send another invitation to the same recipient.'),
					'class' => 'small'),
				'notifyEmail' => array('type' => 'text', 'label' => $this->t('Email for invite requests'),
					'hint' => $this->t('This email will receive all invite requests from users')),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Save'))
			),
			'model' => $this->model
		);
	}
}