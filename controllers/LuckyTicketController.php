<?php

namespace app\controllers;

use app\models\LuckyTicket;
use app\models\LuckyTicketSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LuckyTicketController implements the CRUD actions for LuckyTicket model.
 */
class LuckyTicketController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all LuckyTicket models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LuckyTicketSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single LuckyTicket model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LuckyTicket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new LuckyTicket();

        if ($this->request->isPost) {
            $number_from = Yii::$app->request->post('number_from');
            $number_to = Yii::$app->request->post('number_to');
            $tickets = self::GetCountOfLuckyTickets($number_from, $number_to);

            $model->number_from = $number_from;
            $model->number_to = $number_to;
            $model->tickets = $tickets;
            $model->created = time();
            $model->save();
            if ($model->save()) {
                return $tickets;

            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LuckyTicket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LuckyTicket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LuckyTicket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LuckyTicket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LuckyTicket::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public static function GetCountOfLuckyTickets($number_from, $number_to)
    {
        $total_lucky_count = 0;

        if (!empty($number_from) && !empty($number_to)) {
            for ($current_number = $number_from; $current_number <= $number_to; $current_number++) {
                $current_number_arr = str_split($current_number);
                $left_side_number = intval($current_number_arr[0]) + intval($current_number_arr[1]) + intval($current_number_arr[2]);
                $right_side_number = intval($current_number_arr[3]) + intval($current_number_arr[4]) + intval($current_number_arr[5]);

                $left_side_number = self::checkHalfOfNumberForDouble($left_side_number);
                $right_side_number = self::checkHalfOfNumberForDouble($right_side_number);

                if ($left_side_number == $right_side_number) {
                    $total_lucky_count++;
                }
            }
            return $total_lucky_count;
        }else{
            return 'Empty data!';
        }
    }

    public static function checkHalfOfNumberForDouble($half_number)
    {
        $half_number = strval($half_number);
        $half_number_first_step = null;
        $half_number_second_step = null;

        if (strlen($half_number) == 2) {
            $half_number_first_step = $half_number[0] + $half_number[1];
        } else {
            return $half_number;
        }

        if (strlen($half_number_first_step) == 2) {
            $half_number_second_step = $half_number_first_step[0] + $half_number_first_step[1];

            return $half_number_second_step;
        } else {
            return $half_number_first_step;
        }
    }
}
