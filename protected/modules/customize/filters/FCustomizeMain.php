<?php
class FCustomizeMain extends UWorkletFilter
{
	public function filters()
	{
		return array(
			'admin.menu' => array('behaviors' => array('customize.adminMenu')),
			'base.page' => array('behaviors' => array('customize.cms.page')),
			'base.menu' => array('behaviors' => array('customize.cms.baseMenu')),
			'base.init' => array('behaviors' => array('customize.cms.block', 'customize.article.rules')),
		);
	}
}