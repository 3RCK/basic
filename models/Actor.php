<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Actor".
 *
 * @property int $idActor
 * @property string|null $nombre
 * @property string|null $apellido
 * @property string|null $biografia
 *
 * @property ActorHasPelicula[] $actorHasPeliculas
 */
class Actor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Actor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido', 'biografia'], 'default', 'value' => null],
            [['nombre', 'apellido', 'biografia'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idActor' => Yii::t('app', 'Id Actor'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellido' => Yii::t('app', 'Apellido'),
            'biografia' => Yii::t('app', 'Biografia'),
        ];
    }

    /**
     * Gets query for [[ActorHasPeliculas]].
     *
     * @return \yii\db\ActiveQuery|ActorHasPeliculaQuery
     */
    public function getActorHasPeliculas()
    {
        return $this->hasMany(ActorHasPelicula::class, ['Actor_idActor' => 'idActor']);
    }

    /**
     * {@inheritdoc}
     * @return ActorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActorQuery(get_called_class());
    }

}
