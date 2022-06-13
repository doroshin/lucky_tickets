<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LuckyTicket */

$this->title = 'Create Lucky Ticket';
//$this->params['breadcrumbs'][] = ['label' => 'Lucky Tickets', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lucky-ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
