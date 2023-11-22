<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlObjective extends Model
{
    use HasFactory;

    public $guarded = [];

    public function controls()
    {
        return $this->belongsToMany(FrameworkControl::class, 'controls_control_objectives', 'objective_id', 'control_id')->withPivot('id');
    }
}
