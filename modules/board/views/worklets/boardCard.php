<div class="boardCard">

	<div class="boardTitle"><?php echo $data->title; ?></div>

	<div class="boardMini clearfix"><?php
echo CHtml::link($data->mini, $data->link);
?></div>

	<div class="boardAction buttonLink"><?php
		if ($data->userId == app()->user->id || app()->user->checkAccess('administrator'))
			echo CHtml::link($this->t('Edit'), url('/board/update', array('id' => $data->id)));
		if ($data->userId != app()->user->id)
			echo wm()->get('network.helper')->followLink(null, $data);
		if ($data->userId == app()->user->id)
			echo CHtml::link(
					$this->t('Set Board Cover'), url('/board/cover/index', array('boardId' => $data->id)), array('class' => $data->postsCount ? 'lightbox' : 'uDialog')
			);
?></div>

</div><?php
		cs()->registerCssFile(asma()->publish(Yii::getPathOfAlias('board.css.board') . '.card.css'));