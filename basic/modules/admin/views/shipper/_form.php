<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\shipper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shipper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_shipper')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telephone_shipper')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
