<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_detail';
    protected $primaryKey = 'invoice_detail_id';
    public $incrementing = true;

    protected $fillable = [];
    protected $hidden = [];
    protected $guarded = [];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
