<?php
class BPictureUserDelete extends UWorkletBehavior
{
    public function afterDelete($id)
	{
		// delete all user posts
        $posts = MPicturePost::model()->findAll('userId=?',array($id));
        foreach ($posts as $post)
            wm()->get('picture.delete')->delete($post->id);
		
		// delete all user comments
		MPictureComment::model()->deleteAll('userId=?', array($id));
		
		// delete all user likes
		MPictureLike::model()->deleteAll('userId=?', array($id));
		
		// delete all user reports
		MPictureReport::model()->deleteAll('userId=?', array($id));
		MPictureCommentReport::model()->deleteAll('userId=?', array($id));
    }
}