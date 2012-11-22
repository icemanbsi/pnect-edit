<?php echo $this->t('Click the button of your choice below to select the HTML code to embed. Then copy and paste the code onto your site where you\'d like it to appear.');?>
<br/>
<br/>
<div class='box clearfix append-bottom'>
	<div class='column'><?php echo $this->image('long'); ?></div>
	<div class='description'><?php
		echo CHtml::textField('long', $this->input('long'));
	?></div>
</div>
<div class='box clearfix append-bottom'>
	<div class='column'><?php echo $this->image('short'); ?></div>
	<div class='description'><?php
		echo CHtml::textField('short', $this->input('short'))
	?></div>
</div>
<div class='box clearfix append-bottom'>
	<div class='column'><?php echo $this->image('big'); ?></div>
	<div class='description'><?php
		echo CHtml::textField('big', $this->input('big'))
	?></div>
</div>
<div class='box clearfix append-bottom'>
	<div class='column'><?php echo $this->image('small'); ?></div>
	<div class='description'><?php
		echo CHtml::textField('small', $this->input('small'))
	?></div>
</div>
<?php
echo $this->t('The follow buttons act similarly to any linked image on your site. They can be used inline with your content or as a part of a sidebar.');

