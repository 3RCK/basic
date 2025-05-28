<?php

use app\models\Actor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\ActorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Actors');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="actor-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin'): ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create Actor'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'idActor',
                    'nombre',
                    'apellido',
                    'biografia',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Actor $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'idActor' => $model->idActor]);
                        }
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>

    <?php else: ?>

        <div class="row">
            <?php foreach ($dataProvider->getModels() as $actor): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($actor->nombre . ' ' . $actor->apellido) ?></h5>
                            <p><strong>Características:</strong> <?= Html::encode($actor->descripcion ?? $actor->biografia) ?></p>
                            <p><strong>Fecha de nacimiento:</strong> <?= Html::encode($actor->fecha_nacimiento) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
