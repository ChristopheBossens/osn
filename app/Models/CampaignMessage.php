<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * Get the campaign to which the message belongs
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function campaign(){
        return $this->belongsTo(Campaign::class)->get();
    }

    /**
     * Returns the user who created the message
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function creator(){
        return $this->belongsTo(User::class, 'created_by')->get();
    }
}
