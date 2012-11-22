<?php
class BGiftPictureHelper extends UWorkletBehavior
{
	public function afterCardContent($data,$result)
	{
		$gift = MGift::model()->findByPk($data->id);
		if($gift)
			return wm()->get('gift.render')->render('card',array('data'=>$data,'gift' => $gift),true);
	}
}