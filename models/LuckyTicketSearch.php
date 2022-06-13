<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LuckyTicketSearch represents the model behind the search form of `app\models\LuckyTicket`.
 */
class LuckyTicketSearch extends LuckyTicket
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number_from', 'number_to', 'tickets'], 'integer'],
            [['created'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LuckyTicket::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->created) && strpos($this->created, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->created);
            $start_timestamp = strtotime($start_date);
            $end_timestamp = strtotime($end_date);
            if($start_date==$end_date){
                $end_timestamp+=86400;
            }
            $query->andFilterWhere(['between', 'lucky_tickets.created', $start_timestamp, $end_timestamp]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'number_from' => $this->number_from,
            'number_to' => $this->number_to,
            'tickets' => $this->tickets,
        ]);

        return $dataProvider;
    }
}
