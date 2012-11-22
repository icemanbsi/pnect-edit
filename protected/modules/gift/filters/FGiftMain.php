<?php
class FGiftMain extends UWorkletFilter
{
    public function filters()
	{
        return array(
            'picture.helper' => array('behaviors' => array('gift.pictureHelper')),
            'picture.post' => array('behaviors' => array('gift.picturePost')),
            'picture.edit' => array('behaviors' => array('gift.pictureEdit')),
            'picture.view' => array('behaviors' => array('gift.pictureView')),
            'base.menu' => array('behaviors' => array('gift.baseMenu')),
			'base.init' => array('behaviors' => array('gift.rules','gift.baseInit')),
        );
    }
}