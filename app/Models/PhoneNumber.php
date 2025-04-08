<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = ['contacts_id', 'phone_number', 'type'];

    public function contact()
    {
        return $this->belongsTo(Contacts::class);
    }
}
