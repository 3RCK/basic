<?php

namespace app\controllers;

use Yii;
use app\models\Director;
use app\models\DirectorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class DirectorController extends Controller
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
        $searchModel = new DirectorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($idDirector)
    {
        return $this->render('view', [
            'model' => $this->findModel($idDirector),
        ]);
    }

    public function actionCreate()
    {
        $model = new Director();
        $message = '';

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->save() && (!$model->imageFile || $model->upload())) {
                return $this->redirect(['view', 'idDirector' => $model->idDirector]);
            } else {
                $message = 'Error al guardar el director o subir la imagen.';
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    public function actionUpdate($idDirector)
    {
        $model = $this->findModel($idDirector);
        $message = '';

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->save() && (!$model->imageFile || $model->upload())) {
                return $this->redirect(['view', 'idDirector' => $model->idDirector]);
            } else {
                $message = 'Error al actualizar el director o subir la imagen.';
            }
        }

        return $this->render('update', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    public function actionDelete($idDirector)
    {
        $model = $this->findModel($idDirector);
        $model->deleteFoto();
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($idDirector)
    {
        if (($model = Director::findOne(['idDirector' => $idDirector])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
