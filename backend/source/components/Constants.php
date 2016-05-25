<?php

/**
 * Created by Lorge
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:33 AM
 */
class Constants
{
    const
        LAYOUT_MAIN = "//layouts/main",
        LAYOUT_LOGIN = "//layouts/login",
        LAYOUT_EMPLOYEE = "//layouts/employee",
        LAYOUT_ERROR = "//layouts/error";
    const
        TYPE_PRODUCT = 'products',
        TYPE_BANNER = 'banner',
        SUCCESS = 'success',
        ERROR = 'error',

        NO_IMAGE = 'noImage.jpg';

    const
        ROLE_ADMIN = 2,
        ROLE_SHOP_OWNER = 1,
        ROLE_CUSTOMER = 0,
        ROLE_CHEF = 3,
        ROLE_DELIVERYMAN = 4,
        ROLE_MODERATOR = 5;

    const GLOBALS_CURRENCY = '$',
        FINANCE_STATUS_PENDING = 0,
        FINANCE_STATUS_APPROVED = 1;

    const
        STATUS_ACTIVE = 1,
        STATUS_INACTIVE = 0,
        AVAILABLE = 1,
        OUT_OF_STOCK = 0;

    const FLAT_RATE = 'flat_rate',
        FREE_SHIPPING = 'free_shipping',
        LOCAL_PICKUP = 'local_pickup',
        TAX_NAME = 'VAT';

    const
        ORDER_NEW = 0,
        ORDER_IN_PROCESS = 1,
        ORDER_READY = 2,
        ORDER_ON_THE_WAY = 3,
        ORDER_DELIVERED = 4,
        ORDER_CANCEL = 5,
        ORDER_FAIL_DELIVERY = 6;
    const
        SEARCH_RANGE = 1,
        TYPE_FOOD = 'food',
        TYPE_SHOP = 'shop';

    const
        ACCOUNT_NORMAL = 0,
        ACCOUNT_FACEBOOK = 1;

    const
        ACTIVE_ACCOUNT = 1,
        INACTIVE_ACCOUNT = 0;

    const
        SIZE_PER_PAGE = 10;

    public static function convertTime($time, $sourceTimezone, $destinationTimezone)
    {
        //$date = new DateTime('11:30 AM', new DateTimeZone('Asia/Bangkok'));
        $date = new DateTime($time, new DateTimeZone($sourceTimezone));

        //$date->setTimezone(new DateTimeZone('GMT'));
        $date->setTimezone(new DateTimeZone($destinationTimezone));

        return $date->format('h:i A');
    }

    public static function convertObjectTime($object, $sourceTimezone, $destinationTimezone)
    {
        //$date = new DateTime('11:30 AM', new DateTimeZone('Asia/Bangkok'));
        $openAM = new DateTime($object->openAM, new DateTimeZone($sourceTimezone));
        $closeAM = new DateTime($object->closeAM, new DateTimeZone($sourceTimezone));
        $openPM = new DateTime($object->openPM, new DateTimeZone($sourceTimezone));
        $closePM = new DateTime($object->closePM, new DateTimeZone($sourceTimezone));

        //$date->setTimezone(new DateTimeZone('GMT'));
        $openAM->setTimezone(new DateTimeZone($destinationTimezone));
        $closeAM->setTimezone(new DateTimeZone($destinationTimezone));
        $openPM->setTimezone(new DateTimeZone($destinationTimezone));
        $closePM->setTimezone(new DateTimeZone($destinationTimezone));

        $object->openAM =  $openAM->format('h:i A');
        $object->closeAM =  $closeAM->format('h:i A');
        $object->openPM =  $openPM->format('h:i A');
        $object->closePM =  $closePM->format('h:i A');

        return $object;
    }

    public static function generateOrderGroupId($userId)
    {
        $s = strtoupper(md5(uniqid(rand(), true)));
        return substr($s, 0, 7) . substr($userId, strlen($userId) - 3, strlen($userId));
    }

    public static function updateObjectRate($objectId, $objectType)
    {
        if ($objectType == Constants::TYPE_FOOD) {
            $comments = Comment::model()->findAll('food_id =' . $objectId);
            $count = count($comments);

            $command = Yii::app()->db->createCommand();
            $command->select('SUM(rate) AS total');
            $command->from('comment');
            $command->where('food_id=:id', array(':id' => $objectId));
            $total = $command->queryScalar();


            $food = Food::model()->findByPk($objectId);
            $food->rate_times = $count;
            $food->rate = $count != 0 ? $total / $count : NULL;
            $food->save();

        } else {
            $comments = Comment::model()->findAll('location_id =' . $objectId);
            $count = count($comments);

            $command = Yii::app()->db->createCommand();
            $command->select('SUM(rate) AS total');
            $command->from('comment');
            $command->where('location_id =:id', array(':id' => $objectId));
            $total = $command->queryScalar();


            $food = Shop::model()->findByPk($objectId);
            $food->rate_times = $count;
            $food->rate = $count != 0 ? $total / $count : NULL;
            $food->save();
        }
    }

    public static function getOpenShop($shopIds,$now)
    {
        $openShopIds = array();
        $dateId = getdate()['wday'];
        $date = date('Y-m-d');
        //$now = time(); Old code
        foreach ($shopIds as $shopId) {
            $openTime = OpenHourDetail::model()->getOpenHourByShopAndDate($shopId, $dateId + 1);
            $openHour = null;
            if ($openTime != null) {
                $open_AM = $openTime->openAM == null ? '' : date('H:i:s', strtotime($openTime->openAM));
                $close_AM = $openTime->closeAM == null ? '' : date('H:i:s', strtotime($openTime->closeAM));
                $open_PM = $openTime->openPM == null ? '' : date('H:i:s', strtotime($openTime->openPM));
                $close_PM = $openTime->closePM == null ? '' : date('H:i:s', strtotime($openTime->closePM));

                if ($now < strtotime($date . ' ' . $open_AM)
                    OR
                    ($now > strtotime($date . ' ' . $close_AM) AND $now < strtotime($date . ' ' . $open_PM))
                    OR
                    $now > strtotime($date . ' ' . $close_PM)
                )
                    continue;

                $openShopIds[] = $shopId;
            }
        }
        return $openShopIds;
    }

    public static function genPassword(){
        $length = 5;
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }
        return $result;
    }
}