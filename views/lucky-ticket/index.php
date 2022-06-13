<?php

use app\models\LuckyTicket;
use kartik\daterange\DateRangePicker;
use yii\bootstrap4\LinkPager;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LuckyTicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lucky Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lucky-ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Create Lucky Ticket',['value' => Url::to('index.php?r=lucky-ticket/create'), 'class' => 'btn btn-success', 'id' => 'create_lt_btn']) ?>
    </p>

    <?php
    Modal::begin([
            'id' => 'lt_generator_modal',
            'size' => 'modal-lg'
    ]);
    echo "<div id='lt_modal_content'> </div>";

    Modal::end();

    $ranges = [
        Yii::t('app', "Today") => ["moment().startOf('day')", "moment().startOf('day').add({days:1})"],
        Yii::t('app', "Yesterday") => ["moment().startOf('day').subtract(1,'days')", "moment().startOf('day')"],
        Yii::t('app', "Last {n} Days", ['n' => 7]) => ["moment().startOf('day').subtract(6, 'days')", "moment().startOf('day').add({days:1})"],
        Yii::t('app', "Last {n} Days", ['n' => 14]) => ["moment().startOf('day').subtract(13, 'days')", "moment().startOf('day').add({days:1})"],
        Yii::t('app', "This Month") => ["moment().startOf('month')", "moment().startOf('month').add({month:1})"],
        Yii::t('app', "Last Month") => ["moment().subtract({month:1}).startOf('day')", "moment().startOf('day').add({days:1})"],
    ];
    ?>

    <?php Pjax::begin(['id' => 'pj_lt_grid']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function (LuckyTicket $model) {
            if ($model->tickets == 0) {
                return ['class' => 'bg-danger'];
            }
        },
        'pager' => [
            'class' => LinkPager::class,
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last'
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'filterInputOptions' => [
                    'placeholder' => 'Search for id...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'number_from',
                'filterInputOptions' => [
                    'placeholder' => 'Search for number from...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'number_to',
                'filterInputOptions' => [
                    'placeholder' => 'Search for number to...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'tickets',
                'filterInputOptions' => [
                    'placeholder' => 'Search for tickets...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'created',
                'format' =>  ['date', 'Y-MM-dd HH:mm (P)'],
                'headerOptions' => ['style' => 'width:150px'],
                'filter'=>DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created',
                    'convertFormat' => true,
                    'options' => [
                        'placeholder' => 'Click to search...',
                        'class' => 'form-control'
                    ],
                    'pluginOptions' => [
                        'ranges' => $ranges,
                        'opens' => 'left',
                        'locale' => [
                            'format' => 'Y-m-d',
                        ]
                    ]
                ])
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {delete}'
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
