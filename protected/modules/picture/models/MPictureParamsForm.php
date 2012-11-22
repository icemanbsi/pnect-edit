<?php
class MPictureParamsForm extends UFormModel
{
	public $extensions;
	public $resizeLarge;
	public $resizeMedium;
	public $resizeSmall;
	public $url;
	public $likes;
	public $reposts;
	public $formula;
	public $words;
	public $minWidth;
	public $homepage;
	public $commentInCard;
	public $commentInView;
	public $commentLength;

	public static function module()
	{
		return 'picture';
	}
	
	public function rules()
	{
		return array(
			array(implode(',',array_keys(get_object_vars($this))),'safe'),
			array('url','required'),
		);
	}
}