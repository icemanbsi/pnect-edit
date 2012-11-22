<div class="boardCard">

	<div class="boardTitle">
		<?php echo $data->title; ?>
	</div>

	<div class="boardMini clearfix">
		<?php echo CHtml::link($data->getMini($cover), $data->link); ?>
	</div>

	<div class="boardAction buttonLink">
		<?php echo CHtml::button('<', array('class' => 'prev')); ?>
		<?php echo CHtml::button($this->t('Set Cover'), array('type' => 'submit'));?>
		<?php echo CHtml::button('>', array('class' => 'next')); ?>
	</div>

</div>
<?php
cs()->registerCssFile(asma()->publish(Yii::getPathOfAlias('board.css.board') . '.card.css'));