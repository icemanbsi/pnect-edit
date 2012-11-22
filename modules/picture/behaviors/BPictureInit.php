<?php
class BPictureInit extends UWorkletBehavior
{
	public function afterRegisterScripts()
	{
		cs()->registerCssFile(asma()->publish(Yii::getPathOfAlias('picture.css.picture').'.css'));
		cs()->registerScriptFile(asma()->publish(Yii::getPathOfAlias('picture.js.picture').'.js'));
		cs()->registerScript(__CLASS__,'$.uniprogy.picture.init('. CJavaScript::encode(array(
			'baseUrl' => aUrl('/'),
			'isGuest' => (app()->user->isGuest?true:false),
			'commentLength' => m('picture')->params['commentLength']?m('picture')->params['commentLength']:500,
		)).');');
	}
}