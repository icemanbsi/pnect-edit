<div class='clearfix'><?php
	echo $content;
?></div><?php
	if($more>0)
		echo $this->t('{more} more likes',array('{more}' => '<em>+'.$more.'</em>'));