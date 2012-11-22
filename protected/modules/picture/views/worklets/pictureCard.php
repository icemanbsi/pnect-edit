<div class='pictureItem'><div class='pictureCard'>

	<div class='pictureButtons'><?php
		app()->controller->worklet('picture.buttons', array('post' => $data));
	?></div>
	
	<div class="pictureImage" style="height:<?php echo $data->picture->height?>px;"><?php 
		echo wm()->get('picture.helper')->cardContent($data);
	?></div>
	
	<div class="pictureMessage"><?php
		echo $data->message;
	?></div>
	
	<div class="pictureStats">
		<ul class='horizontal clearfix'><?php 
			if($data->likes)
				echo '<li>'.$data->likes.' '.$this->t('likes').'</li>';
			if($data->comments)
				echo '<li>'.$data->comments.' '.$this->t('comments').'</li>';
			if($data->reposts)
				echo '<li>'.$data->reposts.' '.$this->t('reposts').'</li>';
		?></ul>
	</div>
	
	<div class="pictureChannel"><?php
		echo wm()->get('picture.helper')->channelBrief($data);
	?></div>
	
	<div class="pictureComments">
		<?php app()->controller->worklet('picture.comment.list',array('postId'=>$data->id, 'itemView' => 'commentBrief'));?>
	</div>

</div></div>
