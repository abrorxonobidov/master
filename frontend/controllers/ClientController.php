<?php

namespace frontend\controllers;

use common\models\Client;
use common\models\search\ClientSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends BaseController
{

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => (new ClientSearch())->search($this->request->queryParams)
        ]);
    }

    /**
     * Displays a single Client model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax)
            return $this->renderAjax('view', [
                'model' => $model,
            ]);
        else
            return $this->render('view', [
                'model' => $model,
            ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->uploadImage('image_file', 'image', 'client');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax)
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        else
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param null $route
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $route = null)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $model->uploadImage('image_file', 'image', 'client');
            return $this->redirect($route !== null ? $route : ['view', 'id' => $model->id]);
        }

        if (Yii::$app->request->isAjax)
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        else
            return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing Client model.
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
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) === null)
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        return $model;

    }
}
