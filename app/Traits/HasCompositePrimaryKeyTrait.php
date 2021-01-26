<?php
/**
 * Created by PhpStorm.
 * User: aireyrf
 * Date: 01/11/2018
 * Time: 13:42
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait HasCompositePrimaryKeyTrait
{

    /**
     * Set the keys for the save update query
     *
     * @param Builder $query
     * @return Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for the save query
     *
     * @param null $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

}