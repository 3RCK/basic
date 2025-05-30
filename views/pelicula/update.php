<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pelicula $model */

$this->title = Yii::t('app', 'Update Pelicula: {name}', [
    'name' => $model->idPelicula,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Peliculas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPelicula, 'url' => ['view', 'idPelicula' => $model->idPelicula]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pelicula-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
