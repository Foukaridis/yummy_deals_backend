<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class GetListMenuAction extends CAction {

    public function run()
    {
        $menus=Menu::model()->findAll();
        $result = array();
        /** @var Menu $item */
        foreach($menus as $item){
            $result[] = array(
                'menu_id' => $item->menu_id,
                'menu_name' => $item->menu_name,
                'menu_description' => $item->menu_id==null?'':$item->menu_desc,
                'menu_thumbnail' =>$item->menu_small_thumbnail==null?'':SiteController::actionGetUrlImage($item->menu_id,$item->menu_small_thumbnail,DIRECTORY_MENU),
                'status' => $item->status==null?'':$item->status,
            );
        }

        if(count($result)){
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::SUCCESS,
                'data' => $result,
                'message' => '',
            )));
        }else{
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => 'Not found!',
            )));
        }
    }

}