<?php

namespace frontend\controllers;

use common\helpers\DebugHelper;
use common\models\Income;
use common\models\IncomeProductLink;
use common\models\search\IncomeProductLinkSearch;
use common\models\search\IncomeSearch;
use Yii;
use common\models\Model;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IncomeController implements the CRUD actions for Income model.
 */
class IncomeController extends BaseController
{


    /**
     * Lists all Income models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IncomeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Income model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new IncomeProductLinkSearch();
        $searchModel->income_id = $model->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        if (\Yii::$app->request->isAjax)
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
        $model = new Income();
        $modelsProductLink = [new IncomeProductLink()];
        if ($model->load($this->request->post())) {
            /* @var IncomeProductLink[] $modelsProductLink */
            $modelsProductLink = Model::createMultiple(IncomeProductLink::classname());
            Model::loadMultiple($modelsProductLink, $this->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsProductLink) && $valid;
//            DebugHelper::printSingleObject($modelsProductLink, 1, 1, 1);
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsProductLink as $modelProductLink) {
                            $modelProductLink->income_id = $model->id;
                            if (!($flag = $modelProductLink->save(false))) {
                                Yii::$app->session->setFlash('error', DebugHelper::getModelErrorsText($modelProductLink));
                                $transaction->rollBack();
                                break;
                            }
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
            'modelsProductLink' => (empty($modelsProductLink)) ? [new IncomeProductLink] : $modelsProductLink
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsProductLink = $model->incomeProductLinks;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsProductLink, 'id', 'id');
            /* @var IncomeProductLink[] $modelsProductLink */
            $modelsProductLink = Model::createMultiple(IncomeProductLink::classname(), $modelsProductLink);
            Model::loadMultiple($modelsProductLink, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsProductLink, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsProductLink) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            IncomeProductLink::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsProductLink as $modelProductLink) {
                            $modelProductLink->income_id = $model->id;
                            if (!($flag = $modelProductLink->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
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
            'modelsProductLink' => (empty($modelsProductLink)) ? [new IncomeProductLink] : $modelsProductLink
        ]);
    }

    /**
     * Deletes an existing Income model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Income model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Income the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Income::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Set status an existing Order model.
     * If set status is successful, the browser will be redirected to the 'index' page.
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
