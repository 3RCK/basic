<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Actor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="actor-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php if ($model->foto): ?>
        <div class="form-group">
            <?= Html::label('Imagen actual') ?>
            <div>
                <?= Html::img(Yii::getAlias('@web/fotos/' . $model->foto), ['style' => 'width: 100px']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput()->label('Subir nueva imagen') ?>

    <?= $form->field($model, 'nombre')->textInput([
        'maxlength' => true,
        'placeholder' => 'Nombre del actor',
        'required' => true
    ]) ?>

    <?= $form->field($model, 'apellido')->textInput([
        'maxlength' => true,
        'placeholder' => 'Apellido del actor',
        'required' => true
    ]) ?>

    <?= $form->field($model, 'biografia')->textInput([
        'maxlength' => true,
        'placeholder' => 'Escriba una breve biografía...'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
