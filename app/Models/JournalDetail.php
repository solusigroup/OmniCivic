<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * JournalDetail Model
 *
 * Represents a single line item within a journal entry. Each detail records
 * a debit or credit amount against an account, and optionally tags it with
 * a program, division, and fund source for dimensional reporting.
 *
 * This model does NOT use SoftDeletes — detail rows are cascade-deleted
 * together with their parent journal.
 *
 * @property int         $id
 * @property int         $journal_id
 * @property int         $account_id
 * @property float       $debit
 * @property float       $credit
 * @property int|null    $program_id
 * @property int|null    $division_id
 * @property int|null    $fund_source_id
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Journal        $journal
 * @property-read ChartOfAccount $account
 * @property-read Program|null   $program
 * @property-read Division|null  $division
 * @property-read FundSource|null $fundSource
 */
class JournalDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'journal_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'journal_id',
        'account_id',
        'debit',
        'credit',
        'program_id',
        'division_id',
        'fund_source_id',
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
            'debit'  => 'decimal:2',
            'credit' => 'decimal:2',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                      */
    /* ------------------------------------------------------------------ */

    /**
     * The parent journal this detail line belongs to.
     */
    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    /**
     * The chart-of-account entry this line is posted against.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    /**
     * The program associated with this line item (optional).
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * The division associated with this line item (optional).
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * The fund source associated with this line item (optional).
     */
    public function fundSource(): BelongsTo
    {
        return $this->belongsTo(FundSource::class);
    }
}
