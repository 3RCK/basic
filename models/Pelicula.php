<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Pelicula".
 *
 * @property int $idPelicula
 * @property string|null $portada
 * @property string|null $titulo
 * @property string|null $sipnosis
 * @property int|null $anio
 * @property string|null $duracion
 * @property int $Director_idDirector
 *
 * @property ActorHasPelicula[] $actorHasPeliculas
 * @property Actor $actorIdActor
 * @property Genero $generoIdGenero
 * @property Director $directorIdDirector
 * @property PeliculaHasGenero[] $peliculaHasGeneros
 */
class Pelicula extends \yii\db\ActiveRecord
{
    public $imageFile; 
    public $actors = [];
    public $genders = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Pelicula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portada', 'titulo', 'sipnosis', 'anio', 'duracion'], 'default', 'value' => null],
            [['anio', 'Director_idDirector'], 'integer'],
            [['duracion'], 'safe'],
            [['Director_idDirector'], 'required'],
            [['portada', 'sipnosis'], 'string', 'max' => 255],
            [['titulo'], 'string', 'max' => 100],
            [['actors' , 'genders'], 'each', 'rule' => ['integer']],
            [['Director_idDirector'], 'exist', 'skipOnError' => true, 'targetClass' => Director::class, 'targetAttribute' => ['Director_idDirector' => 'idDirector']],
            [['imageFile'],'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPelicula' => Yii::t('app', 'Id Pelicula'),
            'portada' => Yii::t('app', 'Portada'),
            'titulo' => Yii::t('app', 'Titulo'),
            'sipnosis' => Yii::t('app', 'Sipnosis'),
            'anio' => Yii::t('app', 'Año'),
            'duracion' => Yii::t('app', 'Duracion'),
            'Director_idDirector' => Yii::t('app', 'Director'),
            'actors' => Yii::t('app', 'Actores'),
            'genders' => Yii::t('app', 'Genero'),
        ];
    }
    public function upload()
{
    if ($this->validate()) {
        // Nombre de archivo único
        $filename = 'pelicula_' . time() . '.' . $this->imageFile->extension;
        $path = Yii::getAlias('@webroot/portadas/') . $filename;

        // Guardar archivo físico
        if ($this->imageFile->saveAs($path)) {
            // Eliminar portada anterior si existe
            if ($this->portada && $this->portada !== $filename) {
                $this->deletePortada();
            }

            // Guardar nombre en el atributo y guardar en BD
            $this->portada = $filename;
            return $this->save(false); // Guardar sin volver a validar
        }
    }
    return false;
}

    public function deletePortada(){
    $path = Yii::getAlias('@webroot/portadas/') . $this->portada;
    if (file_exists($path)) {
        unlink($path);
        }
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        if (is_array($this->actors)) {
            foreach ($this->actors as $ActorId) {
            $ActorHasPelicula = new ActorHasPelicula();
            $ActorHasPelicula->Actor_idActor = $ActorId;
            $ActorHasPelicula->Pelicula_idPelicula = $this->idPelicula;
            $ActorHasPelicula->save();
            }
        }
    }

    public function beforeDelete(){
        if (!parent::beforeDelete()) {
            return false;
        }

            ActorHasPelicula::deleteAll(['Pelicula_idPelicula' => $this->idPelicula]);

            return true;
    }

    /**
     * Gets query for [[ActorHasPeliculas]].
     *
     * @return \yii\db\ActiveQuery|ActorHasPeliculaQuery
     */
    public function getActorHasPeliculas()
    {
        return $this->hasMany(ActorHasPelicula::class, ['Pelicula_idPelicula' => 'idPelicula']);
    }

    /**
     * Gets query for [[DirectorIdDirector]].
     *
     * @return \yii\db\ActiveQuery|DirectorQuery
     */
    public function getDirectorIdDirector()
    {
        return $this->hasOne(Director::class, ['idDirector' => 'Director_idDirector']);
    }

    /**
     * Gets query for [[PeliculaHasGeneros]].
     *
     * @return \yii\db\ActiveQuery|PeliculaHasGeneroQuery
     */
    public function getPeliculaHasGeneros()
    {
        return $this->hasMany(PeliculaHasGenero::class, ['Pelicula_idPelicula' => 'idPelicula']);
    }

    /**
     * {@inheritdoc}
     * @return PeliculaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeliculaQuery(get_called_class());
    }

}

//<script>
//    document.querySelector("#actor-search").addEventListener('input', function() {
//        let actors = document.querySelectorAll("#actors-select option");
//            actors.forEach(actor => {
//                 if (actor.text.toLowerCase().includes(this.value.toLowerCase())) {
//                     actor.style.display = 'block';
//                } else {
//                    actor.style.display = 'none';
//                }
 //           });
 //        });
//</script>