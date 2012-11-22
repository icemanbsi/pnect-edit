<?php

class WPictureOriginal extends UWidgetWorklet {

	public function taskConfig() {
		if (!isset($_GET['bin']))
			return false;
		return parent::taskConfig();
	}

	public function taskRenderOutput() {
		Yii::import('uniprogy.extensions.image.Image');
		$bin = wm()->get('base.helper')->bin(MStorageBin::model()->findByPk($_GET['bin']));
		$image = new Image($bin->getFilePath('original'));
		echo CHtml::image($bin->getFileUrl('original'));
		cs()->registerCss(__CLASS__,'#wlt-PictureOriginal{ width: ' . $image->width . 'px; margin: 20px auto;  position: static;}');
	}

}
