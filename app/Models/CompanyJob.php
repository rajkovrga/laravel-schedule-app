<?php

namespace App\Models;

use App\Utils\Roles;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Models\Role;

class CompanyJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'company_id'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $query) {
            $user = auth()->user();

            if ($user->hasRole(Roles::User)) {
                return;
            }

            if (!$user->hasRole(Roles::Admin)) {
                $query->where('company_id', auth()->user()->company_id);
            }
        });
    }
}
