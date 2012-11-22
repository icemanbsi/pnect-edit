<?php

Yii::import('base.worklets.WBasePage', true);

class WCustomizeArticleView extends WBasePage {

	public $model;

	public function afterConfig() {
		wm()->get('base.init')->setState('admin', false);
		if (isset($_GET['view']) && ($model = MCmsArticle::model()->find('url=?', array($_GET['view']))) !== null) {
			$this->model = $model;
			$this->title = $model->title;
		}
	}

	public function taskRenderOutput() {
		wm()->get('customize.cms.helper')->readContent('article.' . $this->model->id);
	}

}