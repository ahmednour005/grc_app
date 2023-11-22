<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Document;

class DocumentTypes extends Model
{
    use HasFactory;

    public $guarded = [];

    /**
     * Get the comments for the blog post.
     */

    public function documents()
    {
        return $this->hasMany(Document::class,'document_type');
    }

 }
