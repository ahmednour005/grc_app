<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetValueLevel extends Model
{
    use HasFactory;
    use Auditable;
    public $guarded = [];
}
