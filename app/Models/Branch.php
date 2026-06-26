<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Branch Model
 *
 * Represents an organisational branch (DPP, DPW, DPD, etc.) within the
 * political party hierarchy. Branches own journals and form a self-referencing
 * tree via parent_id.
 *
 * @property int         $id
 * @property int|null    $parent_id
 * @property string      $tier
 * @property string      $code
 * @property string      $name
 * @property bool        $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read Branch|null                              $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Branch>   $children
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Journal>  $journals
 */
class Branch extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'branches';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parent_id',
        'tier',
        'code',
        'name',
        'identity_settings',
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
            'tier'              => 'string',
            'identity_settings' => 'array',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Relationships                                                      */
    /* ------------------------------------------------------------------ */

    /**
     * The parent branch in the organisational hierarchy.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'parent_id');
    }

    /**
     * Direct child branches.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Branch::class, 'parent_id');
    }

    /**
     * Journals recorded under this branch.
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    /* ------------------------------------------------------------------ */
    /*  Local Scopes                                                       */
    /* ------------------------------------------------------------------ */

    /**
     * Filter branches by their tier enum value.
     */
    public function scopeTier(Builder $query, string $tier): Builder
    {
        return $query->where('tier', $tier);
    }

    /**
     * Filter only active branches.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
