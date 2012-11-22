<?php
class WPictureCategoryImage extends UUploadWorklet
{
	public $modelClassName = 'MPictureCategoryImageForm';
	public $space = 'inside';
	
	public function title()
	{
		return $this->t('Upload Image');
	}
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function taskCategory()
	{
		static $cat;		
		if(!isset($cat))
			$cat = MPictureCategory::model()->findByPk(app()->request->getParam('id',null));
		return $cat;
	}
	
	public function properties()
	{
		return array(
			'action' => url('/picture/category/image', array('id' => app()->request->getParam('id',null))),
			'activeForm' => array(
				'class' => 'UActiveForm',
				'ajax' => false,
			),
			'enctype' => 'multipart/form-data',
			'elements' => array(
				CHtml::hiddenField('field','image'),
				CHtml::hiddenField('bin',$this->category()->image),
				'image' => app()->param('uploadWidget')
				? array(
					'type' => 'UUploadify',
					'options' => array(
						'script'=>url('/picture/category/image',array('id' => app()->request->getParam('id',null))),
						'auto'=>true,
						'multi'=>false,
						'binField' => isset($_GET['binField']) ? $_GET['binField'] : '',
					),
					'layout' => "{label}\n<fieldset>{input}</fieldset>\n{hint}",
				)
				: array('type' => 'file'),
			),
			'buttons' => !app()->param('uploadWidget')
			? array(
				'submit' => array('type' => 'submit', 'label' => $this->t('Upload'), 'id' => 'uploadButton'),
			)
			: array(),
			'model' => $this->model
		);
	}
	
	public function afterSave()
	{	
		if($this->bin)
		{
			$this->category()->image = $this->bin->id;
			$this->category()->save();
			$this->bin->makePermanent();
		}
	}
	
	public function afterDelete()
	{
		$this->category()->image = NULL;
		$this->category()->save();
	}
	
	public function ajaxSuccess()
	{
		parent::ajaxSuccess();
		$id = CHtml::getIdByName(CHtml::activeName($this->model,$_POST['field']));
		$binField = CHtml::getIdByName(CHtml::activeName($this->model,$_POST['field'].'-bin'));
		$content = $this->render('imageWithControls', array(
			'src' => $this->bin->getFileUrl('original').'?_r='.time(),
			'controls' => array(
				$this->t('Delete') => url('/picture/category/image', array('id' => app()->request->getParam('id',null), 'delete'=>1))
			),
		), true);
		wm()->get('base.init')->addToJson(array('content' => $content, 'close' => true));
	}
	
	public function successUrl()
	{
		return url('/picture/category/list');
	}
}