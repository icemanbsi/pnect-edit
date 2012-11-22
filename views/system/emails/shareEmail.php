<?php
$mailer->Subject = m('picture')->t('{username} wants to share a {#post_n_ucf} with you from {site}', 
		array(
			'{username}' => $mailer->FromName,
			'{site}' => $site			
			)
		);
echo $this->t('Hi {user}',array('{user}'=>$messageRecipientName)); ?>,
<br/>
<?php echo m('picture')->t('{username} wants you to see a {#post_n} {link}, on {site}.',
		array(
			'{username}' => $mailer->FromName,
			'{link}' => CHtml::link($post->message,aUrl('/picture/view', array('id' => $post->id),'http')),
			'{site}' => $site
		));?> 
<br/>
					
<?php echo $this->t('{username} said:',array('{username}'=>$mailer->FromName));?>
<br/>

<?php echo $messageBody; ?>
<br/>

<?php if(isset($registerLink)&&$registerLink) echo m('picture')->t('{site} is a place to catalog all the things you love. Join and create your own boards: {link}.',
		array(
			'{site}' => $site,
			'{link}' => CHtml::link($this->t('here'),$registerLink),
		));?>

