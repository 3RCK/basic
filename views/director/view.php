<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Director $model */

$this->title = $model->idDirector;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Directores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="director-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'idDirector' => $model->idDirector], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'idDirector' => $model->idDirector], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estás seguro de que quieres eliminar este director?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idDirector',
            [
                'attribute' => 'foto',
                'format' => 'html',
                'value' => function ($model) {
                    $ruta = Yii::getAlias('@webroot') . '/directores/' . $model->foto;
                    $url = Yii::getAlias('@web') . '/directores/' . $model->foto;
                    $default = Yii::getAlias('@web') . '/directores/default.jpg';

                    if (!empty($model->foto) && file_exists($ruta)) {
                        return Html::img($url, ['style' => 'width: 100px']);
                    } else {
                        return Html::img($default, ['style' => 'width: 100px']);
                    }
                },
            ],
            'nombre',
            'apellido',
            'fecha_nacimiento',
        ],
    ]) ?>

</div>
