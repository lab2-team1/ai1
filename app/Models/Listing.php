<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'status'
    ];

    protected $attributes = [
        'status' => 'active'
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_SOLD = 'sold';
    const STATUS_EXPIRED = 'expired';

    public static $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_SOLD,
        self::STATUS_EXPIRED
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isSold()
    {
        return $this->status === self::STATUS_SOLD;
    }

    public function isExpired()
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' PLN';
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeSold($query)
    {
        return $query->where('status', self::STATUS_SOLD);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopePriceRange($query, $min, $max)
    {
        if ($min) {
            $query->where('price', '>=', $min);
        }
        if ($max) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    public function isOwnedBy($userId)
    {
        return $this->user_id === $userId;
    }

    public function markAsSold()
    {
        $this->update(['status' => self::STATUS_SOLD]);
    }

    public function markAsExpired()
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
    }

    public function reactivate()
    {
        if ($this->status === self::STATUS_EXPIRED) {
            $this->update(['status' => self::STATUS_ACTIVE]);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($listing) {
            // Delete all associated images from storage and database
            foreach ($listing->images as $image) {
                if (file_exists(public_path('storage/' . $image->image_url))) {
                    unlink(public_path('storage/' . $image->image_url));
                }
                $image->delete();
            }
        });
    }
}
