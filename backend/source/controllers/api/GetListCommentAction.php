<?php
class GetListCommentAction extends CAction
{
    public function run()
    {
        $objectId= isset($_REQUEST['objectId']) ? $_REQUEST['objectId'] : '';
        $objectType = isset($_REQUEST['objectType']) ? $_REQUEST['objectType'] : '';
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';



        if (strlen($objectId) == 0 || strlen($objectType) == 0) {
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => 'ERROR',
                'data' => '',
                'message' => 'Required fields missing',)));
            Yii::app()->end();
        }

        $rows_per_page = 5;
        $start_index= ($page-1)*$rows_per_page;

        if($objectType == Constants::TYPE_FOOD)
        {
            $criteria = new CDbCriteria();
            $criteria->addCondition ('food_id ='.$objectId);
            $criteria->order = 'created DESC';
            $count = Comment::model()->count($criteria);
            $criteria->limit = $rows_per_page;
            $criteria->offset = $start_index;
            $comments = Comment::model()->findAll($criteria);
        }
        else
        {
            $criteria = new CDbCriteria();
            $criteria->addCondition ('location_id ='.$objectId);
            $criteria->order = 'created DESC';
            $count = Comment::model()->count($criteria);
            $criteria->limit = $rows_per_page;
            $criteria->offset = $start_index;
            $comments = Comment::model()->findAll($criteria);
        }

        $result = array();
        foreach($comments as $comment)
        {
            $result[] = array(
                'shop_id' => $comment->location_id,
                'food_id' => $comment->food_id,
                'account_id' => $comment->account_id,
                'title' => $comment->title,
                'content' => $comment->content,
                'rate' => $comment->rate,
                'created' => $comment->created,
            );
        }

        $allpage=ceil($count/$rows_per_page);


        ApiController::sendResponse(200, CJSON::encode(array(
            'status' => Constants::SUCCESS,
            'data' => $result,
            'count' => $count,
            'allpage'=>$allpage,
            'message' => '',)));
    }
}