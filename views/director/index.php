<?php

use app\models\Director;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\DirectorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Directores');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="director-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin'): ?>

        <p>
            <?= Html::a(Yii::t('app', 'Crear Director'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'idDirector',
                [
                    'attribute' => 'foto',
                    'format' => 'html',
                    'value' => function ($model) {
                        $img = (!empty($model->foto) && file_exists(Yii::getAlias('@webroot/directores/' . $model->foto)))
                            ? $model->foto
                            : 'default.jpg';
                        return Html::img(Yii::getAlias('@web/directores/' . $img), ['style' => 'width: 100px']);
                    },
                ],
                'nombre',
                'apellido',
                'fecha_nacimiento',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Director $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'idDirector' => $model->idDirector]);
                    }
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>

    <?php else: ?>

        <div class="row">
            <?php foreach ($dataProvider->getModels() as $director): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php
                            $foto = (!empty($director->foto) && file_exists(Yii::getAlias('@webroot/directores/' . $director->foto)))
                                ? $director->foto
                                : 'default.jpg';
                        ?>
                        <?= Html::img(Yii::getAlias('@web/directores/' . $foto), [
                            'class' => 'card-img-top',
                            'alt' => $director->nombre,
                        ]) ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($director->nombre . ' ' . $director->apellido) ?></h5>
                            <p><strong>Fecha de nacimiento:</strong><br> <?= Html::encode($director->fecha_nacimiento) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
