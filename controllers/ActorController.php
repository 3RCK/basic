<?php

namespace app\controllers;

use Yii;
use app\models\Actor;
use app\models\ActorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class ActorController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new ActorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($idActor)
    {
        return $this->render('view', [
            'model' => $this->findModel($idActor),
        ]);
    }

    public function actionCreate()
    {
        $model = new Actor();
        $message = '';

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->save() && (!$model->imageFile || $model->upload())) {
                return $this->redirect(['view', 'idActor' => $model->idActor]);
            } else {
                $message = 'Error al guardar el actor o subir la imagen.';
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    public function actionUpdate($idActor)
    {
        $model = $this->findModel($idActor);
        $message = '';

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->save() && (!$model->imageFile || $model->upload())) {
                return $this->redirect(['view', 'idActor' => $model->idActor]);
            } else {
                $message = 'Error al actualizar el actor o subir la imagen.';
            }
        }

        return $this->render('update', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    public function actionDelete($idActor)
    {
        $model = $this->findModel($idActor);
        $model->deleteFoto();
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($idActor)
    {
        if (($model = Actor::findOne(['idActor' => $idActor])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
