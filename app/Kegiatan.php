<?php

namespace App;

class Kegiatan extends Usulan
{
    /**
     * Konstruktor, Append MAK to query when building a query.
     */
    public function __construct()
    {
        parent::__construct();

        $this->append('mak');   
    }

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
     * Getter for MAK attribute
     * @param  mixed  $value
     * @return string MAK
     */
    public function getMakAttribute($value)
    {
        return $this->parent . '.' . $this->code;
    }

    /**
     * Get Collection of Kegiatan's Childs
     * @return Collection Collection of Kegiatan's Childs
     */
    public function getChilds()
    {
        return Output::where('kegiatan', $this->code)->get();
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

    /**
     * MAK Setter, implemented from App\Usulan
     */
    public function setMak() { return $this; }
}
