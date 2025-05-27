<?php

namespace app\controllers;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\ChangePasswordForm;


    class UserController extends Controller
    {
        public function behaviors(){
            return [
                'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete', 'reset-password', 'change-password'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [ 'view', 'update', 'change-password'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'reset-password', 'change-password'],
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->identity->role == 'admin';
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ],
            ],
        ];
    }
        
        public function actionIndex()
        {
            $dataProvider = new ActiveDataProvider([
                'query' => User::find(),
            ]);
            
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }

        public function actionView($id){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        public function actionCreate(){
            $model = new User();

            if ($model->load(Yii::$app->request->post())) {
                if(!empty($model->password)){
                    $model->setPassword($model->password);
                }
                 //var_dump($model);
                  //var_dump('-------');
                if($model->save()){
                    //var_dump($model);die();
                   return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            return $this->render('create', [
                'model' => $model,
            ]);
            
        }

        public function actionUpdate($id){
            $model = $this->findModel($id);
                if ($model->load(Yii::$app->request->post())) {
                    if(!empty($model->password)){
                        $model->setPassword($model->password);
                    }
                    if($model->save()){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            return $this->render('update', [
                'model' => $model,
            ]);
        }

        public function actionDelete($id){

            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }

        public function actionResetPassword($id){
            $user = $this->findModel($id);
            $user->password = $user->username;
                if($user->save()){
                    Yii::$app->session->setFlash('success', 'Restablecimiento de contraseña exitoso');
                } else {
                    Yii::$app->session->setFlash('error', 'No se pudo restablecer la contraseña');
                }
            return $this->redirect(['index']);
        }

        public function actionChangePassword(){
            $model = new ChangePasswordForm();
            if($model->load(Yii::$app->request->post()) && $model->changePassword()){
                Yii::$app->session->setFlash('success', 'Password changed successfully');
            return $this->redirect(['index']);
            }
            return $this->render('change-password', [
                'model' => $model,
            ]);
        }

        protected function findModel($id) {
            if (($model = User::findOne($id)) !== null) {
                return $model;
            }
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }


