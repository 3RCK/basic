<?php

namespace app\controllers;

use Yii;
use app\models\Genero;
use app\models\GeneroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GeneroController implements the CRUD actions for Genero model.
 */
class GeneroController extends Controller
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
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Genero models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GeneroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Genero model.
     * @param int $idGenero
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idGenero)
    {
        return $this->render('view', [
            'model' => $this->findModel($idGenero),
        ]);
    }

    /**
     * Creates a new Genero model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Genero();

        if ($this->request->isPost) {
            $model->load($this->request->post());

            // Capturar archivo
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {
                // Generar nombre único
                $imageName = 'genero_' . time() . '.' . $model->imageFile->extension;
                $model->foto = $imageName;
            }

            if ($model->save()) {
                if ($model->imageFile) {
                    $uploadPath = Yii::getAlias('@webroot/generos/') . $model->foto;
                    $model->imageFile->saveAs($uploadPath);
                }
                return $this->redirect(['view', 'idGenero' => $model->idGenero]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Genero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idGenero
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idGenero)
    {
        $model = $this->findModel($idGenero);
        $message = '';

        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->load($this->request->post())) {
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                    if ($model->imageFile) {
                        // Eliminar foto anterior
                        $model->deleteFoto();

                        // Nombre único para la nueva foto
                        $imageName = 'genero_' . time() . '.' . $model->imageFile->extension;
                        $model->foto = $imageName;
                    }

                    if ($model->save()) {
                        if ($model->imageFile) {
                            $uploadPath = Yii::getAlias('@webroot/generos/') . $model->foto;
                            $model->imageFile->saveAs($uploadPath);
                        }

                        $transaction->commit();
                        return $this->redirect(['view', 'idGenero' => $model->idGenero]);
                    } else {
                        $message = 'Error al guardar los cambios.';
                        $transaction->rollBack();
                    }
                } else {
                    $message = 'Error al cargar los datos del formulario.';
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                $message = 'Error al actualizar el género: ' . $e->getMessage();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    /**
     * Deletes an existing Genero model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idGenero
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idGenero)
    {
        $model = $this->findModel($idGenero);

        // Eliminar archivo de foto si existe
        $model->deleteFoto();

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Genero model based on its primary key value.
     * @param int $idGenero
     * @return Genero
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idGenero)
    {
        if (($model = Genero::findOne(['idGenero' => $idGenero])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
