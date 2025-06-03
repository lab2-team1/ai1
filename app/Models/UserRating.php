<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    protected $fillable = [
        'transaction_id',
        'rated_user_id',
        'rated_by_user_id',
        'rating',
        'comment',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function ratedUser()
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }

    public function ratedByUser()
    {
        return $this->belongsTo(User::class, 'rated_by_user_id');
    }
}
