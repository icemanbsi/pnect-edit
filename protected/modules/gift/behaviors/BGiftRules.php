<?php
class BGiftRules extends UWorkletBehavior
{
	public function afterUrlRules($rules)
	{
		return CMap::mergeArray($rules, array(
			'gift/<priceStart>-<priceEnd>' => 'gift/index'
		));
	}
}