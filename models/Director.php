<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Director".
 *
 * @property int $idDirector
 * @property string|null $nombre
 * @property string|null $apellido
 * @property string|null $fecha_nacimiento
 * @property string|null $foto
 * @property UploadedFile $imageFile
 *
 * @property Pelicula[] $peliculas
 */
class Director extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public static function tableName()
    {
        return 'Director';
    }

    public function rules()
    {
        return [
            [['nombre', 'apellido', 'fecha_nacimiento'], 'default', 'value' => null],
            [['fecha_nacimiento'], 'safe'],
            [['nombre', 'apellido'], 'string', 'max' => 45],
            [['foto'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idDirector' => Yii::t('app', 'Id Director'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellido' => Yii::t('app', 'Apellido'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'foto' => Yii::t('app', 'Foto'),
            'imageFile' => Yii::t('app', 'Subir Foto'),
        ];
    }

    public function getPeliculas()
    {
        return $this->hasMany(Pelicula::class, ['Director_idDirector' => 'idDirector']);
    }

    public static function find()
    {
        return new DirectorQuery(get_called_class());
    }

    /**
     * Sube la imagen a la carpeta 'web/directores/' y guarda el nombre del archivo.
     * Si ya existe una imagen anterior, la elimina.
     * @return bool
     */
    public function upload()
    {
        if ($this->imageFile) {
            $carpeta = Yii::getAlias('@webroot/directores/');
            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $nombreArchivo = uniqid() . '.' . $this->imageFile->extension;
            $rutaCompleta = $carpeta . $nombreArchivo;

            if ($this->imageFile->saveAs($rutaCompleta)) {
                // Eliminar imagen anterior si existe
                if (!empty($this->foto) && file_exists($carpeta . $this->foto)) {
                    unlink($carpeta . $this->foto);
                }

                $this->foto = $nombreArchivo; // Guardar solo el nombre del archivo
                return true;
            }
        }
        return false;
    }

    /**
     * Elimina la imagen asociada al director, si existe.
     */
    public function deleteFoto()
    {
        if (!empty($this->foto)) {
            $ruta = Yii::getAlias('@webroot/directores/' . $this->foto);
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
    }
}
