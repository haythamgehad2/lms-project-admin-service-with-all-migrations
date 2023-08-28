<?php
namespace App\Models;
use App\Enums\RoleTypeEnum;
// use App\Models\Scopes\UserRolesScop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
class Role extends Model
{
    use HasTranslations,HasFactory;

    public $translatable = ['name','description'];

    protected $fillable = ['name','code','description','is_default','system_role'];

    public const SUPER_ADMIN_ROLE_ID = 1;
    public const SCHOOLADMIN_ROLE_ID = 2;
    public const SUPERVISOR_ROLE_ID = 3;
    public const TEACHER_ROLE_ID = 4;
    public const STUDENT_ROLE_ID = 5;
    public const PARENT_ROLE_ID = 6;



    //   /**
    //  * Globale Scope function
    //  *
    //  * @return void
    //  */
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope(new UserRolesScop);
    // }
     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'type' => RoleTypeEnum::class,
    ];
    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    /**
     * The permissions that belong to the role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }
}
