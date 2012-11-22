<?php

class WUserHelper extends USystemWorklet {

	/**
	 * Registers user in the system.
	 * @param mixed form or active record model - source of data
	 * @return MUser new user model
	 */
	public function taskRegister($model) {
		if ($model instanceOf MUser)
			$u = $model;
		else {
			$u = new MUser;
			$u->attributes = $model->attributes;
		}
		$u->language = app()->language;
		$u->save();
		if (m('user')->param('emailVerification') == '0')
			app()->mailer->send($u, 'registerEmail', array('user' => $u));
		return $u;
	}

	/**
	 * Automatically logges in user based on the model provided.
	 * @param MUser user model
	 */
	public function taskLogin($model) {
		$identity = new UUserIdentity($model->email, $model->password);
		$identity->setModel($model);
		$errorString = $identity->authenticate();

		if (is_string($errorString))
			return false;

		switch ($identity->errorCode) {
			case UUserIdentity::ERROR_NONE:
				app()->user->login($identity, 0);
				return true;
				break;
			case UUserIdentity::ERROR_USERNAME_INVALID:
				return false;
				break;
			case UUserIdentity::ERROR_PASSWORD_INVALID:
				return false;
				break;
		}
	}

	public function taskMenu() {
		return array(
			array('label' => '<p>' . CHtml::image(app()->user->model()->avatarImg, app()->user->model()->name . '</p>'),
				'itemOptions' => array('class' => 'userItem')),
			array('label' => app()->user->model()->name,
				'url' => app()->user->model()->url,
				'items' => array(
					array('label' => $this->t('Invite Friends'), 'url' => array('/network/invite')),
					array('label' => $this->t('Boards'), 'url' => app()->user->model()->url),
					array('label' => m('picture')->t('{#post_ns_ucf}'),
						'url' => array('/picture/user', 'username' => app()->user->model()->username)),
					array('label' => $this->t('1#Likes|n=2#Likes|n=3#Likes', array(3)),
						'url' => array('/picture/likes/user', 'username' => app()->user->model()->username)),
					array('label' => $this->t('Settings'), 'url' => array('/user/account')),
					array('label' => $this->t('Logout'), 'url' => array('/user/logout')),
				),
			)
		);
	}

	public function taskUser($id) {
		static $users = array();
		if (!isset($users[$id]))
			$users[$id] = MUser::model()->findByPk($id);
		return $users[$id];
	}

	public function taskUserNotifyValue($user, $fieldName) {
		$model = $this->userNotifyModel($user);
		return $model ? $model->$fieldName : 0;
	}

	public function taskUserNotifyModel($user) {
		$user = $user instanceOf MUser ? $user : MUser::model()->findByPk($user);
		if (!$user->notify) {
			$notify = new MUserNotify;
			$notify->id = $user->id;
			$notify->save();
		}
		return $user->notify;
	}

}