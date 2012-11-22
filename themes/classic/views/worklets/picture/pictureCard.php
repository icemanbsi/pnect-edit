<div class='pictureItem'><div class='pictureCard'>

	<div class='pictureButtons'><?php
		app()->controller->worklet('picture.buttons', array('post' => $data));
	?></div>
	
	<div class="pictureImage" style="height:<?php echo $data->picture->height?>px;"><?php 
		echo wm()->get('picture.helper')->cardContent($data);
	?></div>
	
	<?php if($data->likes || $data->comments || $data->reposts) { ?>
	<div class="pictureStats">
		<ul class='horizontal clearfix'><?php 
			if($data->likes)
				echo '<li class="likes"><span title="'.$this->t('Likes').'"><em></em>'.$data->likes.'</span></li>';
			if($data->comments)
				echo '<li class="comments"><span title="'.$this->t('Comments').'"><em></em>'.$data->comments.'</span></li>';
			if($data->reposts)
				echo '<li class="reposts"><span title="'.$this->t('{#reposts_ucf}').'"><em></em>'.$data->reposts.'</span></li>';
		?></ul>
	</div>
	<?php } ?>
		
	<div class="pictureMessage"><?php
		echo $data->message;
	?></div>
	
	<div class="pictureChannel <?php echo !$data->comments && app()->user->isGuest?'finish':''; ?>"><?php
		echo wm()->get('picture.helper')->channelBrief($data);
	?></div>
	
	<?php if($data->comments || !app()->user->isGuest) { ?>
	<div class="pictureComments finish">
		<?php app()->controller->worklet('picture.comment.list',array('postId'=>$data->id, 'itemView' => 'commentBrief'));?>
	</div>
	<?php } ?>

</div></div>