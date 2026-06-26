<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Budget Model
 *
 * Represents a budget allocation linking an account, program, and division
 * for a given fiscal year.
 *
 * @property int         $id
 * @property int         $account_id
 * @property int         $program_id
 * @property int         $division_id
 * @property float       $amount
 * @property int         $fiscal_year
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read ChartOfAccount $account
 * @property-read Program        $program
 * @property-read Division       $division
 */
class Budget extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     */
    protected $table = 'budgets';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'account_id',
        'program_id',
        'division_id',
        'amount',
        'fiscal_year',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount'      => 'decimal:2',
            'fiscal_year' => 'integer',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                      */
    /* ------------------------------------------------------------------ */

    /**
     * The chart-of-account entry this budget is allocated to.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    /**
     * The program this budget is allocated for.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * The division this budget is allocated to.
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /* ------------------------------------------------------------------ */
    /*  Local Scopes                                                       */
    /* ------------------------------------------------------------------ */

    /**
     * Filter budgets for a specific fiscal year.
     */
    public function scopeForYear(Builder $query, int $year): Builder
    {
        return $query->where('fiscal_year', $year);
    }
}
