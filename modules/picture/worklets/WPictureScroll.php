<?php
class WPictureScroll extends UWidgetWorklet
{
	public $space = 'outside';
	
	public function taskRenderOutput()
	{
		echo CHtml::link($this->t('Scroll to Top'),'#',array('id' => 'scrollToTop'));
		cs()->registerScript(__CLASS__,'$("#scrollToTop").click(function(){
			$.scrollTo("body", 500, {easing:"easeOutQuad"});
		});');
	}
}