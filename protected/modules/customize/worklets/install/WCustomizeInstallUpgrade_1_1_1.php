<?php

class WCustomizeInstallUpgrade_1_1_1 extends UInstallWorklet {

	public $fromVersion = '1.1.0';
	public $toVersion = '1.1.1';

	public function taskSuccess() {
		parent::taskSuccess();
		foreach (MCmsBlock::model()->findAll() as $model)
			wm()->get('customize.cms.helper')->saveContent('block.' . $model->id, $model->content);
		foreach (MCmsPage::model()->findAll() as $model)
			wm()->get('customize.cms.helper')->saveContent('page.' . $model->id, $model->content);
		foreach (MCmsArticle::model()->findAll() as $model)
			wm()->get('customize.cms.helper')->saveContent('article.' . $model->id, $model->content);
	}

}