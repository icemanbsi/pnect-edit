<div class='clearfix'><?php
	echo $content;
?></div><?php
	if($more>0)
		echo $this->t('{more} more {#reposts}',array('{more}' => '<em>+'.$more.'</em>'));