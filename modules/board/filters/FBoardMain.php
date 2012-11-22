<?php
class FBoardMain extends UWorkletFilter
{	
	public function filters()
	{
		return array(
			'board.update' => array('replace' => array('board.create')),
			'base.init' => array('behaviors' => array('board.rules')),
			'user.admin.delete' => array('behaviors' => array('board.userDelete')),
		);
	}
	
}