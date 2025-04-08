<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contacts extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company', 'address'];

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}

