<?php
class WPictureRepostsList extends UListWorklet
{
	public $modelClassName = 'MPictureRepostList';
	public $type = 'list';
	public $postId;
	public $count;
	public $limit;
	
	public function form(){
		return false;
	}	

	public function itemView()
	{
		return 'repost';
	}
	
	public function title()
	{
		return $this->count
			? $this->t('{#reposts_ucf}')
			: null;
	}

	public function beforeConfig(){
		$post = MPicturePost::model()->findByPk($this->postId);
		$this->count = $post->reposts;
		$this->limit = $this->module->params['reposts'];
		if(!$this->count)
			$this->show = false;
	}
	
	public function afterConfig()
	{
		$this->options['template'] = '{items}';
		$this->options['emptyText'] = '';
		$this->model->parentId = $this->postId;
	}

	public function taskRenderOutput()
	{
		$this->beginContent('list',array('more' => $this->count - $this->limit));
		parent::taskRenderOutput();
		$this->endContent();
	
		
	}
}