<?php

/**
 * Created by Only Love.
 * Date: 9/24/13
 * Time: 9:46 AM
 */
class ApiController extends Controller
{
    const   API_KEY = 'AIzaSyAoCZtjw7XPGiTCMq7FmOqXvwFA8B7UNLQ';

    public function filters()
    {
        return array();
    }

    public function actions()
    {
        return array(
            //shop :
            'getShopById' => 'backend.controllers.api.GetShopByIdAction',
            'getListShop' => 'backend.controllers.api.GetListShopAction',
            'getListShopByCity' => 'backend.controllers.api.GetListShopByCityAction',
            'getListShopByCategory' => 'backend.controllers.api.GetListShopByMenuAction',
            'getListShopByCityAndCategory' => 'backend.controllers.api.GetListShopByCityAndMenuAction',
            // category :
            'getListCategory' => 'backend.controllers.api.GetListMenuAction',
            'getListCategoryByShop' => 'backend.controllers.api.GetListMenuByShopAction',
            'getCategoryById' => 'backend.controllers.api.GetMenuByIdAction',
            //food :
            'getListFood' => 'backend.controllers.api.GetListFoodAction',
            'getListFoodByShopAndMenu' => 'backend.controllers.api.GetListFoodByShopAndMenuAction',
            'getListFoodOfDay' => 'backend.controllers.api.GetListFoodOfDayAction',
            'getListFoodByPromotion' => 'backend.controllers.api.GetListFoodByPromotionAction',
            'getFoodById' => 'backend.controllers.api.GetFoodByIdAction',

            //offer
            'getListPromotionByShop' => 'backend.controllers.api.GetListPromotionByShopAction',
            'getPromotionById' => 'backend.controllers.api.GetPromotionByIdAction',
            'getListPromotionOfDay' => 'backend.controllers.api.GetListPromotionOfDayAction',

            //banner
            'getListBannerByShop' => 'backend.controllers.api.GetListBannerByShopAction',

            //city
            'getListCity' => 'backend.controllers.api.GetListCityAction',

            //open hour
            'getListOpenHourByShop' => 'backend.controllers.api.GetListOpenHourByShopAction',

            //account
            'login' => 'backend.controllers.api.LoginAction',
            'register' => 'backend.controllers.api.RegisterAction',

            //order
            'sendOrder' => 'backend.controllers.api.SendOrderAction',
            'getOrderGroup' => 'backend.controllers.api.GetOrderGroupAction',
            'getOrderGroupDetail' => 'backend.controllers.api.GetOrderGroupDetailAction',
            //search
            'getListShopBySearch' => 'backend.controllers.api.GetListShopBySearchAction',
            'getListFoodBySearch' => 'backend.controllers.api.GetListFoodBySearchAction',

            'getFeedback' => 'backend.controllers.api.GetFeedbackAction',
            'getUserInfo' => 'backend.controllers.api.GetUserInfoByIdAction',
            'getUpdateUserInfo' => 'backend.controllers.api.GetUpdateUserByIdAction',
            'getUpdatePass' => 'backend.controllers.api.GetUpdatePassByIdAction',
            //Comment Food
            'commentFood' => 'backend.controllers.api.CommentFoodAction',
            'getListComment' => 'backend.controllers.api.GetListCommentAction',
            //28/11
            'requestShopOwner' => 'backend.controllers.api.RequestShopOwnerAction',
            //10/12
            'getDefaultLocation' => 'backend.controllers.api.GetDefaultLocation',
        );
    }

    public static function getStatusCodeMessage($status)
    {
        $codes = array(
            200 => 'OK',
            400 => 'ERROR: Bad request. API doesn\'t exist OR request failed due to some reason.',
        );

        return (isset($codes[$status])) ? $codes[$status] : null;
    }

    public static function sendResponse($status = 200, $body = '', $content_type = 'application/json')
    {
        header('HTTP/1.1 ' . $status . ' ' . self::getStatusCodeMessage($status));
        header('Content-type: ' . $content_type);
        if (trim($body) != '') echo $body;
        Yii::app()->end();
    }
}