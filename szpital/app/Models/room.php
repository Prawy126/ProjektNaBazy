<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['rnumber','rlocation','status','type_room','seats'];

    public $timestamps = false;

    public function procedure(): HasOne
    {
        return $this->hasOne(Procedure::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

}
