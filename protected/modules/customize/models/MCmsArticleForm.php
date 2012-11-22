<?php

class MCmsArticleForm extends MCmsArticle {

	public $plainText;
	public $wysiwyg;

	public function rules() {
		return array(
			array('title,content,url,editorType', 'required'),
			array('url', 'unique', 'className' => 'MCmsArticle', 'message' => $this->t('This URL is already taken.')),
			array('order', 'safe'),
			array('plainText,wysiwyg', 'safe'),
		);
	}

	public function attributeLabels() {
		return array(
			'title' => $this->t('Title'),
			'url' => $this->t('URL'),
			'content' => $this->t('Content'),
			'order' => $this->t('Order Position'),
			'editorType' => $this->t('Editor Type'),
		);
	}

	public function beforeValidate() {
		$this->content = $this->editorType ? $this->plainText : $this->wysiwyg;
		return parent::beforeValidate();
	}

	public function afterSave() {
		parent::afterSave();
		wm()->get('customize.cms.helper')->saveContent('article.' . $this->id, $this->content);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

}