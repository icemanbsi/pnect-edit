<h3><?php echo $this->t('Thank you for your {#post_n}!'); ?></h3>
<div class="txt-center">
	<?php
	echo CHtml::button($this->t('Close'), array('id' => 'closeButton'));
	echo CHtml::button($this->t('View My {#post_n_ucf}'), array('id' => 'viewButton'));
	?>
</div>