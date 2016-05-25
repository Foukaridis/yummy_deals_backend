<?php
/**
 * Created by Fruity Solution Co.Ltd.
 * User: Only Love
 * Date: 10/1/13 - 11:24 AM
 * 
 * Please keep copyright headers of source code files when use it.
 * Thank you!
 */

class FileUtils {
    const UPLOAD_DIR = 'uploads';

    const
        FILE_NAME = 'fileName',
        LOCATION_NAME = 'dir';

    public static function createInstance(){
        return new FileUtils();
    }

    /**
     * @param CUploadedFile $file the file will be uploaded
     * @param string $subPath the name of sub-folder in upload directory
     * @param string $oFile the name of old file
     * @return array include fileName and full directory to this file.
     */
    public function uploadFile($file = null, $subPath = '', $oFile = ''){
        try{
            $uploadDir = Yii::getPathOfAlias(self::UPLOAD_DIR);
            if(!empty($subPath)){
                $uploadDir = $uploadDir . DIRECTORY_SEPARATOR . $subPath;
            }
            if(!file_exists($uploadDir)){
                mkdir($uploadDir, 0777, true);
            }
            // Create file name
            $fileName = time().'.'.$file->extensionName;
            //echo '<pre>';var_dump($file);echo '==================='.($file->saveAs($uploadDir.DIRECTORY_SEPARATOR.$fileName));die;
            if($file->saveAs($uploadDir.DIRECTORY_SEPARATOR.$fileName)){
                // Delete old image
                if(!empty($oFile) && file_exists($uploadDir.DIRECTORY_SEPARATOR.$oFile) && is_file($uploadDir.DIRECTORY_SEPARATOR.$oFile)){
                    unlink($uploadDir.DIRECTORY_SEPARATOR.$oFile);
                }
                return array(
                    self::FILE_NAME => $fileName,
                    self::LOCATION_NAME => $uploadDir.DIRECTORY_SEPARATOR.$fileName,
                );
            }
            return array();
        }catch (Exception $e){
            return array();
        }
    }
    public function downloadFile($fileName = '', $subPath = ''){
        $uploadDir = Yii::getPathOfAlias(self::UPLOAD_DIR);
        if(!empty($subPath)){
            $uploadDir = $uploadDir . DIRECTORY_SEPARATOR . $subPath;
        }
        if(file_exists($uploadDir.DIRECTORY_SEPARATOR.$fileName) && is_file($uploadDir.DIRECTORY_SEPARATOR.$fileName)){
            return Yii::app()->getRequest()->sendFile($fileName, @file_get_contents($uploadDir.DIRECTORY_SEPARATOR.$fileName));
        }else{
            return null;
        }
    }
}