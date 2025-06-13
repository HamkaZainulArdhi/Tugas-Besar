<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurnal;
use App\Models\Review;
use App\Models\HasilPenilaian;
use App\Models\journal_revisions;
use App\Models\KategoriPenilaian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalUsers = User::count();
        $totalJurnals = Jurnal::count();
        $totalReviews = HasilPenilaian::count();
        $totalRevisions = journal_revisions::count();

        // Recent Journals (last 5)
        $recentJurnals = Jurnal::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Monthly Activity (last 6 months)
        $monthlyActivity = collect();
        for ($i = 4; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthData = [
                'month' => $date->format('M Y'),
                'jurnals' => Jurnal::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'reviews' => HasilPenilaian::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
            $monthlyActivity->push($monthData);
        }

        // Journal Categories Distribution
        $jurnalByCategory = Jurnal::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        // Top Reviewers
        $topReviewers = User::whereHas('hasilPenilaian')
            ->withCount('hasilPenilaian as review_count')
            ->orderBy('review_count', 'desc')
            ->take(5)
            ->get();

        // Popular Assessment Categories
        $popularCategories = KategoriPenilaian::withCount([
            'hasilPenilaian as usage_count'
        ])
        ->orderBy('usage_count', 'desc')
        ->take(6)
        ->get();

        // salam selamat pagi. siang / malam
        $hour = Carbon::now('Asia/Jakarta')->format('H'); // Pastikan pakai Asia/Jakarta

        if ($hour >= 5 && $hour < 11) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalJurnals',
            'totalReviews',
            'totalRevisions',
            'recentJurnals',
            'monthlyActivity',
            'jurnalByCategory',
            'topReviewers',
            'popularCategories',
            'greeting'
        ));
    }
}