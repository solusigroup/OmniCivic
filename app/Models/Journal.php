<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Journal Model
 *
 * The central transactional record of the accounting system. Each journal
 * represents a double-entry transaction with one or more detail lines. It
 * follows a draft → review → approved/rejected workflow.
 *
 * This is the **most important** model in the application — all financial
 * reports are derived from journals with the `approved` status.
 *
 * @property int         $id
 * @property int         $branch_id
 * @property string      $transaction_type
 * @property \Illuminate\Support\Carbon $transaction_date
 * @property string      $reference_number
 * @property string|null $description
 * @property string      $status
 * @property string|null $rejection_reason
 * @property int         $created_by
 * @property int|null    $reviewed_by
 * @property int|null    $approved_by
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read Branch                                                    $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, JournalDetail> $details
 * @property-read User                                                      $creator
 * @property-read User|null                                                 $reviewer
 * @property-read User|null                                                 $approver
 *
 * @property-read float $total_debit   Computed sum of all detail debit amounts.
 * @property-read float $total_credit  Computed sum of all detail credit amounts.
 * @property-read bool  $is_balanced   Whether total debits equal total credits.
 */
class Journal extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     */
    protected $table = 'journals';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'branch_id',
        'transaction_type',
        'transaction_date',
        'reference_number',
        'description',
        'status',
        'rejection_reason',
        'created_by',
        'reviewed_by',
        'approved_by',
        'reviewed_at',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'status'           => 'string',
            'transaction_type' => 'string',
            'reviewed_at'      => 'datetime',
            'approved_at'      => 'datetime',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                      */
    /* ------------------------------------------------------------------ */

    /**
     * The branch that owns this journal.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * The detail (line-item) entries of this journal.
     */
    public function details(): HasMany
    {
        return $this->hasMany(JournalDetail::class);
    }

    /**
     * The user who created (drafted) this journal.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The user who reviewed this journal.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * The user who approved (or rejected) this journal.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ------------------------------------------------------------------ */
    /*  Local Scopes                                                       */
    /* ------------------------------------------------------------------ */

    /**
     * **CRITICAL** — Filter only approved journals.
     *
     * All financial report queries MUST use this scope to ensure only
     * finalised, approved transactions are included in calculations.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Filter journals that are still in draft status.
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    /**
     * Filter journals belonging to a specific branch.
     */
    public function scopeForBranch(Builder $query, int $branchId): Builder
    {
        return $query->where('branch_id', $branchId);
    }

    /**
     * Filter journals whose transaction_date falls within the given range.
     */
    public function scopeDateRange(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('transaction_date', [$from, $to]);
    }

    /* ------------------------------------------------------------------ */
    /*  Helper Methods                                                     */
    /* ------------------------------------------------------------------ */

    /**
     * Determine whether this journal can still be edited.
     *
     * Only journals in "draft" status are editable.
     */
    public function isEditable(): bool
    {
        return $this->status === 'draft';
    }

    /* ------------------------------------------------------------------ */
    /*  Accessors                                                          */
    /* ------------------------------------------------------------------ */

    /**
     * Computed total of all detail debit amounts.
     */
    public function getTotalDebitAttribute(): float
    {
        return (float) $this->details->sum('debit');
    }

    /**
     * Computed total of all detail credit amounts.
     */
    public function getTotalCreditAttribute(): float
    {
        return (float) $this->details->sum('credit');
    }

    /**
     * Check whether total debits equal total credits (balanced entry).
     */
    public function getIsBalancedAttribute(): bool
    {
        return bccomp((string) $this->total_debit, (string) $this->total_credit, 2) === 0;
    }
}
