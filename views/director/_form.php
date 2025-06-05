<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Director $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="director-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php if ($model->foto): ?>
        <div class="form-group">
            <?= Html::label('Imagen actual') ?>
            <div>
                <?= Html::img(Yii::getAlias('@web/directores/' . $model->foto), ['style' => 'width: 100px']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput()->label('Subir nueva imagen') ?>

    <?= $form->field($model, 'nombre')->textInput([
        'maxlength' => true,
        'placeholder' => 'Nombre del director',
        'required' => true
    ]) ?>

    <?= $form->field($model, 'apellido')->textInput([
        'maxlength' => true,
        'placeholder' => 'Apellido del director',
        'required' => true
    ]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->textInput([
        'type' => 'date',
        'placeholder' => 'YYYY-MM-DD'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
