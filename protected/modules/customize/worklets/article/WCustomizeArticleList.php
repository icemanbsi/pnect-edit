<?php
class WCustomizeArticleList extends UListWorklet
{
	public $modelClassName = 'MCmsArticle';
	
	public function title()
	{
		return $this->t('Help Articles');
	}
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
	
	public function columns()
	{
		return array(
			array('header' => $this->t('Title'), 'name' => 'title'),
		);
	}
	
	public function buttons()
	{
		return array(
			$this->widget('UJsButton', array(
				'label' => $this->t('Create New Article'),
				'callback' => 'window.location = "'.url('/customize/article/update').'";',
			), true)
		);
	}
	
	public function taskBreadCrumbs()
	{
		$bC = array();
		$bC[$this->t('Customize')] = url('/customize');
		$bC[$this->t('Help Articles')] = url('/customize/article/list');
		return $bC;
	}
}