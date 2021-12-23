<?php

namespace frontend\controllers;

use common\models\Technic;
use common\models\search\TechnicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TechnicController implements the CRUD actions for Technic model.
 */
class TechnicController extends BaseController
{

    /**
     * Lists all Technic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TechnicSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Technic model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (\Yii::$app->request->isAjax)
            return $this->renderAjax('view', [
                'model' => $model,
            ]);
        else
            return $this->render('view', [
                'model' => $model,
            ]);
    }

    /**
     * Creates a new Technic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Technic();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->uploadImage('image_file', 'image', 'client');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        if (\Yii::$app->request->isAjax)
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        else
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Technic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $model->uploadImage('image_file', 'image', 'client');
            return $this->redirect(['index']);
        }

        if (\Yii::$app->request->isAjax)
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        else
            return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing Technic model.
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
     * Finds the Technic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Technic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Technic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
