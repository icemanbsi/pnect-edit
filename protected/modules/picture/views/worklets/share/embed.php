&lt;div style='width: {width}px;'>&lt;a href='<?php echo str_replace("<","&lt;", aUrl('/picture/view',array('id'=> $this->post()->id))); ?>' target='_blank'>&lt;img src='<?php echo $this->post()->img; ?>' border='0' width='{width}' height='{height}' />&lt;/a>&lt;p style='font-size: 10px;'><?php echo str_replace("<","&lt;", wm()->get('picture.helper')->channelShare($this->post())); ?>&lt;/p>&lt;/div>