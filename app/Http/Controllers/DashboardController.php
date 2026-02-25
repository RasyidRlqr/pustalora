<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        $activeLoans = Loan::with(['book', 'bookCopy'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('due_date', 'asc')
            ->get();

        $recentLoans = Loan::with(['book', 'bookCopy'])
            ->where('user_id', $user->id)
            ->where('status', 'returned')
            ->orderBy('return_date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('activeLoans', 'recentLoans'));
    }
}
