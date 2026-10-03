<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeCheckpoint;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $challenges = Challenge::withCount('checkpoints')->get()->map(function (Challenge $c) use ($user) {
            $c->is_completed = $user->challenges?->contains(fn ($uc) => $uc->id === $c->id && $uc->pivot->status === 'completed') ?? false;
            $c->verified_count = $c->checkpoints->isNotEmpty()
                ? $c->checkpoints->filter(fn ($cp) => $user->verifiedCheckpoints?->contains($cp->id) ?? false)->count()
                : 0;

            return $c;
        });

        return view('challenge.index', [
            'challenges' => $challenges,
            'stampsAchieved' => $user->challenges()->wherePivot('status', 'completed')->count(),
            'creditPoints' => $user->credits,
        ]);
    }

    public function show(Request $request, Challenge $challenge)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $challenge->load('checkpoints');

        $checkpoints = $challenge->checkpoints->map(function (ChallengeCheckpoint $cp) use ($user) {
            $cp->is_verified = $user->verifiedCheckpoints?->contains($cp->id) ?? false;

            return $cp;
        });

        $verifiedCount = $checkpoints->where('is_verified', true)->count();
        $totalCount = $checkpoints->count();

        return view('challenge.show', [
            'challenge' => $challenge,
            'checkpoints' => $checkpoints,
            'verifiedCount' => $verifiedCount,
            'totalCount' => $totalCount,
            'allVerified' => $totalCount > 0 && $verifiedCount === $totalCount,
            'isCompleted' => $user->challenges?->contains(fn ($uc) => $uc->id === $challenge->id && $uc->pivot->status === 'completed') ?? false,
        ]);
    }

    public function verifyCheckpoint(Request $request, ChallengeCheckpoint $checkpoint)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $user->verifiedCheckpoints()->syncWithoutDetaching([$checkpoint->id]);

        return back();
    }

    public function claim(Request $request, Challenge $challenge)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $challenge->load('checkpoints');

        if ($challenge->checkpoints->isNotEmpty()) {
            $verifiedCount = $challenge->checkpoints->filter(fn ($cp) => $user->verifiedCheckpoints?->contains($cp->id) ?? false)->count();
            abort_if($verifiedCount < $challenge->checkpoints->count(), 400, 'Selesaikan semua checkpoint dulu.');
        }

        $user->challenges()->syncWithoutDetaching([
            $challenge->id => ['status' => 'completed', 'completed_at' => now()],
        ]);
        $user->increment('credits', $challenge->point_reward);

        return redirect()->route('challenge.claimed', $challenge);
    }

    public function claimed(Challenge $challenge)
    {
        return view('challenge.claimed', compact('challenge'));
    }

    public function passport(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $challenges = Challenge::all()->map(function (Challenge $c) use ($user) {
            $c->is_completed = $user->challenges?->contains(fn ($uc) => $uc->id === $c->id && $uc->pivot->status === 'completed') ?? false;

            return $c;
        });

        return view('challenge.passport', compact('challenges'));
    }
}