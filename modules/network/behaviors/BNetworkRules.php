<?php
class BNetworkRules extends UWorkletBehavior
{
	public function afterUrlRules($rules)
	{
		return CMap::mergeArray($rules, array(
			"<username>/followers" => 'network/followers',
			"<username>/following" => 'network/following',
			"<username>/<board>/follow" => 'network/follow',
			"<username>/follow" => 'network/follow',
		));
	}
}