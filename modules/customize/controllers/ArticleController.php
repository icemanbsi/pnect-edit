<?php
class ArticleController extends UController
{
	protected function beforeAction($action)
	{
		wm()->get('base.init')->setState('admin',true);
		return parent::beforeAction($action);
	}
}