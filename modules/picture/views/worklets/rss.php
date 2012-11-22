<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
	<channel>
    	<title><?php echo app()->name; ?> » <?php
    		echo $this->user->name;
    	?></title>
    	<description><?php echo $this->user->about; ?></description>
    	<link><?php echo $this->link($this->user); ?></link>
    	<?php foreach($this->posts as $post) { ?>
    	<item>
    		<title><?php echo htmlspecialchars($post->message); ?></title>
    		<description>
    			<?php echo htmlspecialchars(CHtml::image($post->medium,$post->message));?>
    		</description>
    		<link><?php echo htmlspecialchars(aUrl('/picture/view',array('id'=>$post->id))); ?></link>
    		<pubDate><?php echo date('r',$post->created); ?></pubDate>
    	</item>
    	<?php } ?>
	</channel>
</rss>
