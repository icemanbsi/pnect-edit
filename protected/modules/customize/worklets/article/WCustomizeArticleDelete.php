<?php
class WCustomizeArticleDelete extends UDeleteWorklet
{
	public $modelClassName = 'MCmsArticle';
	
	public function accessRules()
	{
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users'=>array('*'))
		);
	}
}