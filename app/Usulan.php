<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Usulan extends Model 
{
    abstract public function getPaguAttribute($value);
    abstract public function getParent();
    abstract public function getChild($code);
    abstract public function childs();

    protected $appends  = ['parentId', 'mak', 'level', 'state', 'pagu'];

    protected $state    = 'closed';

    /**
     * Getter for Parent MAK attribute
     * @param  mixed  $value
     * @return string Parent MAK
     */
    public function getParentIdAttribute($value)
    {
        return $this->getParent()->mak;
    }

    /**
     * Getter for MAK attribute
     * @param  mixed  $value
     * @return string Node MAK
     */
    public function getMakAttribute($value)
    {
        return $this->parent_id . "." . $this->code;
    }

    /**
     * Getter for State attribute, untuk menentukan leaf atau tree
     * @param  mixed  $value
     * @return string state
     */
    public function getStateAttribute($value)
    {
        return $this->state;
    }
    
    /**
     * Getter for level attribute, untuk menentukan aksi dari row klik
     * @param  mixed  $value
     * @return string node level
     */
    public function getlevelAttribute($value) 
    {
        $namespace = get_called_class();
        $class     = substr($namespace, strrpos($namespace, '\\')+1);

        return strtolower($class);
    }
    
    /**
     * Set the Programs's name. Name Attribute
     * Untuk memastikan data yang masuk dengan huruf kapital di awal 
     * @param  string  $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

}