<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    /* ELIMINAZIONE SOFT */
    use SoftDeletes;

    protected $fillable = ['title', 'cover', 'beds', 'rooms', 'bathrooms', 'address', 'sqm', 'longitude', 'latitude', 'description', 'user_id'];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class)->withPivot('expiration_date');
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Counter views
    public function viewsCount()
    {
        return $this->views()->count();
    }

    // Counter messag
    public function messagesCount()
    {
        return $this->messages()->count();
    }
}
