<?php
/**
 * Created by Fruity Solution Co.Ltd.
 * User: Only Love
 * Date: 9/30/13 - 2:45 PM
 * 
 * Please keep copyright headers of source code files when use it.
 * Thank you!
 */

class DateTimeUtils {
    const FULL_DATETIME = 'Y-m-d H:i:s';

    public static function createInstance(){
        return new DateTimeUtils();
    }

    /**
     * Get datetime now
     *
     * @param string $format the format of result
     * @return bool|string the datetime at the moment
     */
    public function now($format = self::FULL_DATETIME){
        return date($format, time());
    }

    /**
     * Get datetime now string
     *
     * @return int the datetime at the moment
     */
    public function nowStr(){
        return time();
    }
}