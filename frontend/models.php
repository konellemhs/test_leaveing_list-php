<?php

namespace frontend;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\UserLeaveList;

/**
 * models represents the model behind the search form of `frontend\models\UserLeaveList`.
 */
class models extends UserLeaveList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fixied'], 'integer'],
            [['username', 'password', 'first_name', 'last_name', 'role', 'date_start', 'date_finish'], 'safe'],
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
        $query = UserLeaveList::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fixied' => $this->fixied,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'date_start', $this->date_start])
            ->andFilterWhere(['like', 'date_finish', $this->date_finish]);

        return $dataProvider;
    }
}
