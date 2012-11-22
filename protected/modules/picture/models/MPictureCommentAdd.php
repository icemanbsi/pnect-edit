<?php

class MPictureCommentAdd extends MPictureComment {

	public $listId;
	public $asView;

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
			array('listId, asView', 'safe'),
		));
	}

}