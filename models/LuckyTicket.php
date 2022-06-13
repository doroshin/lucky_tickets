<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lucky_tickets".
 *
 * @property int $id
 * @property int|null $number_from
 * @property int|null $number_to
 * @property int|null $tickets
 * @property int|null $created
 */
class LuckyTicket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lucky_tickets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tickets', 'created'], 'integer'],
            ['number_from', 'integer', 'max' => 999999, 'min' => 1],
            ['number_to', 'integer', 'max' => 999999, 'min' => 1],
            [['created'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number_from' => 'Number From',
            'number_to' => 'Number To',
            'tickets' => 'Tickets',
            'created' => 'Created',
        ];
    }
}
