<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $table = 'stage';
    protected $primaryKey = 'stage_id';
    public $incrementing = true;

    protected $fillable = [];
    protected $hidden = [];
    protected $guarded = [];

    const CREATED_AT = null;
    const UPDATED_AT = null;

}
