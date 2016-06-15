<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Usulan extends Model 
{
    abstract public function getParentAttribute($value);
    abstract public function getParent();
    abstract public function getChilds();
    abstract public function getChild($code);
    abstract public function setMak();

    protected $appends  = ['parentId', 'level', 'state', 'continue', 'next'];

    protected $state    = 'closed';
    protected $continue = false;
    protected $next;

    public function getParentIdAttribute($value)
    {
        return $this->parent;
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

    public function setNextLoad($next)
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
     * Set the Programs's name.
     *
     * @param  string  $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }
}