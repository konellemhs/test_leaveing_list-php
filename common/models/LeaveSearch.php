<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Leave;

/**
 * UsertSearch represents the model behind the search form of `frontend\models\Usert`.
 */
class LeaveSearch extends Leave
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['user_first_name', 'user_last_name', 'date_start', 'date_finish'], 'safe'],
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
        $query = Leave::find();

     

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                 'forcePageParam' => false,
                 'pageSizeParam' => false,
                'pageSize' => 20]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'          => $this->id,
             
        ]);

        $query->andFilterWhere(['like', 'user_first_name', $this->user_first_name])
            ->andFilterWhere(['like', 'user_last_name', $this->user_last_name])
            // ->andFilterWhere(['like', 'role', $this->role]);
            ->andFilterWhere(['like', 'start', $this->date_start])
            ->andFilterWhere(['like', 'date_finish', $this->date_finish]);

        return $dataProvider;
    }
}
