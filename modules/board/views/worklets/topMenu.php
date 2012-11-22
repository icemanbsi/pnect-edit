<div class='clearfix profileTopMenu'>
	<div class='column'><?php
		app()->controller->worklet('picture.profileMenu', array('user' => $this->user));
	?></div>
	<?php if(app()->user->id == $this->user->id){ ?>
	<div class='floatRight'>
		<div id='startButton'><?php
			echo CHtml::button($this->t('Rearrange Boards'), array('id' => 'StartOrder'));
		?></div>
		<div class='clearfix' id='OrderControls' style='display: none'>
			<div class='column'><?php echo $this->t('Drag-n-drop boards to rearrange them.'); ?></div>
			<div class='column'><?php
				echo CHtml::button($this->t('Cancel'), array('id' => 'CancelOrder'));
			?></div>
			<div class='column'><?php
				echo CHtml::button($this->t('Save Arrangement'), array('id' => 'SaveOrder'));
			?></div>
		</div>
	</div>
	<?php } ?>
</div>