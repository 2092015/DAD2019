<?php
/**
 * Created by PhpStorm.
 * User: ciscomen
 * Date: 06/01/2019
 * Time: 19:37
 */

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class InvoiceItem extends Authenticatable
{
    protected $fillable = [
        'invoice_id',
        'item_id',
        'quantity',
        'unit_price',
        'sub_total_price'
    ];
    protected $table = 'invoice_items';
    protected $primaryKey = ['invoice_id', 'item_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}