<?php
class WBoardDeleteConfirm extends UConfirmWorklet
{
	public $json;
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function title()
	{
		return $this->t('Delete Board');
	}
	
	public function taskDescription()
	{
		return $this->t('Are you sure you want to permanently delete this board?');
	}
	
	public function taskYes()
	{
		wm()->get('board.delete')->delete($_GET['id']);
		$this->json = array('redirect' => app()->user->model()->url);
	}
	
	public function taskNo()
	{
		$this->json = array('content' =>
			array('append' => CHtml::script('$.uniprogy.dialogClose();')));
	}
	
	public function ajaxSuccess()
	{
		wm()->get('base.init')->addToJson($this->json);
	}
}