<?php

class WBoardCoverPost extends UWidgetWorklet {

	public $show = true;
	public $layout = false;

	public function accessRules() {
		return array(array('deny', 'users' => array('?')));
	}

	public function taskConfig() {
		$postId = app()->request->getParam('postId', null);
		$boardId = app()->request->getParam('boardId', null);
		$next = app()->request->getParam('next', '1');

		if ($postId && $boardId) {
			$count = MPicturePost::model()->count('boardId=?', $boardId);
			$c = new CDbCriteria;
			$c->order = $next ? '`t`.`id`' : '`t`.`id` DESC';
			$c->limit = 1;
			$c->condition = '`t`.`boardId`=' . $boardId . ' AND `t`.`id`' . ($next ? '>' : '<') . $postId;

			$post = MPicturePost::model()->find($c);
			if (!$post && $count) {
				$c->condition = '`t`.`boardId`=' . $boardId . ' AND `t`.`id`' . ($next ? '<' : '>') . $postId;
				$post = MPicturePost::model()->find($c);
			}

			if ($post)
				wm()->get('base.init')->addToJson(array(
					'postId' => $post->id,
					'src' => wm()->get('base.helper')->bin($post->picture->imageBin)->getFileUrl('medium'),
				));
		}
	}

}