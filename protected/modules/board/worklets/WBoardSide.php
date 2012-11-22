<?php
class WBoardSide extends UWidgetWorklet
{
	public $space = 'sidebar';
	public $board;
	
	public function taskRenderOutput()
	{
		$this->render('boardCard',array('data' => $this->board));
	}
}