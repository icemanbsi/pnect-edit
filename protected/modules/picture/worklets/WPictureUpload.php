<?php
class WPictureUpload extends UUploadWorklet
{
	public $modelClassName = 'MPictureUploadForm';
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function title()
	{
		return $this->t('Upload Image');
	}
	
	public function properties()
	{
		return array(
			'action' => url('/picture/upload'),
			'activeForm' => array(
				'class' => 'UActiveForm',
				'ajax' => false,
			),
			'enctype' => 'multipart/form-data',
			'elements' => array(
				CHtml::hiddenField('field','image'),
				'image' => app()->param('uploadWidget')
				? array(
					'type' => 'UUploadify',
					'options' => array(
						'script'=>url('/picture/upload'),
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
	
	public function taskScript()
	{
		if($this->bin){
			$images = CJavaScript::jsonEncode(array($this->bin->getFileUrl('original')));
			return '$.uniprogy.picture.post.load('. $images.',"'.CJavaScript::quote($this->bin->id).'");';
		}
		return;
	}
	
	public function ajaxSuccess()
	{
		if($this->script())
			wm()->get('base.init')->addToJson(array(
				'worklet' => 
					array('content' => 
						array('appendReplace' => CHtml::script($this->script())))
			));
		else
			parent::ajaxSuccess();
	}
	
	public function afterSave()
	{
		if($this->bin)
			$this->successUrl = url('/picture/upload', array('bin' => $this->bin->id));
	}
	
	public function afterBuild()
	{
		wm()->add('picture.post', null, array('position' => array('after' => $this->id)));
	}
	
	public function beforeBuild()
	{
		if(isset($_GET['bin']))
		{
			$this->bin = wm()->get('base.helper')->bin($_GET['bin']);
			$this->layout = false;
			cs()->registerScript('$.uniprogy.picture.post.load',$this->script());
		}
	}

	public function taskRenderOutput()
	{
		if(!isset($_GET['bin']))
			parent::taskRenderOutput();
	}
}