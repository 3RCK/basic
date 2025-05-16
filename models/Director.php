<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Director".
 *
 * @property int $idDirector
 * @property string|null $nombre
 * @property string|null $apellido
 * @property string|null $fecha_nacimiento
 *
 * @property Pelicula[] $peliculas
 */
class Director extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Director';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido', 'fecha_nacimiento'], 'default', 'value' => null],
            [['fecha_nacimiento'], 'safe'],
            [['nombre', 'apellido'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idDirector' => Yii::t('app', 'Id Director'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellido' => Yii::t('app', 'Apellido'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
        ];
    }

    /**
     * Gets query for [[Peliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculaQuery
     */
    public function getPeliculas()
    {
        return $this->hasMany(Pelicula::class, ['Director_idDirector' => 'idDirector']);
    }

    /**
     * {@inheritdoc}
     * @return DirectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DirectorQuery(get_called_class());
    }

}
