<?php
class WBoardInstallInstall extends UInstallWorklet
{
	public function taskModuleParams()
	{
		return CMap::mergeArray(parent::taskModuleParams(),array (
			'allowBoardUrl' => '0',
			'newBoards' => 'Products I Love
Favorite Places & Spaces
Books Worth Reading
My Style
For the Home
Dream Home
Neighborhood Finds
Wedding Ideas
Favorite Recipes
Craft Ideas
Things for My Wall
Places I\'d Like to Go
People I Admire
Party Ideas
Kid\'s Room',
		));
	}

	public function taskModuleFilters()
	{
		return array(
			'board' => 'board.main',
			'base' => 'board.main',
			'user' => 'board.main',
		);
	}
	
	public function taskModuleAuth()
	{
		return array(
			'items' => array(	
				'board.editor' => array(1,NULL,'return $params->userId == app()->user->id;',NULL),
				'board.edit' => array(1,'Board edit access',NULL,NULL),
			),
			'children' => array(
				'user' => array('board.editor'),
				'board.editor' => array('board.edit'),
				'administrator' => array('board.edit')
			),
		);
	}
}