<?php

class WNetworkEventManager extends USystemWorklet {

	public function taskAdd($userId, $module, $type, $params) {
		$m = new MNetworkEvent;
		$m->userId = $userId;
		$m->eventModule = $module;
		$m->eventType = $type;
		$m->params = serialize($params);
		$m->created = time();
		$m->save();
	}

	public function taskRead($model) {
		return wm()->get($model->eventModule . '.event')->read($model->userId, $model->eventType, unserialize($model->params));
	}

	public function taskMail($tamplate, $userId, $postId, $options = array()) {
		$user = MUser::model()->findByPk($userId);
		$post = MPicturePost::model()->findByPk($postId);

		if (wm()->get('user.helper')->userNotifyValue($post->user, $tamplate))
			app()->mailer->send($post->user->email, 'notify' . ucfirst($tamplate) . 'Email', array(
				'user' => $user,
				'post' => $post,
			));
	}

}