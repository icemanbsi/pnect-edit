<?php
class WPictureEdit extends UFormWorklet
{
	public $modelClassName = 'MPictureForm';
	public $primaryKey = 'id';
	public $original;
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function beforeAccess()
	{
		$model = $this->model();
		if(!$model || !app()->user->checkAccess('post.edit', $model, false))
		{
			$this->accessDenied();
			return false;
		}
	}
	
	public function afterConfig()
	{
		$this->original = clone $this->model;
		$this->model->message = html_entity_decode($this->model->message);
	}
	
	public function beforeSave()
	{
		$this->model->message = htmlspecialchars($this->model->message);
	}

	public function properties()
	{
		return array(
			'elements' => array(
				'message' => array('type' => 'textarea'),
				'source' => array('type' => 'text'),
				'boardId' => array('type' => 'dropdownlist',
					'items' => wm()->get('picture.helper')->boards()),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => $this->t('Save {#post_n_ucf}')),
				'delete' => array('type' => 'UJsButton', 'attributes' => array(
					'label' => $this->t('Delete {#post_n_ucf}'),
					'callback' => '$.uniprogy.dialog("'.url('/picture/deleteConfirm', array('id' => $_GET['id'])).'");')),
			),
			'model' => $this->model
		);
	}

	public function ajaxSuccess()
	{
		$json = array(
			'info' => array(
				'replace' => $this->t('{#post_n_ucf} has been successfully updated.'),
				'fade' => 'target',
				'focus' => true,
			),
		);
		wm()->get('base.init')->addToJson($json);
	}
}