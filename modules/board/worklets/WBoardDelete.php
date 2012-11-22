<?php
class WBoardDelete extends UDeleteWorklet
{
	public $modelClassName = array(
		'MBoard' => 'id',
                'MBoardUser' => 'boardId',
	);
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function beforeDelete($id)
	{
		$b = MBoard::model()->findByPk($id);
		if(!app()->user->checkAccess('board.edit', $b, false))
		{
			$this->accessDenied();
			return false;
		}
                $posts = MPicturePost::model()->findAll('boardId=?',array($id));
                foreach ($posts as $post)
                    wm()->get('picture.delete')->delete($post->id);
                
                MNetworkFollowBoard::model()->deleteAll('boardId=?',array($id));
	}
}