<?php
class BGiftPicturePost extends UWorkletBehavior
{
	public function afterSave()
	{
		$post = isset($this->getOwner()->post) ? $this->getOwner()->post : $this->getOwner()->model;
		$giftParent = null;
		if($post->parentId)
			$giftParent = MGift::model ()->findByPk($post->parentId);

		$price = wm()->get('gift.helper')->getPrice($post->message);
		$price = $price?$price:($giftParent?$giftParent->price:null);
		
		// is video
		if(m('video') && MVideo::model()->findByPk($post->pictureId))
			$price = null;
		
		if ($price) {
			$m = MGift::model()->findByPk($post->id);
			if (!$m) {
				$m = new MGift;
				$m->id = $post->id;
			}
			$m->price = $price;
			$m->save();
		} else {
			$m = MGift::model()->findByPk($post->id);
			if($m)
				$m->delete ();
		}
	}

	public function afterRenderOutput()
	{
		cs()->registerScriptFile(asma()->publish(Yii::getPathOfAlias('gift.js.gift').'.js'));
		$settings = CJavaScript::encode(array(
			'regexp' => wm()->get('gift.helper')->priceFormat('(\d+' . preg_quote(app()->locale->getNumberSymbol('decimal'),'/') . '?\d?\d?)', true)
		));
		cs()->registerScript(__CLASS__,'jQuery("#wlt-PicturePost form").uGift('.$settings.');');
	}
}