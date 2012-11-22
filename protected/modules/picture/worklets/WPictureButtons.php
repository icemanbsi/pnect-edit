<?php

class WPictureButtons extends UMenuWorklet {

	public $layout = false;
	public $post;

	public function beforeConfig() {
		if (!$this->post)
			return $this->show = false;
	}

	public function afterRenderOutput() {
		$this->properties = array();
	}

	public function properties() {
		return array(
			'items' => array(
				array('label' => '<em></em>' . $this->t('Edit'), 'url' => url('/picture/edit', array('id' => $this->post->id)),
					'visible' => $this->post->userId == app()->user->id,
					'linkOptions' => array('class' => 'edit')),
				array('label' => '<em></em>' . (wm()->get('picture.helper')->likes($this->post->id) ? $this->t('Unlike') : $this->t('Like')),
					'visible' => $this->post->userId != app()->user->id,
					'url' => url('/picture/like', array('postId' => $this->post->id)),
					'linkOptions' => array('class' => 'like')),
				array('label' => '<em></em>' . $this->t('{#repost_ucf}'),					
					'url' => url('/picture/repost', array('postId' => $this->post->id)),
					'linkOptions' => array('class' => 'repost')),
				array('label' => '<em></em>' . $this->t('Original'),
					'url' => url('/picture/original', array('bin' => $this->post->picture->imageBin->id)),
					'linkOptions' => array('class' => 'view lightbox', 'target' => '_blank')),
				array('label' => '<em></em>' . $this->t('Cover'),
					'url' => url('/board/cover/index', array('boardId' => $this->post->boardId, 'postId' => $this->post->id)),
					'linkOptions' => array('class' => 'cover lightbox', 'target' => '_blank'),
					'visible' => wm()->currentWorklet && wm()->currentWorklet->id == 'board.view' && $this->post->userId == app()->user->id),
			),
			'htmlOptions' => array(
				'class' => 'horizontal clearfix',
			),
			'encodeLabel' => false
		);
	}

}