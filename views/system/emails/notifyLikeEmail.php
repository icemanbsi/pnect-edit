<?php $mailer->Subject = m('picture')->t('{user} liked your {#post_n}', array('{user}' => $user->name));?>
<br />
Hello <?php echo $post->user->name; ?>!
<br />
<?php echo CHtml::image($user->AvatarImg);?> <?php echo CHtml::link($user->name,$user->Url); ?> liked your <?php echo CHtml::link($post->message,aUrl('/picture/view', array('id'=>$post->id))) ?>
<br />
<?php app()->controller->renderPartial('/system/emails/signature'); ?>
