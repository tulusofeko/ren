<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Usulan
{
    protected $state    = 'open';

    public function __construct()
    {
        $this->append('code');

        parent::__construct();
    }

    /**
     * Getter for Parent's instance
     * @return App\Komponen
     */
    public function getParent()
    {
        try {
            $parent = SubKomponen::where('id', $this->parent)->firstOrFail();
            return $parent;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Getter for MAK attribute
     * @param  mixed  $value
     * @return string Node MAK
     */
    public function getMakAttribute($value)
    {
        return $this->parent_id . "." . $this->id;
    }

    /**
     * Getter for Code attribute
     * @param  mixed  $value
     * @return string Node Code
     */
    public function getCodeAttribute($value)
    {
        return '-';
    }

    /**
     * Get Collection of SubKomponen's Childs
     * @return Collection of App\Aktivitas
     */
    public function childs()
    {
        return collect([]);
    }

    /**
     * Get SubKomponen's Child by it's code
     * @param  string $code Aktivitas's Id
     * @return App\Aktivitas
     */
    public function getChild($code)
    {
        return null;
    }

    /**
     * Get SubKomponen's Pagu
     * @return mixed
     */
    public function getPaguAttribute($value)
    {
        return "-";
    }
}
