<?php
class BPictureRules extends UWorkletBehavior
{
	public function afterUrlRules($rules)
	{
		$url = m('picture')->params['url'];
		$pictures = m('picture')->t('{#post_ns}');
		return CMap::mergeArray($rules, array(
			"$url/category/<category>" => 'picture/index',
			"$url/category/all" => 'picture/index',
			"$url/source/<domain>" => 'picture/source',
			"<username>/$pictures" => 'picture/user',
			"<username>/likes" => 'picture/likes/user',
			"$url" => 'picture/index',
			"$url/<id:\d+>/*" => 'picture/view',
			"$url/<url>*" => 'picture/<url>',
		));
	}
}