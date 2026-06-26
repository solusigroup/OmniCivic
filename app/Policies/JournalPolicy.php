<?php

namespace App\Policies;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JournalPolicy
{
    /**
     * Determine whether the user can view any models (list).
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive();
    }

    /**
     * Determine whether the user can view the journal.
     *
     * Rules:
     * - User must be active.
     * - Super Admin can view all journals.
     * - Other roles can only view journals within their designated branch.
     */
    public function view(User $user, Journal $journal): bool
    {
        if (!$user->isActive()) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        return $journal->branch_id === $user->branch_id;
    }

    /**
     * Determine whether the user can create journals.
     *
     * Rules:
     * - User must be active.
     * - Only 'Staff Akuntansi' (staff) can create journals.
     * - Must have a branch assigned.
     */
    public function create(User $user): bool
    {
        return $user->isActive() 
            && $user->isStaff() 
            && $user->branch_id !== null;
    }

    /**
     * Determine whether the user can update the journal.
     *
     * Rules:
     * - User must be active.
     * - Only 'Staff Akuntansi' (staff) can edit journals.
     * - Only journals in 'draft' or 'rejected' status can be edited.
     * - Must belong to the same branch.
     */
    public function update(User $user, Journal $journal): bool
    {
        return $user->isActive()
            && $user->isStaff()
            && $journal->branch_id === $user->branch_id
            && in_array($journal->status, ['draft', 'rejected'], true);
    }

    /**
     * Determine whether the user can delete the journal.
     *
     * Rules:
     * - User must be active.
     * - Only 'Staff Akuntansi' (staff) can delete journals.
     * - Only 'draft' status journals can be deleted.
     * - Must belong to the same branch.
     */
    public function delete(User $user, Journal $journal): bool
    {
        return $user->isActive()
            && $user->isStaff()
            && $journal->branch_id === $user->branch_id
            && $journal->status === 'draft';
    }

    /**
     * Determine whether the user can review the journal.
     *
     * Rules:
     * - User must be active.
     * - Only 'Bendahara' (reviewer) can review journals.
     * - Must belong to the same branch.
     * - Current journal status must be 'draft' (to move to reviewed or rejected).
     */
    public function review(User $user, Journal $journal): bool
    {
        return $user->isActive()
            && $user->isBendahara()
            && $journal->branch_id === $user->branch_id
            && $journal->status === 'draft';
    }

    /**
     * Determine whether the user can approve/reject the journal.
     *
     * Rules:
     * - User must be active.
     * - Only 'Ketua' (approver) can approve/reject journals.
     * - Must belong to the same branch.
     * - Current journal status must be 'reviewed' (to move to approved or rejected).
     */
    public function approve(User $user, Journal $journal): bool
    {
        return $user->isActive()
            && $user->isKetua()
            && $journal->branch_id === $user->branch_id
            && $journal->status === 'reviewed';
    }
}
