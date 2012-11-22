<?php
class WNetworkEventList extends UListWorklet
{
	public $modelClassName = 'MNetworkEvent';
	public $user;
	public $type = 'list';
	public $space = 'sidebar';
	
	public function afterConfig()
	{
		$this->model->userId = $this->user->id;
		$this->options['template'] = "{items}";
		$this->options['emptyText'] = '';
		$this->options['enablePagination'] = false;
	}
	
	public function dataProvider()
	{
		$dp = parent::dataProvider();
		$dp->pagination = array('pageSize' => 15);
		return $dp;
	}
	
	public function itemView()
	{
		return 'event';
	}
}