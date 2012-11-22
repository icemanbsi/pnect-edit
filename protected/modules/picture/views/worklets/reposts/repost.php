<div class='repost'><?php
$this->render('avatarAndInfo', array(
	'model' => $data->user,
	'info' => $this->t('{who} onto {board}', array(
		'{who}' => CHtml::link($data->user->name,$data->user->url),
		'{board}' => CHtml::link($data->board->title,$data->board->link)
	)),
));
?></div>