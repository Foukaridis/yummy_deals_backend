<?php
/**
 * Created by Fruity Solution Co.Ltd.
 * User: Only Love
 * Date: 9/30/13 - 12:24 PM
 * 
 * Please keep copyright headers of source code files when use it.
 * Thank you!
 */

class StringUtils {

    public static function createInstance(){
        return new StringUtils();
    }

    /**
     * @param string $str the value need to hash
     * @return string the value after hash
     */
    public function hashStr($str){
        return sha1($str);
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public static function  subString($data, $index) {
        return substr($data,0,$index);
    }
}