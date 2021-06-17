<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\shipper */

$this->title = 'Update Shipper: ' . $model->id_shipper;
$this->params['breadcrumbs'][] = ['label' => 'Shippers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_shipper, 'url' => ['view', 'id' => $model->id_shipper]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shipper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
