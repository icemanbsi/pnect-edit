<?php
class WBaseTopMenu extends UMenuWorklet
{	
	public $dropdown = true;
	
	public function accessRules()
	{
		return array(array('allow','users'=>array('*')));
	}
	
	public function properties()
	{
		$props = array(
			'items'=>array(
				array('label'=>$this->t('Login'),
					'url'=>array('/user/login'),
					'visible' => app()->user->isGuest),
				array('label'=>$this->t('Sign Up'),
					'url'=>array('/user/signup'),
					'visible' => app()->user->isGuest && !param('inviteOnly')),
				array('label'=>$this->t('Add'),
					'url'=>array('/picture/options'), 'linkOptions'=>array('class' => 'uDialog'),
					'visible' => !app()->user->isGuest),
			),
			'htmlOptions'=>array(
				'class' => 'horizontal clearfix'
			),
			'options' => array(
				'delay' => 0,
				'speed' => 0
			),
			'encodeLabel' => false,
		);
		
		$props['items'] = array_merge($this->help(),$props['items']);
		if(!app()->user->isGuest)
			$props['items'] = array_merge($props['items'], wm()->get('user.helper')->menu());
		
		return $props;
	}
	
	public function taskHelp()
	{
		$items = array();
		
		$articles = MCmsArticle::model()->findAll(array(
			'order' => '`order` ASC'
		));
		foreach($articles as $a)
			$items[] = array('label' => m('picture')->t($a->title),
				'url' => url('/customize/article/view', array('view' => $a->url)));
		
		$items[] = array('label' => $this->t('Privacy Policy'),
			'url' => url('/base/page', array('view' => 'privacy')));
		
		$items[] = array('label' => $this->t('Terms of Use'),
			'url' => url('/base/page', array('view' => 'terms')));
		
		$items[] = array('label' => $this->t('Contact Us'),
			'url' => url('/base/contact'));
		
		$items[] = array('label' => m('picture')->t('{#post_button}'),
			'url' => url('/picture/info'));
		
		$first = $items[0];
		
		$item = array('label' => $this->t('Help'),
			'url' => $first['url'], 'items' => $items);
		
		return array($item);
	}
}