<?php

namespace App\Models;

use App\Events\UpdateOnlinePayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'bank_first_response' => 'array',
        'bank_second_response' => 'array',
    ];

    protected $dispatchesEvents = [
        'updated' => UpdateOnlinePayment::class,
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
