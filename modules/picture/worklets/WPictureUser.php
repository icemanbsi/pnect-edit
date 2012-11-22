<?php
class WPictureUser extends UWidgetWorklet
{
	public function taskConfig()
	{
		$user = null;
		if(isset($_GET['username']))
			$user = MUser::model()->find('username=?',array($_GET['username']));
		
		if(!$user)
			throw new CHttpException(404,$this->t('The requested page does not exist.'));
		
		$c = new CDbCriteria;
		$c->compare('userId',$user->id);
		$options = array('criteria' => $c);
		
		wm()->add('board.user',null,array('user'=> $user));
		wm()->add('picture.profileMenu',null,array('user'=> $user));
		wm()->add('picture.list',null,array('dto'=>$options));
		
	}
}