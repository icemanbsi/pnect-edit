<?php
class WBoardSaveSortable extends UWidgetWorklet
{
	public $layout = false;
	
	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}
	
	public function taskConfig()
	{
		if(isset ($_GET['order']))
		{
			foreach ($_GET['order'] as $key => $value)
			{
				$board = MBoard::model()->findByPk($value);
				if($board && app()->user->checkAccess('board.edit', $board, false))
				{
					$board->sortOrder = $key;
					$board->save();
				}
			}
		}
	}
	
}