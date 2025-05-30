<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Director $model */

$this->title = Yii::t('app', 'Update Director: {name}', [
    'name' => $model->idDirector,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Directors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idDirector, 'url' => ['view', 'idDirector' => $model->idDirector]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="director-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
