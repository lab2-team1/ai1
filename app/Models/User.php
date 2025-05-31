<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'admin' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    //Function that unifies a phone number into one format
    public function setPhoneAttribute($value)
    {
        $phone = preg_replace('/[^0-9]/', '', $value);

        if (substr($phone, 0, 2) === '48') {
            $phone = substr($phone, 2);
        }

        if (strlen($phone) === 9) {
            $this->attributes['phone'] = substr($phone, 0, 3) . '-' . substr($phone, 3, 3) . '-' . substr($phone, 6, 3);
        } else {
            $this->attributes['phone'] = $value;
        }
    }

    /**
     * Get the addresses for the user.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function listings()
    {
        return $this->hasMany(\App\Models\Listing::class);
    }
}
