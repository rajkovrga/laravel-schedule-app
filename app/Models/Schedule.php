<?php

namespace App\Models;

use App\Casts\MultiTimestampRangeCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon $schedule_date
 */
class Schedule extends Model
{
    protected $fillable = [
        'dates',
        'user_id',
        'manager_id',
        'company_id',
        'company_job_id',
        'schedule_date'
    ];

    protected function casts(): array
    {
        return [
            'dates' => MultiTimestampRangeCast::class,
            'schedule_date' => 'datetime'
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
