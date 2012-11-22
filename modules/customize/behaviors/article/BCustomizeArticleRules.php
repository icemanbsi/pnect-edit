<?php
class BCustomizeArticleRules extends UWorkletBehavior
{
	public function afterUrlRules($rules)
	{
		return CMap::mergeArray($rules, array(
			'help/<view>' => 'customize/article/view',
		));
	}
}