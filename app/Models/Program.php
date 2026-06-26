<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Program Model
 *
 * Represents a party program or activity grouping used for budgeting and
 * journal detail classification.
 *
 * @property int         $id
 * @property string      $code
 * @property string      $name
 * @property string|null $description
 * @property bool        $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, JournalDetail> $journalDetails
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Budget>        $budgets
 */
class Program extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     */
    protected $table = 'programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                      */
    /* ------------------------------------------------------------------ */

    /**
     * Journal detail lines tagged with this program.
     */
    public function journalDetails(): HasMany
    {
        return $this->hasMany(JournalDetail::class);
    }

    /**
     * Budget allocations for this program.
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    /* ------------------------------------------------------------------ */
    /*  Local Scopes                                                       */
    /* ------------------------------------------------------------------ */

    /**
     * Filter only active programs.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
