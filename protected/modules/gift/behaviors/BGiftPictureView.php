<?php
class BGiftPictureView extends UWorkletBehavior
{
	public function afterContent($result)
	{
		$gift = MGift::model()->findByPk($this->getOwner()->post->id);
		if($gift)
			return wm()->get('gift.render')->render('view',array('post'=>$this->getOwner()->post,'gift'=>$gift),true);
	}
}