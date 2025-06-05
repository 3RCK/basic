<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Actor $model */

$this->title = $model->idActor;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Actors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="actor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'idActor' => $model->idActor], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idActor' => $model->idActor], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estás seguro de que quieres eliminar este actor?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idActor',
            [
                'attribute' => 'foto',
                'format' => 'html',
                'value' => function ($model) {
                    $ruta = Yii::getAlias('@webroot') . '/fotos/' . $model->foto;
                    $url = Yii::getAlias('@web') . '/fotos/' . $model->foto;
                    $default = Yii::getAlias('@web') . '/fotos/default.jpg';

                    if (!empty($model->foto) && file_exists($ruta)) {
                        return Html::img($url, ['style' => 'width: 100px']);
                    } else {
                        return Html::img($default, ['style' => 'width: 100px']);
                    }
                },
            ],
            'nombre',
            'apellido',
            'biografia',
        ],
    ]) ?>

</div>
