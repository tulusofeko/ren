<?php

namespace App;

class Kegiatan extends Usulan
{
    
    /**
     * Getter for Parent MAK attribute
     * @param  mixed  $value
     * @return string Parent MAK
     */
    public function getParentAttribute($value)
    {
        return "051.01." . $this->program;
    }

    /**
     * Get Parent Program
     * @return App\Program
     */
    public function getParent()
    {
        try {
            
            $parent = Program::where('code', $this->program)->firstOrFail();

        } catch (Exception $e) {

            return null;
        }

        return $parent;
    }

    /**
     * Get Collection of Kegiatan's Childs
     * @return Collection Collection of Kegiatan's Childs
     */
    public function childs()
    {
        return $this->hasMany('App\Output', 'kegiatan', 'code');
    }
    
    /**
     * Get Kegiatan's Child by it's code
     * @param  string $code Output's Code
     * @return App\Output
     */
    public function getChild($code)
    {
        return Output::where([['kegiatan', $this->code], ['code', $code] ])
            ->firstOrFail();
    }
}
