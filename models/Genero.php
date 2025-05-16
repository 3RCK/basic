<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Genero".
 *
 * @property int $idGenero
 * @property string|null $nombre
 * @property string|null $descripcion
 *
 * @property PeliculaHasGenero[] $peliculaHasGeneros
 */
class Genero extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Genero';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion'], 'default', 'value' => null],
            [['nombre', 'descripcion'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idGenero' => Yii::t('app', 'Id Genero'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * Gets query for [[PeliculaHasGeneros]].
     *
     * @return \yii\db\ActiveQuery|PeliculaHasGeneroQuery
     */
    public function getPeliculaHasGeneros()
    {
        return $this->hasMany(PeliculaHasGenero::class, ['Genero_idGenero' => 'idGenero']);
    }

    /**
     * {@inheritdoc}
     * @return GeneroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneroQuery(get_called_class());
    }

}
