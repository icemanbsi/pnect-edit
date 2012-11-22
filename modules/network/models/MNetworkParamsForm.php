<?php
class MNetworkParamsForm extends UFormModel
{
	public $invitesPerDay;
	public $inviteTimeLimit;
	public $notifyEmail;


	public static function module()
	{
		return 'network';
	}
	
	public function rules()
	{
		return array(
			array(implode(',',array_keys(get_object_vars($this))),'safe')
		);
	}
}