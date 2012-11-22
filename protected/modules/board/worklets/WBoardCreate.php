<?php

class WBoardCreate extends UFormWorklet {

	public $modelClassName = 'MBoardForm';
	public $primaryKey = 'id';

	public function beforeBuild() {
		if (isset($_POST['checkUsername'])) {
			$this->checkUsername();
			return false;
		}
	}

	public function accessRules() {
		return array(
			array('deny', 'users' => array('?'))
		);
	}

	public function title() {
		return $this->isNewRecord ? $this->t('Create Board') : $this->t('Update Board');
	}

	public function properties() {
		$buttons = array();
		$buttons['submit'] = array('type' => 'submit',
			'label' => $this->isNewRecord ? $this->t('Create') : $this->t('Update'));
		if (!$this->isNewRecord)
			$buttons['delete'] = array('type' => 'UJsButton', 'attributes' => array(
					'label' => $this->t('Delete'),
					'callback' => '$.uniprogy.dialog("' . url('/board/deleteConfirm', array('id' => $_GET['id'])) . '");'));

		if ($this->isNewRecord)
			$this->model->access = 0;

		return array(
			'elements' => array(
				'title' => array('type' => 'text'),
				'description' => array('type' => 'textarea',),
				'categoryId' => array('type' => 'dropdownlist', 'label' => $this->t('Category'),
					'items' => wm()->get('picture.category.helper')->categoryAsList()),
				'access' => array('type' => 'radiolist', 'items' => array(
						0 => $this->t('Just Me'),
						1 => $this->t('Me + Contributors'),
					), 'layout' => "{label}\n<fieldset>{input}</fieldset>\n{hint}"),
				'openDiv' => '<div id="usernamesFieldDiv" style="display:none">',
				'usernamesField' => array('type' => 'UJsButton', 'attributes' => array(
						'label' => $this->t('Add'),
						'callback' => '$.uniprogy.board.load();'
					), 'layout' => '{label}<fieldset>' . CHtml::textField('username', '', array('id' => 'username')) . '{input}</fieldset>{hint}',
					'hint' => '<div id="selectedUsernames"></div>'),
				'closeDiv' => '</div>',
				'selectedUsernames' => ''
			),
			'buttons' => $buttons,
			'model' => $this->model
		);
	}

	public function taskSave() {
		$data = $this->model->attributes;
		$data['usernames'] = isset($_POST['usernames']) && is_array($_POST['usernames']) ? $_POST['usernames'] : array();

		if ($this->isNewRecord) {
			$this->model->userId = app()->user->id;
			$this->model->save();
		}

		$this->model->url = wm()->get('board.helper')->url($this->model);
		$this->model->save();

		if ($this->isNewRecord) {
			$this->model->sortOrder = $this->model->id;
			$this->model->save();
		}

		MBoardUser::model()->deleteAll('boardId=?', array($this->model->id));

		foreach ($data['usernames'] as $l) {
			$m = new MBoardUser;
			$m->boardId = $this->model->id;
			$m->userId = $l['id'];
			$m->save();
		}
	}

	public function beforeSave() {
		$this->model->title = htmlspecialchars($this->model->title);
		$this->model->description = htmlspecialchars($this->model->description);
	}

	public function beforeConfig() {
		$this->model->title = html_entity_decode($this->model->title);
		$this->model->description = html_entity_decode($this->model->description);
	}

	public function afterSave() {
		wm()->get('network.helper')->autoFollow($this->model);
	}

	public function taskRenderOutput() {
		$usernames = array();
		if (is_array($this->model->usernames) && count($this->model->usernames))
			foreach ($this->model->usernames as $l) {
				if (!isset($l->userId->username))
					continue;
				$usernames[$l->userId] = $l->user->username;
			}

		$script = '$.uniprogy.board.init(' . CJavaScript::encode($usernames) . ');';
		cs()->registerScript(__CLASS__, $script);

		$att = 'access';
		$name = CHtml::resolveName($this->model, $att);
		cs()->registerScript(__CLASS__ . '.toggle', 'jQuery("#' . $this->getDOMId() . ' input[name=\'' . $name . '\']:radio").change(function(){
			$("#usernamesFieldDiv").hide();
			if($(this).is(":checked"))
			{
				if($(this).val() == "1")
					$("#usernamesFieldDiv").show();
			}
		});jQuery("#' . $this->getDOMId() . ' input[name=\'' . $name . '\']:radio").change();');

		parent::taskRenderOutput();
	}

	public function ajaxSuccess() {
		wm()->get('base.init')->addToJson(array(
			'content' => array(
				'append' => CHtml::script('$.uniprogy.dialogClose();window.location="' . $this->model->link . '";'),
			)
		));
	}

	public function taskCheckUsername() {
		$json = array();
		$u = MUser::model()->find('username=? or email=?', array($_POST['checkUsername'], $_POST['checkUsername']));
		if (!$u)
			$json['error'] = $this->t('Such user doesn\'t exist.');
		else
			$json = array(
				'username' => $u->username,
				'id' => $u->id
			);

		wm()->get('base.init')->addToJson($json);
	}

}