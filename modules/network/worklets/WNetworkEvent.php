<?php

class WNetworkEvent extends USystemWorklet {

	public function taskManager() {
		static $m;
		if (!isset($m))
			$m = wm()->get('network.eventManager');
		return $m;
	}

	public function taskFollowUser($user, $follow) {
		$this->manager()->add(
				$user->id, 'network', 'follow.user', array('follow' => $follow->id)
		);
		$this->manager()->add(
				$follow->id, 'network', 'follow.my', array('follow' => $user->id)
		);
		if (wm()->get('user.helper')->userNotifyValue($follow, 'follow'))
			app()->mailer->send($follow->email, 'notifyFollowEmail', array(
				'user' => $user,
				'follow' => $follow,
			));
	}

	public function taskFollowBoard($user, $board) {
		$this->manager()->add(
				$user->id, 'network', 'follow.board', array('board' => $board->id)
		);
	}

	public function taskRead($userId, $type, $params) {
		$user = wm()->get('user.helper')->user($userId);
		$data = array();
		if (!$user)
			return $data;
		switch ($type) {
			case 'follow.user':
				$follow = wm()->get('user.helper')->user($params['follow']);
				if (!$follow)
					return $data;
				$data['image'] = $follow->avatarImg;
				$data['message'] = $this->t('{who} started following {whom}.', array(
					'{who}' => $user->name,
					'{whom}' => CHtml::link($follow->name, $follow->url)
						));
				break;
			case 'follow.my':
				$follow = wm()->get('user.helper')->user($params['follow']);
				if (!$follow)
					return $data;
				$data['image'] = $follow->avatarImg;
				$data['message'] = $this->t('{whom} started following {who}.', array(
					'{who}' => $user->name,
					'{whom}' => CHtml::link($follow->name, $follow->url)
						));
				break;
			case 'follow.board':
				$board = MBoard::model()->findByPk($params['board']);
				if (!$board)
					return $data;
				$data['image'] = $board->user->avatarImg;
				$data['message'] = $this->t('{who} started following {what} by {whom}.', array(
					'{who}' => $user->name,
					'{what}' => CHtml::link($board->title, $board->link),
					'{whom}' => CHtml::link($board->user->name, $board->user->url)
						));
				break;
		}
		return $data;
	}

}