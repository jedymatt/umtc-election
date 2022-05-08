<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElectionFinalizedWinnerController extends Controller
{
    public function store(Request $request, Election $election)
    {

        $validator = Validator::make($request->all(), [
            'winners.*' => 'required|integer',
        ]);

        $validated = $validator->validate();

        foreach ($validated['winners'] as $positionId => $winnerId) {
            $election->winners()
                ->whereHas('candidate', function (Builder $query) use ($positionId, $winnerId) {
                    $query->where('position_id', '=', $positionId);
                })
                ->where('id', '!=', $winnerId)->delete();
        }

        return redirect()->route('admin.monitor-election', $election);
    }
}
