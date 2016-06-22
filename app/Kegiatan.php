<?php

namespace App;

class Kegiatan extends Usulan
{
    
    /**
     * Getter for Parent MAK attribute
     * @param  mixed  $value
     * @return string Parent MAK
     */
    public function getParentIdAttribute($value)
    {
        return "051.01." . $this->parent;
    }

    /**
     * Get Parent Program
     * @return App\Program
     */
    public function getParent()
    {
        try {
            $parent = Program::where('code', $this->parent)->firstOrFail();
        
            return $parent;

        } catch (Exception $e) {

            return null;
        }
    }

    /**
     * Get Collection of Kegiatan's Childs
     * @return Collection Collection of Kegiatan's Childs
     */
    public function childs()
    {
        return $this->hasMany('App\Output', 'parent', 'code');
    }
    
    /**
     * Get Kegiatan's Child by it's code
     * @param  string $code Output's Code
     * @return App\Output
     */
    public function getChild($code)
    {
        return Output::where([['parent', $this->code], ['code', $code] ])->firstOrFail();
    }
}
