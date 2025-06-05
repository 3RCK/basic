<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Actor".
 *
 * @property int $idActor
 * @property string|null $nombre
 * @property string|null $apellido
 * @property string|null $biografia
 * @property string|null $foto
 *
 * @property ActorHasPelicula[] $actorHasPeliculas
 */
class Actor extends \yii\db\ActiveRecord
{
    public $imageFile;

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
            [['nombre', 'apellido', 'biografia', 'foto'], 'default', 'value' => null],
            [['nombre', 'apellido', 'biografia', 'foto'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
            'foto' => Yii::t('app', 'Foto'),
            'imageFile' => Yii::t('app', 'Imagen'),
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
     * Sube la imagen del actor
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile instanceof UploadedFile) {
                $filename = $this->idActor . '_actor_' . date('Ymd_His') . '.' . $this->imageFile->extension;
                $path = Yii::getAlias('@webroot/fotos/') . $filename;

                if ($this->imageFile->saveAs($path)) {
                    if ($this->foto && $this->foto != $filename) {
                        $this->deleteFoto();
                    }

                    $this->foto = $filename;
                    return $this->save(false);
                }
            }
        }
        return false;
    }

    /**
     * Elimina la imagen del actor
     */
    public function deleteFoto()
    {
        $path = Yii::getAlias('@webroot/fotos/') . $this->foto;
        if (file_exists($path)) {
            unlink($path);
        }
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
