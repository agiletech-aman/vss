<?php
// ═══════════════════════════════════════════════════════════════
// FILE: app/Http/Controllers/AdminController.php
// UPDATED: Simplified for AJAX dashboard
// ═══════════════════════════════════════════════════════════════

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DashboardService;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show dashboard page (stats loaded via AJAX)
     */
    public function Dashboard()
    {
        // Just render the view - data loads via AJAX
        return view('admin.dashboard');
    }

    /**
     * Logout
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
