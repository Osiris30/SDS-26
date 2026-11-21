<?php

namespace App\Http\Controllers;

use App\Models\ActivityEvidence;
use App\Models\User;
use Illuminate\View\View;

class PublicEvidenceController extends Controller
{
    public function show(string $profile): View
    {
        $profileData = config('evidence-profiles.'.$profile);
        abort_unless($profileData, 404);

        $contributorIds = User::whereIn('email', $profileData['emails'])->pluck('id');
        abort_if($contributorIds->isEmpty(), 404);
        $evidences = ActivityEvidence::with('post.category')
            ->whereIn('user_id', $contributorIds)
            ->whereHas('post', fn ($query) => $query
                ->where('is_published', true)
                ->where(fn ($published) => $published->whereNull('published_at')->orWhere('published_at', '<=', now())))
            ->latest()
            ->get()
            ->groupBy('post_id');

        return view('evidence.profile', [
            'profile' => $profileData,
            'evidenceGroups' => $evidences->map(fn ($items) => [
                'post' => $items->first()->post,
                'images' => $items,
            ])->values(),
        ]);
    }
}
