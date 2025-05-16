<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pelicula_has_genero".
 *
 * @property int $Genero_idGenero
 * @property int $Pelicula_idPelicula
 *
 * @property Genero $generoIdGenero
 * @property Pelicula $peliculaIdPelicula
 */
class PeliculaHasGenero extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelicula_has_genero';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Genero_idGenero', 'Pelicula_idPelicula'], 'required'],
            [['Genero_idGenero', 'Pelicula_idPelicula'], 'integer'],
            [['Genero_idGenero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::class, 'targetAttribute' => ['Genero_idGenero' => 'idGenero']],
            [['Pelicula_idPelicula'], 'exist', 'skipOnError' => true, 'targetClass' => Pelicula::class, 'targetAttribute' => ['Pelicula_idPelicula' => 'idPelicula']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Genero_idGenero' => Yii::t('app', 'Genero Id Genero'),
            'Pelicula_idPelicula' => Yii::t('app', 'Pelicula Id Pelicula'),
        ];
    }

    /**
     * Gets query for [[GeneroIdGenero]].
     *
     * @return \yii\db\ActiveQuery|GeneroQuery
     */
    public function getGeneroIdGenero()
    {
        return $this->hasOne(Genero::class, ['idGenero' => 'Genero_idGenero']);
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
     * @return PeliculaHasGeneroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeliculaHasGeneroQuery(get_called_class());
    }

}
