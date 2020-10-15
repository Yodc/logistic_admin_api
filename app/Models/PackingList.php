<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    protected $table = 'packing_list';
    protected $primaryKey = 'packing_list_id';
    public $incrementing = true;

    protected $fillable = [];
    protected $hidden = [];
    protected $guarded = [];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function details()
    {
        return $this->hasMany('App\Models\PackingListDetail','packing_list_id','packing_list_id');
    }

}
