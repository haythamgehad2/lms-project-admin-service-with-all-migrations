<?php

namespace App\Models;

use App\Enums\UserStatusEnum;
use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable implements HasMedia
{
    const ACTIVE_STATUS = 1;
    const BLOCKED_STATUS = 2;
    const DEACTIVATED_STATUS = 3;
    const UNVERIFIED_STATUS = 4;

    use InteractsWithMedia,HasTranslations, HasApiTokens, HasFactory, Notifiable,UploadImageTrait;


    public const mediaCollectionName="user_image";

    /**
     * translatable variable
     *
     * @var array
     */
    public $translatable = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'is_super_admin',
        'mobile',
        'social_media',
        'school_id',
        'is_school_admin'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => UserStatusEnum::class,
    ];

   /**
     * Undocumented function
     *
     * @param Media $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('theme')->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_MAX,1000,1000)
            ->nonQueued();
    }
    /**
     * ThemeImage function
     *
     * @return Attribute
     */
    public function mediaCollectionName() : Attribute {
        return Attribute::make(
            get: fn() => self::mediaCollectionName,
        );
    }

    /**
     * UserImage function
     *
     * @return Attribute
     */
    public function avatar() : Attribute {
        return Attribute::make(
            get: fn($value) =>
                $this?->media?->first() ?
                    $this->getFirstMediaUrl(self::mediaCollectionName, 'user_image'):
                    ($this->image ? url($this->image) : url("storage/noimage.jpg"))
        );
    }

    /**
     * roles function
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }


      /**
     * ThemeImage function
     *
     * @return Attribute
     */
    public function password() : Attribute {
        return Attribute::make(
            set: fn($value) =>Hash::make($value),

        );
    }

       /**
     * Get & Set the Country's name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function socialMedia(): Attribute
    {


        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    /**
     * Enrollment function
     *
     * @return HasMany
     */
    public function enrollments(): HasMany
    {
        return $this->HasMany(Enrollment::class);
    }

     /**
     * Enrollment function
     *
     * @return HasMany
     */
    public function classStudents(): HasMany
    {
        return $this->HasMany(ClassStudent::class);
    }

    public function studentActionHistory(): HasMany {
        return $this->HasMany(StudentActionHistory::class, "student_id");
    }

    public function userCredit(): HasOne {
        return $this->hasOne(UserCredit::class, "user_id");
    }

    public function scopeStudent(Builder $query) : Builder {
        return $query->whereHas('roles', fn ($q) => $q->where('code', 'student'));
    }


    /**
     * Get all of the deployments for the project.
     */
    public function enrollmentsRoles(): belongsToMany
    {
        return $this->belongsToMany(Role::class,'enrollments')->withTimestamps();
    }


    /**
     * Get all of the deployments for the project.
     */
    public function schoolOwner(): HasMany
    {
        return $this->hasMany(School::class,'admin_id');
    }
}
