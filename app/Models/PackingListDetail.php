<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingListDetail extends Model
{
    protected $table = 'packing_list_detail';
    protected $primaryKey = 'packing_list_detail_id';
    public $incrementing = true;

    protected $fillable = [];
    protected $hidden = [];
    protected $guarded = [];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
