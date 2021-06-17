<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shippers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipper-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Shipper', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_shipper',
            'name_shipper',
            'telephone_shipper',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
