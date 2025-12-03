<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name','points_per_kg'];

    public function submissions()
    {
        return $this->hasMany(WasteSubmission::class,'category_id');
    }
}
