<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Storage;

class Datduk extends Model
{
    public function delete()
    {
        Storage::delete('datduks/DATDUK_' . $this->id);
        
        parent::delete();
    }
}
