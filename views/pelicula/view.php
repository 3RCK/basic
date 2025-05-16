<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Pelicula $model */

$this->title = $model->idPelicula;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Peliculas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pelicula-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'idPelicula' => $model->idPelicula], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idPelicula' => $model->idPelicula], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'En serio quieres eliminar esto'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idPelicula',
            //'portada',
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
            'duracion',
            'Director_idDirector',
            //[
            //'class' => ActionColumn::className(),
            //'urlCreator' => function ($action, Pelicula $model, $key, $index, $column) {
                // return Url::toRoute([$action, 'idpelicula' => $model->idpelicula]);
                //}
            //],
        ],
    ]) ?>

</div>
