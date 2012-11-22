<?php
class WPictureShareEmbed extends UFormWorklet
{	
	public function title()
	{
		return m('picture')->t('Embed {#post_n_ucf} on Your Blog');
	}
	
	public function taskPost()
	{
		static $post;
		if(!$post)
			$post = MPicturePost::model()->findByPk($_GET['post']);
		return $post;
	}
	
	public function taskImage()
	{
		static $i;
		if(!isset($i))
		{
			Yii::import('uniprogy.extensions.image.Image');
			$bin = wm()->get('base.helper')->bin($this->post()->picture->imageBin);
			$i = new Image($bin->getFilePath('large'));
		}
		return $i;
	}
	
	public function taskModel()
	{
		if(!$this->model){
			$this->model = new UDynamicModel;
			$names = 'embedImageWidth,embedImageHeight,embedHTMLCode';
			$rules = array(
				array($names, 'safe')
			);
			$this->model->import(explode(',', $names), $rules);
		}
		return $this->model;
	}
	
	public function properties()
	{
		$this->model->embedImageWidth = $this->image()->width;
		$this->model->embedImageHeight = $this->image()->height;
		
		return array(
			'elements' => array(
				'embedImageWidth' => array('type' => 'text', 'label' => $this->t('Width')),
				'embedImageHeight' => array('type' => 'text', 'label' => $this->t('Height')),
				'embedHTMLCode' => array('type' => 'textarea', 'label' => $this->t('HTML Code')),
			),
			'model' => $this->model
		);
	}

	public function afterRenderOutput()
	{
		$code = $this->render('embed', array(), true);
		cs()->registerScript(__CLASS__,'jQuery("#'.$this->getDOMId().'").uEmbed(
			"'.CJavaScript::quote($code).'"
		);');
	}		
}