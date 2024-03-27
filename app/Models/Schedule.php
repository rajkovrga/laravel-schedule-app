<?php

namespace App\Models;

use App\Casts\MultiTimestampRangeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'dates',
        'user_id',
        'manager_id',
        'company_id',
        'job_id',
    ];


    protected function casts(): array
    {
        return [
            'dates' => MultiTimestampRangeCast::class,
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function companyJob(): BelongsTo
    {
        return $this->belongsTo(CompanyJob::class);
    }
}
