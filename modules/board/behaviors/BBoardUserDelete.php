<?php

class BBoardUserDelete extends UWorkletBehavior{
    
    public function afterDelete($id){
        $boards = MBoard::model()->findAll('userId=?',array($id));
        foreach ($boards as $board)           
            wm()->get('board.delete')->delete($board->id);
    }
}