<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function updateSkills(Request $request)
{
    $user = auth()->user();

    // Hapus semua skill lama
    $user->skills()->delete();

    // Simpan skill baru
    foreach ($request->skills as $skill) {
        $user->skills()->create([
            'skill' => $skill['skill']
        ]);
    }

    return response()->json(['message' => 'Skills updated']);
}


public function store(Request $request)
{
    $skill = Skill::create([
        'user_id' => auth()->id(),
        'skill' => $request->skill
    ]);

    return response()->json($skill);
}

public function destroy(Skill $skill)
{
    $skill->delete();
    return response()->json(['status' => 'deleted']);
}


}