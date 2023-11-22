<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetValueCategory extends Model
{
    use HasFactory;
    use Auditable;
    public $guarded = [];

    public function questions(){
        return $this->hasMany(AssetValueQuestion::class, 'asset_value_category_id');
    }
}
