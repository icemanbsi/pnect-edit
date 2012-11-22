<?php

class WPictureInfoFollow extends UWidgetWorklet {

	public function title() {
		return $this->t('Follow Button for Websites');
	}

	public function taskRenderOutput() {
		$this->render('followButton');
		cs()->registerScript(__CLASS__, '
		$("input").bind("click focus",function(){
			$(this).select();			
		});
		');
	}

	public function taskInput($image) {

		return CHtml::link(CHtml::image(app()->theme->baseUrl . '/images/buttons/follow/' . $image . '.png', $this->t('Follow Me on {site}', array('{site}' => app()->name))), aUrl('/') . '/' . app()->user->model()->username);
	}

	public function taskImage($image) {
		echo CHtml::image(app()->theme->baseUrl . '/images/buttons/follow/' . $image . '.png', $this->t('Follow Me on {site}', array('{site}' => app()->name)));
	}

}