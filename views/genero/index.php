<?php

use app\models\Genero;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\GeneroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Géneros');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="genero-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin'): ?>

        <p>
            <?= Html::a(Yii::t('app', 'Crear Género'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'idGenero',
                    [
                        'attribute' => 'foto',
                        'format' => 'html',
                        'value' => function ($model) {
                            return $model->foto 
                                ? Html::img(Yii::getAlias('@web') . '/generos/' . $model->foto, ['style' => 'width: 100px'])
                                : '(Sin imagen)';
                        },
                    ],
                    'nombre',
                    'descripcion',
                    [
                        'class' => ActionColumn::class,
                        'urlCreator' => function ($action, Genero $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'idGenero' => $model->idGenero]);
                        }
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>

    <?php else: ?>

        <div class="row">
            <?php foreach ($dataProvider->getModels() as $genero): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php if ($genero->foto): ?>
                            <?= Html::img(Yii::getAlias('@web') . '/generos/' . $genero->foto, ['class' => 'card-img-top', 'alt' => $genero->nombre]) ?>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($genero->nombre) ?></h5>
                            <p class="card-text"><?= Html::encode($genero->descripcion) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
