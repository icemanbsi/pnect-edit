<?php $url = url('/picture/source', array('domain' => $this->post->sourceDomain)); ?>
<div class="boardCard moreCard">
	
	<div class="boardTitle"><?php echo $this->t('More from {source}', array(
		'{source}' => CHtml::link($this->post->sourceDomain, $url)
	)); ?></div>
	
	<div class="boardMini"><?php
		echo CHtml::link($this->more,$url,array('class' => 'clearfix'));
	?></div>
		
</div><?php
cs()->registerCssFile(asma()->publish(Yii::getPathOfAlias('board.css.board').'.card.css'));