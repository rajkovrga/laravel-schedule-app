<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;

    public function users(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function jobs(): BelongsTo {
        return $this->belongsTo(CompanyJob::class);
    }
}
