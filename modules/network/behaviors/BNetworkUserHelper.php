<?php
class BNetworkUserHelper extends UWorkletBehavior
{
	public function afterRegister($model)
	{
		if(isset($_GET['h']) && $_GET['h'])
		{
			$hash = wm()->get('network.helper')->validInvite($_GET['h']);
			if($hash && $hash->id)
			{
				wm()->get('network.helper')->follow($model,$hash,null);
				$hash->delete();
			}
		}
		return;
	}
}