<?php

class MPictureForm extends MPicturePost {

	public $imageUrl;
	public $boardType = 0;
	public $boardTitle;
	public $categoryId;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return array(
			array('message', 'required'),
			array('source', 'url', 'on' => 'update'),
			array('imageUrl, parentId, source', 'safe', 'on' => 'insert'),
			array('boardId, boardType, categoryId', 'safe'),
			array('boardTitle', 'checkBoardType'),
		);
	}

	public function checkBoardType() {

		if ($this->boardType) {
			if(!$this->boardTitle){
				$this->addError('boardTitle', $this->t('{attribute} cannot be blank.',array('{attribute}'=>$this->t('Board Title'))));
				return FALSE;
			}
			$title = htmlspecialchars($this->boardTitle);
			$board = MBoard::model()->find('userId=? AND title=?', array(app()->user->id, $this->boardTitle));
			if ($board && $board->id != $this->boardId)
				$this->boardId = $board->id;
			else {
				$board = new MBoard;
				$board->userId = app()->user->id;
				$board->title = $title;
				$board->access = 0;
				$board->categoryId = $this->categoryId;
				$board->save();

				$board->url = wm()->get('board.helper')->url($board);
				$board->save();

				$board->sortOrder = $board->id;
				$board->save();
				wm()->get('network.helper')->autoFollow($board);
				
				$this->boardId = $board->id;
			}
		}elseif(!$this->boardId){
				$this->addError('boardId', $this->t('{attribute} cannot be blank.',array('{attribute}'=>$this->t('Board'))));
				return FALSE;
		}
	}

	public function attributeLabels() {
		return array(
			'boardTitle' => $this->t('Board Title'),
			'boardId' => $this->t('Board'),
			'message' => $this->t('Description'),
			'source' => $this->t('Link'),
		);
	}

	public function beforeSave() {
		if ($this->source)
			$this->sourceDomain = wm()->get('picture.helper')->domain($this->source);
		return parent::beforeSave();
	}

}