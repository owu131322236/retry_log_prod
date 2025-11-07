<?php

namespace App\Services;

use App\Models\Reaction;
use App\Models\ReactionCount;
use Illuminate\Support\Facades\Auth;

class ReactionService
{
    public function toggleReaction(string $targetType, int $targetId, int $reactionTypeId): array
    {
        $userId = Auth::id();

        $existing = Reaction::where('user_id', $userId)
            ->where('target_type', $targetType)
            ->where('target_id', $targetId)
            ->where('reaction_type_id', $reactionTypeId)
            ->first();

        if ($existing) {
            $existing->delete();
            return ['status' => 'removed'];
        }
        Reaction::create([
            'user_id'=>$userId,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'reaction_type_id' => $reactionTypeId,
        ]);

        return ['status' => 'added'];
    }

    public function getReactions(string $targetType, int $targetId)
    {
        return Reaction::where('target_type', $targetType)
            ->where('target_id', $targetId)
            ->with(['user', 'reactionType'])
            ->get();
    }

    public function getReactionCounts(string $targetType, int $targetId)
    {
        return ReactionCount::where('target_type', $targetType)
            ->where('target_id', $targetId)
            ->with('reactionType')
            ->get();
    }

    public function userReaction(string $targetType, int $targetId)
    {
        $reaction = Reaction::where('user_id', Auth::id())
            ->where('target_type', $targetType)
            ->where('target_id', $targetId)
            ->first();

        return [
            'reacted' => (bool) $reaction,
            'reaction' => $reaction,
        ];
    }
}
