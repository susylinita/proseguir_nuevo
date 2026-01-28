<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalSelectorController extends Controller
{
    public function select(string $portal)
    {
        abort_unless(in_array($portal, ['postulantes', 'kits']), 404);

        if (! auth()->check()) {
            session(['portal_intent' => $portal]);
            return redirect()->route('login');
        }

        $user = auth()->user();
        $user->portal = $portal;
        $user->save();

        return redirect()->route($portal === 'kits' ? 'kits.dashboard' : 'student.dashboard');
    }

    public function index()
    {
        // Vista simple con 2 botones para cambiar portal
        return view('portal.selector');
    }

    public function store(Request $request)
    {
        $portal = $request->validate([
            'portal' => ['required', 'in:postulantes,kits'],
        ])['portal'];

        $user = $request->user();
        $user->portal = $portal;
        $user->save();

        return redirect()->route($portal === 'kits' ? 'kits.dashboard' : 'student.dashboard');
    }
}
