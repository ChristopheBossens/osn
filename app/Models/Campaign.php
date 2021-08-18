<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable
     * @var string[]
     */
    protected $guarded = ['id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
