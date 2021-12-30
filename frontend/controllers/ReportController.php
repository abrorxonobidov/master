<?php

namespace frontend\controllers;

use common\models\search\PaymentSearch;
use frontend\models\Cashbox;

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
        $dataProvider = $searchModel->searchForStat($params);

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
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

}
