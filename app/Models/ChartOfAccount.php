<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * ChartOfAccount Model
 *
 * Represents an account in the party's chart of accounts. Accounts are
 * categorised by type (asset, liability, equity, revenue, expense) and carry
 * metadata such as normal balance direction and whether the account represents
 * a cash or bank instrument.
 *
 * @property int         $id
 * @property string      $code
 * @property string      $name
 * @property string      $type
 * @property string      $restriction_type
 * @property bool        $is_cash_or_bank
 * @property string      $normal_balance
 * @property bool        $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, JournalDetail> $journalDetails
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Budget>        $budgets
 */
class ChartOfAccount extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     */
    protected $table = 'chart_of_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'type',
        'restriction_type',
        'is_cash_or_bank',
        'normal_balance',
        'beginning_balance',
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
            'is_active'         => 'boolean',
            'is_cash_or_bank'   => 'boolean',
            'type'              => 'string',
            'restriction_type'  => 'string',
            'normal_balance'    => 'string',
            'beginning_balance' => 'decimal:2',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                      */
    /* ------------------------------------------------------------------ */

    /**
     * Journal detail lines posted to this account.
     */
    public function journalDetails(): HasMany
    {
        return $this->hasMany(JournalDetail::class, 'account_id');
    }

    /**
     * Budget allocations associated with this account.
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class, 'account_id');
    }

    /* ------------------------------------------------------------------ */
    /*  Local Scopes                                                       */
    /* ------------------------------------------------------------------ */

    /**
     * Filter only active accounts.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Filter accounts that are cash or bank instruments.
     */
    public function scopeCashOrBank(Builder $query): Builder
    {
        return $query->where('is_cash_or_bank', true);
    }

    /**
     * Filter accounts by their type (e.g. asset, liability, equity, revenue, expense).
     */
    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }
}
