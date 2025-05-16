<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actor_has_pelicula".
 *
 * @property int $Actor_idActor
 * @property int $Pelicula_idPelicula
 *
 * @property Actor $actorIdActor
 * @property Pelicula $peliculaIdPelicula
 */
class ActorHasPelicula extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actor_has_pelicula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Actor_idActor', 'Pelicula_idPelicula'], 'required'],
            [['Actor_idActor', 'Pelicula_idPelicula'], 'integer'],
            [['Actor_idActor'], 'exist', 'skipOnError' => true, 'targetClass' => Actor::class, 'targetAttribute' => ['Actor_idActor' => 'idActor']],
            [['Pelicula_idPelicula'], 'exist', 'skipOnError' => true, 'targetClass' => Pelicula::class, 'targetAttribute' => ['Pelicula_idPelicula' => 'idPelicula']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Actor_idActor' => Yii::t('app', 'Actor Id Actor'),
            'Pelicula_idPelicula' => Yii::t('app', 'Pelicula Id Pelicula'),
        ];
    }

    /**
     * Gets query for [[ActorIdActor]].
     *
     * @return \yii\db\ActiveQuery|ActorQuery
     */
    public function getActorIdActor()
    {
        return $this->hasOne(Actor::class, ['idActor' => 'Actor_idActor']);
    }

    /**
     * Gets query for [[PeliculaIdPelicula]].
     *
     * @return \yii\db\ActiveQuery|PeliculaQuery
     */
    public function getPeliculaIdPelicula()
    {
        return $this->hasOne(Pelicula::class, ['idPelicula' => 'Pelicula_idPelicula']);
    }

    /**
     * {@inheritdoc}
     * @return ActorHasPeliculaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActorHasPeliculaQuery(get_called_class());
    }

}
