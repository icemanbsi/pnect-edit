<?php
class WPictureDeleteConfirm extends UConfirmWorklet
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
		return $this->t('Delete {#post_n_ucf}');
	}
	
	public function taskDescription()
	{
		return $this->t('Are you sure you want to permanently delete this {#post_n}?');
	}
	
	public function taskYes()
	{
		wm()->get('picture.delete')->delete($_GET['id']);
		$this->json = array('redirect' => url('/'));
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