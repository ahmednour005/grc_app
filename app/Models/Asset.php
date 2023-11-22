<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\AssetCreated;

class Asset extends Model
{
    use HasFactory;
    use Auditable;

    public $timestamps = false;

    public $guarded = [];

    // protected $dispatchesEvents = [
    //     'created' => AssetCreated::class
    // ];

    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function assetValue()
    {
        return $this->belongsTo(AssetValue::class);
    }

    public function assetCategory()
    {
        return $this->belongsTo(AssetCategory::class);
    }
    public function assetValueLevel()
    {
        return $this->belongsTo(AssetValueLevel::class);
    }

    /**
     * Get the asset's teams.
     *
     * @param  string  $value
     * @return array
     */
    public function getTeamsAttribute($value)
    {
        $teamsId = explode(',', $value);
        return is_array($teamsId) ? $teamsId : [];
    }

    public function teamsName()
    {
        return Team::whereIn('id', $this->teams)->pluck('name');
    }

    public function teamsId()
    {
        return Team::whereIn('id', $this->teams)->pluck('id')->toArray();
    }

    /**
     * Get all of the tags for the asset.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    /**
     * Get all of the groups for the asset.
     */
    public function assetGroups()
    {
        return $this->belongsToMany(AssetGroup::class);
    }
    /**
     * Get all of the tags for the asset.
     */
    public function assetTags()
    {
        return $this->belongsToMany(Tag::class, 'taggables', 'taggable_id');
    }
    public function risks()
    {
        return $this->belongsToMany(Risk::class, 'risks_to_assets');
    }

    /**
     * Get the vulnerabilities associated with the asset.
     */
    public function vulnerabilities()
    {
        return $this->belongsToMany(Vulnerability::class, 'asset_vulnerabilities');
    }
}
