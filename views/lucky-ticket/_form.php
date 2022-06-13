<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LuckyTicket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lucky-ticket-form">
    <?php $form = ActiveForm::begin([
            'id' => 'lt_create_form'
    ]); ?>

    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($model, 'number_from')->textInput(['id' => 'number_from_field', 'required'=>true]) ?>
        </div>
        <div class="col-sm-5">
            <?= $form->field($model, 'number_to')->textInput(['id' => 'number_to_field', 'required'=>true]) ?>
        </div>
        <div class="col-sm-2">
            <?= Html::submitButton('Run', ['class' => 'btn btn-success btn_run', 'id' => 'btn_run']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6" id="total_lt_number_text"><b>Number of tickets</b>: </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS

$('#lt_create_form').on('beforeSubmit', function(e){
    var go = true;
 if($('#number_from_field').hasClass('forbidden') || $('#number_to_field').hasClass('forbidden')){
            alert('Please enter at least 6 digits');
            go = false;
    }

    var form = $('#lt_create_form');
    var number_from = $('#number_from_field').val();
    var number_to = $('#number_to_field').val(); 
    
    if(go === true){
        $.post(form.attr("action"), {number_from:number_from, number_to:number_to})
            .done(function(result){
                if(result != undefined){
                    $.pjax.reload({container: '#pj_lt_grid'});
                    $('#result_block').remove();
                    $('#total_lt_number_text').append('<span id="result_block">' + result + '</span>');
                } else {
                    $('#total_lt_number_text').append('<div id="result_block">' + result.message + '</div>');
                }
            })
            .fail(function() {
                  console.log('server error');
            });
    }
        return false;
    });

    $('#number_from_field, #number_to_field').on("click keyup change blur", function () {
        if ($(this).val().length >= 6 && $(this).val().length <= 6) {
            $(this).attr('style', 'border: 1px solid green;');
            $(this).removeClass('forbidden');
        } else {
            $(this).attr('style', 'border: 1px solid red;');
            $(this).addClass('forbidden');
        }
    });

JS;
$this->registerJs($js, View::POS_READY);


