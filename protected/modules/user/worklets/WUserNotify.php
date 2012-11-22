<?php

class WUserNotify extends UFormWorklet {

	public $modelClassName = 'MUserNotify';

	public function title() {
		return $this->t('Email Notification Settings');
	}

	public function accessRules() {
		return array(
			array('deny', 'users' => array('?'))
		);
	}

	public function taskModel() {
		return wm()->get('user.helper')->userNotifyModel(app()->user->id);
	}

	public function properties() {
		return array(
			'elements' => array(
				'comment' => array(
					'type' => 'checkbox', 
					'label' => m('picture')->t('When someone comments on your {#post_n}'),
					'layout' => "<fieldset>{input}\n{label}\n{hint}</fieldset>",
					'afterLabel' => '',
				),
				'like' => array(
					'type' => 'checkbox', 
					'label' => m('picture')->t('When someone likes your {#post_n}'),
					'layout' => "<fieldset>{input}\n{label}\n{hint}</fieldset>",
					'afterLabel' => '',
				),
				'repost' => array(
					'type' => 'checkbox', 
					'label' => m('picture')->t('When your {#post_n} is {#reposted}'),
					'layout' => "<fieldset>{input}\n{label}\n{hint}</fieldset>",
					'afterLabel' => '',
				),
				'follow' => array(
					'type' => 'checkbox', 
					'label' => $this->t('When a new person follows you'),
					'layout' => "<fieldset>{input}\n{label}\n{hint}</fieldset>",
					'afterLabel' => '',
				),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Update')),
			),
			'model' => $this->model()
		);
	}

	public function ajaxSuccess() {
		wm()->get('base.init')->addToJson(array('info' => array(
				'replace' => $this->t('Email Settings has been successfully updated.'),
				'fade' => 'target',
				'focus' => true,
				)));
	}

}
