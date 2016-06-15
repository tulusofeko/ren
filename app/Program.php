<?php

namespace App;

class Program extends Usulan
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
    public function getParentAttribute($value) { return '051.01'; }

    /**
     * Get Parent
     * @return null Program is root parent now
     */
    public function getParent() { return null; }

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
     * Get Collection of Program's Childs
     * @return Collection Collection of Program's Childs
     */
    public function getChilds()
    {
        return Kegiatan::where('program', $this->code)->get();
    }

    /**
     * Get Program's Child by it's code
     * @param  string $code Kegiatan's Code
     * @return App\Kegiatan
     */
    public function getChild($code)
    {
        return Kegiatan::where([['program', $this->code], ['code', $code] ])
            ->firstOrFail();
    }

    /**
     * MAK Setter, implemented from App\Usulan
     */
    public function setMak() { return $this; }
}
