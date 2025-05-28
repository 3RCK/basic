<?php

use app\models\Pelicula;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PeliculaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var Pelicula[] $peliculas */

$this->title = Yii::t('app', 'Peliculas');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pelicula-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin'): ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create Pelicula'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'idPelicula',
                    [
                        'attribute' => 'portada',
                        'format' => 'html',
                        'value' => function ($model) {
                            return Html::img(Yii::getAlias('@web') . '/portadas/' . $model->portada, ['style' => 'width: 100px']);
                        },
                    ],
                    'titulo',
                    'sipnosis',
                    'anio',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Pelicula $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'idPelicula' => $model->idPelicula]);
                        }
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>

    <?php else: ?>

        <div class="row">
            <?php foreach ($dataProvider->getModels() as $pelicula): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?= Html::img(Yii::getAlias('@web') . '/portadas/' . $pelicula->portada, ['class' => 'card-img-top', 'alt' => $pelicula->titulo]) ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($pelicula->titulo) ?></h5>
                            <p class="card-text"><?= Html::encode($pelicula->sipnosis) ?></p>
                            <p><strong>Año:</strong> <?= Html::encode($pelicula->anio) ?></p>
                            <p><strong>Duración:</strong> <?= Html::encode($pelicula->duracion) ?> min</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
