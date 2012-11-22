<?php
class BBoardRules extends UWorkletBehavior
{
	public function afterCreateController($route,$owner,$value)
	{
		if($value===null)
		{
			$items = explode('/',$route);
			$username = $items[0];
			$url = isset($items[1])?$items[1]:null;
			
			$user = MUser::model()->find('username=?',array($username));
			if($user)
			{
				if($url)
				{
					$board = MBoard::model()->find('userId=? AND url=?', array(
						$user->id, $url
					));
					if($board)
						return app()->createController('board/view/id/'.$board->id,$owner);
				}
				return app()->createController('board/list/id/'.$user->id,$owner);
			}
			return;
		}
	}
	public function afterUrlRules($rules)
	{
		return CMap::mergeArray($rules, array(
			"board/cover/<boardId:\d+>/<postId:\d+>" => 'board/cover/index',
			"board/cover/<boardId:\d+>" => 'board/cover/index',
		));
	}
}