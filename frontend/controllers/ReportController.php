<?php

namespace frontend\controllers;

use common\helpers\DebugHelper;
use common\models\Client;
use common\models\Expense;
use common\models\Payment;
use common\models\search\ClientSearch;
use common\models\search\PaymentSearch;
use frontend\models\Cashbox;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportController implements.
 */
class ReportController extends BaseController
{

    /**
     * Lists all Payments models.
     * @return mixed
     */
    public function actionPayments()
    {
        $searchModel = new PaymentSearch();
        $params = $this->request->queryParams;
        $searchModel->loadDefaultSearchParams($params);
        $dataProvider = $searchModel->search($params, [
            'AND',
            ['status' => Payment::STATUS_ACTIVE],
            ['>', 'price', 0]
        ], 0);

        return $this->render('payments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCashbox()
    {
        $model = new Cashbox();
        $params = $this->request->queryParams;
        $model->loadDefaultSearchParams($params);
        $dataProvider = $model->search($params);
        return $this->render('cashbox', [
//            'data' => $data,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

}
