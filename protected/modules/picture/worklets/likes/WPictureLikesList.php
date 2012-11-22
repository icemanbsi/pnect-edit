<?php
class WPictureLikesList extends UListWorklet
{
	public $modelClassName = 'MPictureLike';
	public $type = 'list';
	public $postId;
	public $count;
	public $limit;
	
	public function form(){
		return false;
	}	

	public function itemView()
	{
		return 'like';
	}
	
	public function title()
	{
		return $this->count
			? $this->t('1#Likes|n=2#Likes|n=3#Likes',array(2))
			: null;
	}

	public function beforeConfig(){
		$post = MPicturePost::model()->findByPk($this->postId);
		$this->count = $post->likesCount;
		$this->limit = $this->module->params['likes'];
		
		if(!$this->count)
			$this->show = false;
	}
	
	public function afterConfig()
	{
		$this->options['template'] = '{items}';
		$this->options['emptyText'] = '';
		$this->model->postId = $this->postId;
	}

	public function taskRenderOutput()
	{
		$this->beginContent('list',array('more' => $this->count - $this->limit));
		parent::taskRenderOutput();
		$this->endContent();
	
		
	}
}