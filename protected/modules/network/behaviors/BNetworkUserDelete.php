<?php

class BNetworkUserDelete extends UWorkletBehavior{
    
    public function afterDelete($id){
        
        MNetworkEvent::model()->deleteAll('userId=?',array($id));
        MNetworkFollowBoard::model()->deleteAll('userId=?',array($id));
        MNetworkFollowUser::model()->deleteAll('userId=? or followUserId=?',array($id,$id));
        MNetworkInvite::model()->deleteAll('userId=?',array($id));

    }
}