<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','category_id','weight','points','status','verified_by','verified_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(WasteCategory::class,'category_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class,'verified_by');
    }
}
