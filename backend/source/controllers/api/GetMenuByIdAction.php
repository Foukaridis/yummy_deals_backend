<?php
class GetMenuByIdAction extends CAction
{

    public function run()
    {
        if (isset($_GET['m_id'])) {
            /** @var Menu $item */
            $item = Menu::model()->findByPk($_GET['m_id']);

            if ($item != null) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => array(
                        'menu_id' => $item->menu_id,
                        'menu_name' => $item->menu_name,
                        'menu_description' => $item->menu_id==null?'':$item->menu_desc,
                        'menu_thumbnail' =>$item->menu_small_thumbnail==null?'':SiteController::actionGetUrlImage($item->menu_id,$item->menu_small_thumbnail,DIRECTORY_MENU),
                        'status' => $item->status==null?'':$item->status,
                    ),
                    'message' => '',
                )));
            } else {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::ERROR,
                    'data' => '',
                    'message' => 'Not found!',
                )));
            }

        } else {
            ApiController::sendResponse(400, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => Yii::t('common', 'msg.badRequest'),
            )));
        }
    }

}