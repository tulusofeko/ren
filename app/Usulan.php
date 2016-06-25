<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Usulan extends Model 
{
    abstract public function getParent();
    abstract public function getChild($code);
    abstract public function childs();

    protected $appends  = ['parentId', 'mak', 'level', 'state'];

    protected $state    = 'closed';

    public function getParentIdAttribute($value)
    {
        return $this->getParent()->mak;
    }

    public function getMakAttribute($value)
    {
        return $this->parent_id . "." . $this->code;
    }

    public function getStateAttribute($value)
    {
        return $this->state;
    }
    
    public function getlevelAttribute($value) 
    {
        $namespace = get_called_class();
        $class     = substr($namespace, strrpos($namespace, '\\')+1);

        return strtolower($class);
    }
    
    /**
     * Set the Programs's name. Name Attribute
     *
     * @param  string  $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

}