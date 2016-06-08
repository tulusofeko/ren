<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Usulan extends Model 
{
    abstract public function getStateAttribute($value);
    abstract public function getParentIdAttribute($value);
    abstract public function getChilds();
    abstract public function getChild($code);


    protected $appends = ['state', 'parentId', 'mak', 'level'];
    
    public function getlevelAttribute($value) 
    {
        $namespace = get_called_class();
        $class     = substr($namespace, strrpos($namespace, '\\')+1);

        return strtolower($class);
    }
    
    /**
     * Set the Programs's name.
     *
     * @param  string  $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    /**
     * Getter for MAK attribute
     * @param  mixed  $value
     * @return string MAK
     */
    public function getMakAttribute($value)
    {
        return $this->parentId . '.' . $this->code;
    }
}