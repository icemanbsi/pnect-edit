<?php
class WBoardView extends UWidgetWorklet
{
	public function accessRules()
	{
		return array(array('allow','users'=>array('*')));
	}
	
	public function taskBoard()
	{
		static $b;
		if(!isset($b))
			$b = isset($_GET['id'])
				? MBoard::model()->findByPk($_GET['id'])
				: null;
		return $b;
	}
	
	public function taskConfig()
	{
		if($this->board())
		{
			$c = new CDbCriteria;
			$c->compare('boardId',$this->board()->id);
			$options = array('criteria' => $c);
			wm()->add('picture.list',null,array('dto'=>$options, 'position' => array('after' => $this->id)));
			wm()->add('base.menu');
			return parent::taskConfig();
		}
		throw new CHttpException(404,$this->t('The requested page does not exist.'));
	}
	
	public function taskRenderOutput()
	{
		$this->render('header');
	}
}