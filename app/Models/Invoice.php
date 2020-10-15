<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    protected $primaryKey = 'invoice_id';
    public $incrementing = true;

    protected $fillable = [];
    protected $hidden = [];
    protected $guarded = [];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function details()
    {
        return $this->hasMany('App\Models\InvoiceDetail','invoice_id','invoice_id');
    }

}
