<?php

class FPictureMain extends UWorkletFilter {

	public function filters() {
		return array(
			'admin.menu' => array('behaviors' => array('picture.adminMenu')),
			'base.init' => array('behaviors' => array('picture.rules', 'picture.init')),
			'base.index' => array('replace' => 'index'),
			'user.admin.delete' => array('behaviors' => array('picture.userDelete')),
		);
	}

	public function index() {
		return app()->user->isGuest ? array('picture.index') 
			:(MBoard::model()->count('userId=?', array(app()->user->id)) ? m('picture')->params['homepage'] 
				: array('board.init'));
	}

}