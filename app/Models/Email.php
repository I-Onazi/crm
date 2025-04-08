<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;

    protected $fillable = ['contacts_id', 'email', 'type'];

    public function contact()
    {
        return $this->belongsTo(Contacts::class);
    }
}
