<?php

class WPictureCommentList extends UListWorklet {

	public $modelClassName = 'MPictureComment';
	public $type = 'list';
	public $itemView = 'comment';
	public $postId;
	public $asView;

	public function form() {
		return false;
	}

	public function itemView() {
		return $this->itemView;
	}

	public function beforeConfig() {
		if (!$this->postId && isset($_GET['postId'])) {
			$this->postId = $_GET['postId'];
			$this->itemView = 'commentBrief';
		}
	}

	public function afterConfig() {
		if ($this->itemView == 'commentBrief')
			$this->options['enablePagination'] = false;
		$this->options['template'] = $this->itemView == 'commentBrief' ? '{items}' : "{items}\n{pager}";
		$this->options['emptyText'] = '';
		$this->model->postId = $this->postId;
	}

	public function dataProvider() {
		$dp = parent::dataProvider();
		$dp->pagination = $this->itemView == 'commentBrief' ? array('pageSize' => $this->param('commentInCard') ? $this->param('commentInCard') : 10) : array('pageSize' => $this->param('commentInView') ? $this->param('commentInView') : 100);
		return $dp;
	}

	public function taskRenderOutput() {
		$this->beginContent('list');
		parent::taskRenderOutput();
		$this->endContent();

		if (!app()->user->isGuest)
			app()->controller->worklet('picture.comment.add', array('postId' => $this->postId, 'enableAjax' => ($this->itemView != 'commentBrief'), 'listId' => $this->getDOMId(), 'asView' => $this->asView));

		if ($this->itemView == 'commentBrief')
			cs()->registerScript('CListView#' . $this->getDOMId() . '-list', '');
	}

	public function getDOMId() {
		return parent::getDOMId() . ($this->asView ? '-view' : '') . '-' . $this->postId;
	}

}