<?php
/**
 * Created by L'orge.
 * User: Only Love
 * Date: 11/27/13 - 5:52 PM
 */

class BoGenerator extends CCodeGenerator {
    public $codeModel='common.extensions.gii.bo.BoCode';

    /**
     * Provides autocomplete table names
     * @param string $db the database connection component id
     * @return string the json array of tablenames that contains the entered term $q
     */
    public function actionGetTableNames($db)
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest())
        {
            $all = array();
            if(!empty($db) && Yii::app()->hasComponent($db)!==false && (Yii::app()->getComponent($db) instanceof CDbConnection))
                $all=array_keys(Yii::app()->{$db}->schema->getTables());

            echo json_encode($all);
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }
}