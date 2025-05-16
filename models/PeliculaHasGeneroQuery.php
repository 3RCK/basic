<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PeliculaHasGenero]].
 *
 * @see PeliculaHasGenero
 */
class PeliculaHasGeneroQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PeliculaHasGenero[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PeliculaHasGenero|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
