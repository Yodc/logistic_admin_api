<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';
    protected $primaryKey = 'task_id';
    public $incrementing = true;

    protected $fillable = [];
    protected $hidden = [];
    protected $guarded = [];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function stage()
    {
        return $this->hasOne('App\Models\Stage','stage_id','stage_id');
    }

    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice','invoice_id','invoice_id');
    }

    public function packing_list()
    {
        return $this->hasOne('App\Models\PackingList','packing_list_id','packing_list_id');
    }

}
