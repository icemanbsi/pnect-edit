<?php

class WNetworkInvite extends UFormWorklet {

	public $messages = array();

	public function accessRules() {
		return array(
			array('deny', 'users' => array('?'))
		);
	}

	public function title() {
		return $this->t('Invite Friends to {sitename}', array('{sitename}' => app()->name));
	}

	public function afterConfig() {
		wm()->add('network.inviteMenu');
	}

	public function properties() {
		$elements = array();
		for ($i = 1; $i <= 4; $i++) {
			$elements['email_' . $i] = array(
				'type' => 'UForm',
				'elements' => array(
					'attribute' => array(
						'type' => 'text',
						'layout' => "<fieldset>{input}</fieldset>",
						'attributes' => array(
							'placeholder' => $this->t('Email Address {i}', array('{i}' => $i)),
							'name' => 'emails[' . $i . ']',
							'id' => 'emails_' . $i
						)
					)
				),
				'model' => new UDummyModel
			);
		}

		$elements['attribute'] = array('type' => 'textarea', 'layout' => "<fieldset>{input}</fieldset>", 'attributes' => array(
				'placeholder' => $this->t('Personal Message'),
			),);

		return array(
			'elements' => $elements,
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => $this->t('Send Invites'))
			),
			'model' => new UDummyModel
		);
	}

	public function taskInvite($email) {
		$hasInvited = wm()->get('network.helper')->invited($email, app()->user->id, true);
		if ($hasInvited) {
			$this->messages[] = $this->t('{email}: you have already invited this person.', array(
				'{email}' => $email
					));
			return;
		}

		$recentInvites = wm()->get('network.helper')->userInvites(app()->user->id);
		if ($recentInvites >= $this->param('invitesPerDay')) {
			$this->messages[] = $this->t('{email}: you can only send {num} invitations per 24 hours.', array(
				'{num}' => $this->param('invitesPerDay')
					));
			return;
		}

		$invite = wm()->get('network.helper')->invite($email, app()->user->id);

		app()->mailer->send($email, 'invitationEmail', array(
			'user' => app()->user->model(),
			'message' => htmlspecialchars($this->form->model->attribute),
			'link' => aUrl('/user/signup', array('h' => $invite->hash), 'http')
		));

		$this->messages[] = $this->t('Invite Sent to {email}!', array(
			'{email}' => $email
				));
	}

	public function taskSave() {
		$emails = array();
		$validator = new CEmailValidator;
		if (isset($_POST['emails']) && is_array($_POST['emails'])) {
			foreach ($_POST['emails'] as $k => $v)
				if ($v && $validator->validateValue($v))
					$emails[] = $v;
		}

		if (!count($emails))
			return $this->model->addError('attribute', $this->t('Please specify recipients of your invitation.'));

		foreach ($emails as $em)
			$this->invite($em);
	}

	public function ajaxSuccess() {
		$json = array(
			'info' => array(
				'replace' => implode('<br />', $this->messages),
				'focus' => true,
			),
			'content' => array(
				'append' => CHtml::script('$("#' . $this->getDOMId() . ' form").get(0).reset();'),
			),
		);
		//$json['load'] = url('network/invite',array('ajax'=>1));

		wm()->get('base.init')->addToJson($json);
	}

}