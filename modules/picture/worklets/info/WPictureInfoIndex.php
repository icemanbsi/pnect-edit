<?php

class WPictureInfoIndex extends UWidgetWorklet {

	public function title() {
		return $this->t('{#post_button}');
	}

	public function taskConfig() {
		parent::taskConfig();
		wm()->add('picture.info.follow',null,array('position'=> array('after' => $this->id)));
	}

	public function taskRenderOutput() {
		$this->render('postButton');
	}

	public function taskButton() {
		$url = aUrl('/picture/js');
		return CHtml::link($this->t('{#post_v_ucf}'), "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','" . $url . "?rnd='+Math.random()*99999999);document.body.appendChild(e)})());");
	}

}