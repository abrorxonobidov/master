<?php

namespace frontend\controllers;

use common\models\BaseActiveRecord;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
* BaseController
*/
class BaseController extends Controller
{
    /**
    * @inheritDoc
    */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['login'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionFileRemove()
    {
        $return = false;
        $file = BaseActiveRecord::uploadImagePath() . Yii::$app->request->post('key');
        $id = Yii::$app->request->post('id');
        $field = Yii::$app->request->post('field');
        $className = Yii::$app->request->post('className');
        $model = $className::findOne($id);
        /** @var $model yii\db\ActiveRecord */
        $model->$field = '';
        $model->updateAttributes([$field]);

        if (isset($file) && file_exists($file)) {
            unlink($file);
            $return = true;
        }
        return $return;
    }


}
