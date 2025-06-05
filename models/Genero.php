<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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
    public $peliculas = []; // Para múltiples películas
    public $imageFile; // Si quieres cargar una imagen de género
    public $imagen; // Campo de la base de datos si lo tienes

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
            [['peliculas'], 'each', 'rule' => ['integer']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
            'peliculas' => Yii::t('app', 'Películas'),
            'imageFile' => Yii::t('app', 'Imagen'),
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
     * Carga y guarda la imagen del género si existe
     */
    public function upload()
    {
        if ($this->validate()) {
            $filename = 'genero_' . time() . '.' . $this->imageFile->extension;
            $path = Yii::getAlias('@webroot/generos/') . $filename;

            if ($this->imageFile->saveAs($path)) {
                if ($this->imagen && $this->imagen !== $filename) {
                    $this->deleteImagen();
                }

                $this->imagen = $filename;
                return $this->save(false);
            }
        }
        return false;
    }

    /**
     * Elimina la imagen anterior
     */
    public function deleteImagen()
    {
        $path = Yii::getAlias('@webroot/generos/') . $this->imagen;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * Inserta registros en la tabla PeliculaHasGenero
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (is_array($this->peliculas)) {
            foreach ($this->peliculas as $peliculaId) {
                $rel = new PeliculaHasGenero();
                $rel->Genero_idGenero = $this->idGenero;
                $rel->Pelicula_idPelicula = $peliculaId;
                $rel->save();
            }
        }
    }

    /**
     * Borra relaciones antes de eliminar el género
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        PeliculaHasGenero::deleteAll(['Genero_idGenero' => $this->idGenero]);

        return true;
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
