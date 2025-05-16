<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pelicula;

/**
 * PeliculaSearch represents the model behind the search form of `app\models\Pelicula`.
 */
class PeliculaSearch extends Pelicula
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPelicula', 'anio', 'Director_idDirector'], 'integer'],
            [['portada', 'titulo', 'sipnosis', 'duracion'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Pelicula::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idPelicula' => $this->idPelicula,
            'anio' => $this->anio,
            'duracion' => $this->duracion,
            'Director_idDirector' => $this->Director_idDirector,
        ]);

        $query->andFilterWhere(['like', 'portada', $this->portada])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'sipnosis', $this->sipnosis]);

        return $dataProvider;
    }
}
