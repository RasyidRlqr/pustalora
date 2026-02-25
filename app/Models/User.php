<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'member_code',
        'phone',
        'address',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }

    /**
     * Generate a unique member code for the user.
     */
    public static function generateMemberCode(): string
    {
        $prefix = 'PST';
        $year = date('Y');
        $randomNumber = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        $memberCode = $prefix . $year . $randomNumber;

        // Ensure uniqueness
        while (self::where('member_code', $memberCode)->exists()) {
            $randomNumber = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            $memberCode = $prefix . $year . $randomNumber;
        }

        return $memberCode;
    }

    /**
     * Check if user profile is complete (has address and phone).
     */
    public function isProfileComplete(): bool
    {
        return !empty($this->address) && !empty($this->phone);
    }
}
