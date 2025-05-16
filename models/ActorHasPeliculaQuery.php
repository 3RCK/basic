<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ActorHasPelicula]].
 *
 * @see ActorHasPelicula
 */
class ActorHasPeliculaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ActorHasPelicula[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ActorHasPelicula|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
