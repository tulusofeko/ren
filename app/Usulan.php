<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Usulan extends Model 
{
    abstract public function getParentAttribute($value);
    abstract public function getParent();
    abstract public function getChild($code);
    abstract public function childs();

    protected $appends  = [
        'parentId', 'mak', 'level', 'state', 'continue', 'next'
    ];

    protected $state    = 'closed';
    protected $continue = false;
    protected $next;

    /**
     * Getter for Parent ID Attribute
     * @param  mixed  $value
     * @return string Parent ID
     */
    public function getParentIdAttribute($value)
    {
        return $this->parent;
    }

    public function getMakAttribute($value)
    {

        return $this->parent . "." . $this->code;
    }

    public function getStateAttribute($value)
    {
        return $this->state;
    }

    public function getContinueAttribute($value)
    {
        return $this->continue;
    }

    public function setContinue($state = true)
    {
        $this->continue = (bool) $state;
    }

    public function getNextAttribute($value)
    {
        return $this->next;
    }

    public function setNextAttribute($next)
    {
        $this->next = $next;
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