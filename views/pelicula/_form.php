<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Director;
use app\models\Actor;


/** @var yii\web\View $this */
/** @var app\models\Pelicula $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pelicula-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php if($model->portada): ?>
    <div class="from-group">
        <?= Html::label('IMAGEN ACTUAL') ?>
        <div>
            <?= Html::img(Yii::getAlias('@web' . '/portadas/' . $model->portada, ['style' => 'width: 100px, heigth: 0.5px'])) ?>
        </div>
    </div>
    <?php endif; ?>


    <?php //$form->field($model, 'portada')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'imageFile')->fileInput()->label('Seleccionar portada')?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'placeholder' => 'Titulo de la pelicula', 'required' => true]) ?>

    <?= $form->field($model, 'sipnosis')->textInput(['maxlength' => 255, 'placeholder' => 'Escriba la sipnosis...', 'required' => true]) ?>

    <?= $form->field($model, 'anio')->input('number', ['min'=> 1990, 'max' =>date('Y')]) 
                                    ->textInput(['pattern' => '\d{4}', 'title' => 'Debe tener 4 digitos', 'placeholder' => 'YYYY', 'required' => true]) ?>

    <?= $form->field($model, 'duracion')->input('text')
    ->textInput(['placeholder' => '00:00:00', 'pattern' => '^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$', 'title' => 'Formato requirido: HH:MM:SS', 'required' => true]) ?>

    <?= $form->field($model, 'Director_idDirector')->dropDownList(ArrayHelper::map(Director::find()->select(['idDirector', 'CONCAT(nombre, " " ,apellido) AS nombre_completo'])
                                                    ->orderBy('apellido')
                                                    ->asArray()
                                                    ->all(), 'idDirector' , 'nombre_completo'), ['prompt' => 'Seleccione un director', 'required' => true])
    ?>
    
    <div class="mb-3">
        <?= Html::label('Seleccione los actores', 'actor-search', ['class'=>'form-label']) ?>
        <div class="input-group">
            <input type="text" id="actor-search" placeholder="Buscar actor..." class="form-control">
                <a href="<?= Yii::$app->urlManager->createUrl(['actor/create']) ?>" class="btn btn-secondary">
                <i class="bi bi-plus"></i>
                 Nuevo actor</a>
        </div>
            <?= Html::activeListBox($model, 'actors', ArrayHelper::map(Actor::find()->orderBy(['nombre'=>SORT_ASC])->all(),
                                            'idActor', function($actor) {
                                            return $actor->nombre . ', ' . $actor->apellido;
                                            }), ['multiple'=>true, 'size'=>10, 'id'=>'actors-select', 'class'=>'form-control mt-2']) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
