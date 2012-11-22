<?php
class WPictureAdd extends UFormWorklet
{
	public $modelClassName = 'UDummyModel';
	public $images = array();
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function title()
	{
		return m('picture')->t('Add a {#post_n_ucf}');
	}
	
	public function properties()
	{
		return array(
			'elements' => array(
				'attribute' => array('type' => 'text', 'label' => $this->t('URL')),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => $this->t('Find Images'))
			),
			'model' => $this->model
		);
	}
	
	public function taskSave()
	{
		if(!$this->model->attribute)
			return $this->model->addError('attribute', $this->t('Please input URL of an image or a site.'));
		
		$parsUrl = parse_url($this->model->attribute);
		if(!isset($parsUrl['scheme']) || (isset($parsUrl['scheme'])&&!$parsUrl['scheme']))
			$this->model->attribute = 'http://'.$this->model->attribute;
		
		$validator = new CUrlValidator;
		if(!$validator->validateValue($this->model->attribute))
			return $this->model->addError('attribute', $this->t('Invalid URL.'));
		
		$images = wm()->get('picture.helper')->imagesFromUrl($this->model->attribute);
		
		$this->images = $images;
	}
	
	public function ajaxSuccess()
	{
		$images = CJavaScript::jsonEncode($this->images);
		wm()->get('base.init')->addToJson(array(
			'keepDisabled' => true,
			'content' => array('appendReplace' => CHtml::script('$.uniprogy.picture.post.load('
					. $images.',"'.CJavaScript::quote($this->model->attribute).'");'))
		));
	}
	
	public function afterBuild()
	{
		wm()->add('picture.post', null, array('position' => array('after' => $this->id)));
	}
	
	public function afterRenderOutput()
	{
		cs()->registerScript(__CLASS__,'$("#'.$this->form->id.'").submit(function(){
			$.uniprogy.picture.post.disable();
		});');
	}
}