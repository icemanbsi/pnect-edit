<?php
class BGiftBaseInit extends UWorkletBehavior
{
	public function beforeRenderPage()
	{
		wm()->get('gift.helper')->css();
	}
}