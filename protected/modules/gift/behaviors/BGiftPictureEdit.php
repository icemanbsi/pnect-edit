<?php

class BGiftPictureEdit extends UWorkletBehavior {

	public function afterSave() {
		$post = isset($this->getOwner()->post) ? $this->getOwner()->post : $this->getOwner()->model;
		$price = wm()->get('gift.helper')->getPrice($post->message);
		
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

}