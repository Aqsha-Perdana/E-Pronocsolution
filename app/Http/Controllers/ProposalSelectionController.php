<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProposalSelectionController extends Controller
{
    public function show($page = 'list')
    {
        // Cek apakah view-nya ada
        $validPages = ['list', 'review', 'progress', 'final', 'done'];

        if (!in_array($page, $validPages)) {
            abort(404);
        }

        return view('proposal', [
            'page' => $page,
        ]);
    }
}
