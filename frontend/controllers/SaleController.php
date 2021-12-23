<?php

namespace frontend\controllers;

use common\helpers\DebugHelper;
use common\models\Model;
use common\models\Payment;
use common\models\Sale;
use common\models\SaleProductLink;
use common\models\search\SaleProductLinkSearch;
use common\models\search\SaleSearch;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * SaleController implements the CRUD actions for Sale model.
 */
class SaleController extends BaseController
{

    /**
     * Lists all Sale models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SaleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sale model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new SaleProductLinkSearch();
        $searchModel->sale_id = $model->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        if (Yii::$app->request->isAjax)
            return $this->renderAjax('view_new', [
                'model' => $model,
                'productLinkDataProvider' => $dataProvider,
            ]);
        else
            return $this->render('view_new', [
                'model' => $model,
                'productLinkDataProvider' => $dataProvider,
            ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sale();
        $payment = new Payment();
        $payment->price = 0;
        $modelsProductLink = [new SaleProductLink()];
        if ($model->load($this->request->post())) {
            /* @var SaleProductLink[] $modelsProductLink */
            $modelsProductLink = Model::createMultiple(SaleProductLink::class);
            Model::loadMultiple($modelsProductLink, $this->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsProductLink) && $valid;
//            DebugHelper::printSingleObject($modelsProductLink, 1, 1, 1);
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsProductLink as $modelProductLink) {
                            $modelProductLink->sale_id = $model->id;
                            if (!($flag = $modelProductLink->save(false))) {
                                Yii::$app->session->setFlash('error', DebugHelper::getModelErrorsText($modelProductLink));
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag && $payment->load($this->request->post())) {
                        $payment->sale_id = $model->id;
                        $payment->client_id = $model->client_id;
                        $payment->date_time = $model->date_time;
                        if (!($flag = $payment->save())) {
                            Yii::$app->session->setFlash('error', DebugHelper::getModelErrorsText($payment));
                            $transaction->rollBack();
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('error', DebugHelper::getModelErrorsText($e->getTraceAsString()));
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'payment' => $payment,
            'modelsProductLink' => (empty($modelsProductLink)) ? [new SaleProductLink()] : $modelsProductLink
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsProductLink = $model->saleProductLinks;
        $payment = $model->payment;
        if (!$payment) {
            $payment = new Payment();
            $payment->sale_id = $model->id;
            $payment->client_id = $model->client_id;
            $payment->date_time = $model->date_time;
        }

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsProductLink, 'id', 'id');
            /* @var SaleProductLink[] $modelsProductLink */
            $modelsProductLink = Model::createMultiple(SaleProductLink::class, $modelsProductLink);
            Model::loadMultiple($modelsProductLink, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsProductLink, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsProductLink) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            SaleProductLink::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsProductLink as $modelProductLink) {
                            $modelProductLink->sale_id = $model->id;
                            if (!($flag = $modelProductLink->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag && $payment->load($this->request->post())) {
                        if (!($flag = $payment->save())) {
                            Yii::$app->session->setFlash('error', DebugHelper::getModelErrorsText($payment));
                            $transaction->rollBack();
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'payment' => $payment,
            'modelsProductLink' => (empty($modelsProductLink)) ? [new SaleProductLink] : $modelsProductLink
        ]);
    }

    /**
     * Deletes an existing Sale model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException | mixed if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Sale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sale::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the Sale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $sale_id ID
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPayment($sale_id)
    {
        if (($model = Payment::find()->where(['sale_id' => $sale_id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Set status an existing Order model.
     * If set status is successful, the browser will be redirected to the 'index' page.
     * @param array|string $route
     * @param integer $id
     * @param string $status
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSetStatus($route, $id, $status)
    {
        $model = $this->findModel($id);
        if (!in_array($status, [$model::STATUS_ACTIVE, $model::STATUS_DRAFT, $model::STATUS_CANCELLED]))
            throw new NotFoundHttpException(Yii::t('app', 'Бундай статус мавжуд эмас'));
        $model->updateAttributes(['status' => (int)$status]);
        return $this->redirect($route);
    }
}
