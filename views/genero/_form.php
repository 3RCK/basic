<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Genero $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="genero-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php if ($model->foto): ?>
        <div class="form-group">
            <?= Html::label('Imagen actual del género', null, ['class' => 'form-label']) ?>
            <div>
                <?= Html::img(Yii::getAlias('@web/fotos_generos/' . $model->foto), ['style' => 'width: 100px; height: auto;', 'alt' => 'Foto del género']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput()->label('Seleccionar foto del género') ?>

    <?= $form->field($model, 'nombre')->textInput([
        'maxlength' => true,
        'placeholder' => 'Nombre del género',
        'required' => true
    ]) ?>

    <?= $form->field($model, 'descripcion')->textInput([
        'maxlength' => true,
        'placeholder' => 'Descripción del género',
        'required' => true
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
