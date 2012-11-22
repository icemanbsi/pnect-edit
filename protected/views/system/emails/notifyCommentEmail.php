<?php $mailer->Subject = m('picture')->t('{user} commented on your {#post_n}', array('{user}' => $user->name));?>
<br />
Hello <?php echo $post->user->name; ?>!
<br />
<?php echo CHtml::image($user->AvatarImg);?> <?php echo CHtml::link($user->name,$user->Url); ?> commented on your <?php echo CHtml::link($post->message,aUrl('/picture/view', array('id'=>$post->id))) ?>
<br />
<?php app()->controller->renderPartial('/system/emails/signature'); ?>
