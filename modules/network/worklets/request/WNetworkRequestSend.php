<?php
class WNetworkRequestSend extends UDeleteWorklet
{	
	public $modelClassName = 'MNetworkRequest';
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function beforeDelete($id)
	{
		$r = MNetworkRequest::model()->findByPk($id);
		if($r->email)
		{
			$invite = wm()->get('network.helper')->invite($r->email,0);

			app()->mailer->send($r->email, 'systemInvitationEmail', array(
				'link' => aUrl('/user/signup', array('h' => $invite->hash), 'http')
			));
		}
	}
}