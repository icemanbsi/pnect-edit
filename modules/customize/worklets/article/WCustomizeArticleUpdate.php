<?php

class WCustomizeArticleUpdate extends UFormWorklet {

	public $modelClassName = 'MCmsArticleForm';
	public $primaryKey = 'id';

	public function title() {
		return $this->isNewRecord ? $this->t('Create New Article') : $this->t('Edit Article');
	}

	public function accessRules() {
		return array(
			array('allow', 'roles' => array('administrator')),
			array('deny', 'users' => array('*'))
		);
	}

	public function afterConfig() {
		if ($this->model->editorType)
			$this->model->plainText = $this->model->content;
		else {
			$this->model->editorType = 0;
			$this->model->wysiwyg = $this->model->content;
		}
	}

	public function properties() {
		return array(
			'elements' => array(
				'title' => array('type' => 'text', 'class' => 'large'),
				'url' => array('type' => 'text', 'hint' => aUrl('/help') . '/', 'layout' => "{label}\n<span class='hintInlineBefore'>{hint}\n{input}</span>"),
				'editorType' => array(
					'type' => 'radiolist',
					'items' => array(0 => $this->t('WYSIWYG Editor'), 1 => $this->t('Plain Text')),
					'layout' => "{label}\n<fieldset>{input}</fieldset>\n{hint}",
					'label' => $this->t('Editor Type'),
					'hint' => $this->t('Plain Text editor can accept PHP code.'),
				),
				'<div id="wysiwyg">',
				'wysiwyg' => array('type' => 'UCKEditor', 'layout' => "<div class='clearfix'>{label}</div>{input}\n{hint}",
					'label' => $this->t('WYSIWYG Editor')),
				'</div><div id="plainText">',
				'plainText' => array('type' => 'textarea',),
				'</div>',
				'order' => array('type' => 'text', 'class' => 'short'),
			),
			'buttons' => array(
				'submit' => array('type' => 'submit',
					'label' => $this->isNewRecord ? $this->t('Create') : $this->t('Save')),
			),
			'model' => $this->model
		);
	}

	public function beforeSave() {
		if (!$this->model->order) {
			$sql = "SELECT MAX(`order`) FROM {{CmsArticle}}";
			$max = app()->db->createCommand($sql)->queryScalar();
			$this->model->order = $max + 1;
		}
	}

	public function taskRenderOutput() {
		$att = 'editorType';
		$name = CHtml::resolveName($this->model, $att);
		cs()->registerScript(__CLASS__ . '.editorType', 'jQuery("#' . $this->getDOMId() . ' input[name=\'' . $name . '\']:radio").change(function(){
			if($(this).is(":checked"))
			{
				$("#wysiwyg").hide();
				$("#plainText").hide();
				if($(this).val()==0)
					$("#wysiwyg").show();
				else if($(this).val()==1)
					$("#plainText").show();
			}
		});jQuery("#' . $this->getDOMId() . ' input[name=\'' . $name . '\']:radio").change();');
		parent::taskRenderOutput();
	}

	public function ajaxSuccess() {
		$message = $this->isNewRecord ? $this->t('Article has been successfully created.') : $this->t('Article has been successfully saved.');
		$json = array(
			'info' => array(
				'replace' => $message,
				'fade' => 'target',
				'focus' => true,
			),
		);
		if ($this->isNewRecord)
			$json['redirect'] = url('/customize/article/update', array('ajax' => 1, 'id' => $this->model->id));

		wm()->get('base.init')->addToJson($json);
	}

	public function taskBreadCrumbs() {
		$bC = array();
		$bC[$this->t('Customize')] = url('/customize');
		$bC[$this->t('Help Articles')] = url('/customize/article/list');
		$bC[] = $this->title;
		return $bC;
	}

}