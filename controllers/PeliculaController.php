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
    public function actionCreate()
    {
        $model = new Pelicula();
        $message = '';

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idPelicula' => $model->idPelicula]);
            }
        } else {
            $model->loadDefaultValues();
        }
        if ($this->request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if($model->load($this->request->post())){
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                    if ($model->save() && (!$model->imageFile || $model->upload())) {
                        $transaction->commit();
                        return $this->redirect(['view', 'idpelicula' => $model->idpelicula]);
                    }else{
                        $message = 'Error al guardar la pelicula';
                        $transaction->rollBack();
                    }
                }else{
                    $message = 'Error al cargar la portada';
                    $transaction->rollBack();
                }

            }catch(\Exception $e){
                    $transaction->rollBack();
                    $message = 'Error al guardar la pelicula';
            }
        }else{
            $model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    /**
     * Updates an existing Pelicula model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idPelicula Id Pelicula
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idPelicula)
    {
        $model = $this->findModel($idPelicula);
        $message = '';
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if ($model->save() && (!$model->imageFile || $model->upload())) {
                    return $this->redirect(['view', 'idPelicula' => $model->idPelicula]);
                } else {
                    $message = 'Error al guardar la película';
                }
            }

            $model->actors = ArrayHelper::getColumn($model->getActorIdActor()->asArray()->all(), 'idActor');

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
