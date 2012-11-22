<?php
class WBaseMenu extends UMenuWorklet
{
	public $space = 'menu';
	public $dropdown = true;
	
	public function accessRules()
	{
		return array(array('allow','users'=>array('*')));
	}
	
	public function properties()
	{
		$url = m('picture')->params['url'];
		return array(
			'items'=>array(
				array('label'=>$this->t('Users you follow'), 'url' => url('/picture/follow'),
					'visible' => !app()->user->isGuest),
				array('label'=>$this->t('Everything'), 'url' => url("$url/category/all"), 'items' => wm()->get('picture.category.helper')->categoriesMenu()),
				array('label'=>$this->t('Popular'), 'url' => array('/picture/popular')),
			),
			'htmlOptions'=>array(
				'class' => 'horizontal clearfix'
			),
			'options' => array(
				'delay' => 0,
				'speed' => 0
			)
		);
	}
}