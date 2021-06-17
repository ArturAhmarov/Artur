<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\shipper */

$this->title = 'Create Shipper';
$this->params['breadcrumbs'][] = ['label' => 'Shippers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
