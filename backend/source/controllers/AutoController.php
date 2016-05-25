<?php

class AutoController extends Controller
{
    public function actionCompleteFood() {
//METHOD 1
        /*$criteria = new CDbCriteria;
        $criteria->select = array('food_id', 'food_name', 'food_code');
        $criteria->addSearchCondition('food_name',  strtoupper( $_GET['term']) ) ;
        $criteria->limit = 15;
        $data = Food::model()->findAll($criteria);

        $arr = array();

        foreach ($data as $item) {
            $arr[] = array(
                'id' => $item->food_id,
                'value' => $item->food_name,
                'label' => $item->food_name. ' <'. $item->food_code. '>',
            );
        }
        echo CJSON::encode($arr);*/

//METHOD 2

        if (Yii::app()->request->isPostRequest) {
                header('Content-type: application/json');
                if (isset($_REQUEST)) {
                    $location_id = $_REQUEST['location_id'];
                    $term = $_REQUEST['term'];

                    $criteria = new CDbCriteria;
                    $criteria->select = array('food_id', 'food_name', 'food_code');
                    $criteria->addSearchCondition('food_name',  strtoupper($term)) ;
                    $criteria->addCondition('shop_id ='.$location_id);
                    $criteria->limit = 15;
                    $data = Food::model()->findAll($criteria);

                    $arr = array();

                    foreach ($data as $item) {
                        $arr[] = array(
                            'id' => $item->food_id,
                            'value' => $item->food_name,
                            'label' => $item->food_name. ' < Code:'. $item->food_code. '>',
                        );
                    }
                    echo  CJSON::encode($arr);
                }
                else
                {
                    $arr = array();
                    echo  CJSON::encode($arr);
                }
        }
    }

}