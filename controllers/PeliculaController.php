<?php

namespace app\controllers;
use Yii;
use app\models\Pelicula;
use app\models\PeliculaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * PeliculaController implements the CRUD actions for Pelicula model.
 */
class PeliculaController extends Controller
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
            ]
        );
    }

    /**
     * Lists all Pelicula models.
     *
     * @return string
     */
    public function actionIndex()
{
    $searchModel = new PeliculaSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    /**
     * Displays a single Pelicula model.
     * @param int $idPelicula Id Pelicula
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idPelicula)
    {
        return $this->render('view', [
            'model' => $this->findModel($idPelicula),
        ]);
    }

    /**
     * Creates a new Pelicula model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionUpdate($idPelicula)
{
    $model = $this->findModel($idPelicula);
    $message = '';

    if ($this->request->isPost) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->load($this->request->post())) {
                // Captura del archivo subido
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if ($model->imageFile) {
                    // Eliminar portada anterior si existe
                    $model->deletePortada();

                    // Generar nombre único para el nuevo archivo
                    $imageName = 'pelicula_' . time() . '.' . $model->imageFile->extension;
                    $model->portada = $imageName;
                }

                if ($model->save()) {
                    if ($model->imageFile) {
                        $uploadPath = Yii::getAlias('@webroot/portadas/') . $model->portada;
                        $model->imageFile->saveAs($uploadPath);
                    }

                    $transaction->commit();
                    return $this->redirect(['view', 'idPelicula' => $model->idPelicula]);
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
            $message = 'Error al actualizar la película: ' . $e->getMessage();
        }
    }

    return $this->render('update', [
        'model' => $model,
        'message' => $message,
    ]);
}


    /**
     * Deletes an existing Pelicula model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idPelicula Id Pelicula
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idPelicula)
    {
        //$this->findModel($idPelicula)->delete();
        $model = $this->findModel($idpelicula);
        $model->deletePortada();
        $model->delete();

        return $this->redirect(['index']);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pelicula model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idPelicula Id Pelicula
     * @return Pelicula the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idPelicula)
    {
        if (($model = Pelicula::findOne(['idPelicula' => $idPelicula])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
