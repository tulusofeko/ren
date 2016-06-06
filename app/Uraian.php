<?php

namespace App;

interface Uraian 
{
    public function getStateAttribute($value);
    public function getParentIdAttribute($value);
    public function getMakAttribute($value);
    public function getChilds();
    public function getChild($code);
}