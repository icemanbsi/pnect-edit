<?php

class WBoardInit extends UFormWorklet {

	public function title() {
		return $this->t('Create Your First Boards');
	}

	public function accessRules() {
		return array(
			array('deny', 'users' => array('?'))
		);
	}

	public function taskConfig() {
		parent::taskConfig();
		wm()->add('board.initSide');
	}

	public function properties() {
		return array(
			'action' => url('/board/init'),
			'elements' => array(
				$this->render('category', null, true),
				$this->render('boards', null, true),
			),
			'buttons' => array(
				'add' => array('type' => 'button', 'label' => $this->t('Add'), 'class' => 'addBoardButton'),
				'create' => array('type' => 'submit', 'label' => $this->t('Create')),
			)
		);
	}

	public function taskSave() {
		if (isset($_POST['boards']) && count($_POST['boards'])) {
			foreach ($_POST['boards'] as $title) {
				$title = trim($title);
				if ($title) {
					$title = htmlspecialchars($title);
					$exists = MBoard::model()->exists('title=? AND userId=?', array($title, app()->user->id));
					if (!$exists) {
						$board = new MBoard;
						$board->userId = app()->user->id;
						$board->title = $title;
						$board->access = 0;
						$board->categoryId = $_POST['categoryId'];
						$board->save();

						$board->url = wm()->get('board.helper')->url($board);
						$board->save();

						$board->sortOrder = $board->id;
						$board->save();
						wm()->get('network.helper')->autoFollow($board);
					}
				}
			}
		}
	}

	public function taskRenderOutput() {
		parent::taskRenderOutput();

		$script = 'jQuery("#wlt-BoardInit .addBoardButton").click(function(){
				$(".boardsList").append("' . $this->render('newBoard', array(), true) . '");
				return false;
			});';
		cs()->registerScript(__CLASS__, $script);
	}

	public function ajaxSuccess() {
		wm()->get('base.init')->addToJson(array(
			'content' => array(
				'append' => CHtml::script('window.location="'.aUrl('/picture/options').'";'),
			)
		));
	}

}