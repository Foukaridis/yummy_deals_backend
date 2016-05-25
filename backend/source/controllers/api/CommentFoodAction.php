<?php

class CommentFoodAction extends CAction
{
    public function run()
    {
        $locationId = isset($_REQUEST['s_id']) ? $_REQUEST['s_id'] : '';
        $foodId = isset($_REQUEST['food_id']) ? $_REQUEST['food_id'] : '';
        $rate = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : '';
        $accountId = isset($_REQUEST['account_id']) ? $_REQUEST['account_id'] : '';
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $content= isset($_REQUEST['content']) ? $_REQUEST['content'] : '';

        if (strlen($locationId) == 0 || strlen($accountId) == 0 || strlen($content) == 0 || strlen($foodId) == 0 || strlen($rate) == 0) {
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => 'ERROR',
                'data' => '',
                'message' => 'Required fields missing',)));
            Yii::app()->end();
        }
		
        $comment = new Comment();
        $comment->location_id = $locationId;
        $comment->food_id = $foodId;
        $comment->account_id = $accountId;
		$comment->title = $title;
        $comment->content = $content;
        $comment->rate = $rate;
        $comment->created = DateTimeUtils::createInstance()->now();
        if($comment->save(false))
        {
            Constants::updateObjectRate($foodId,Constants::TYPE_FOOD);
            Constants::updateObjectRate($locationId,Constants::TYPE_SHOP);

            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::SUCCESS,
                'data' => '',
                'message' => 'Comment published',)));
        }
        else
        {
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => 'Fail to publish comment',)));
        }

    }
}