<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Genero $model */

$this->title = $model->idGenero;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Generos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="genero-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'idGenero' => $model->idGenero], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idGenero' => $model->idGenero], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estás seguro que quieres eliminar este género?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idGenero',
            [
                'attribute' => 'foto',
                'format' => 'html',
                'value' => function ($model) {
                    $ruta = Yii::getAlias('@webroot/generos/') . $model->foto;
                    if (!empty($model->foto) && file_exists($ruta)) {
                        return Html::img(Yii::getAlias('@web') . '/generos/' . $model->foto, ['style' => 'width: 100px']);
                    } else {
                        // Imagen por defecto si no hay foto o no existe el archivo
                        return Html::img(Yii::getAlias('@web') . '/generos/default.jpg', ['style' => 'width: 100px']);
                    }
                },
            ],
            'nombre',
            'descripcion',
        ],
    ]) ?>

</div>
