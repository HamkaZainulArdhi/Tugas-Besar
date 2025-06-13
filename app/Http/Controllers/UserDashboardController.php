<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\HasilPenilaian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all journals with relationships
        $jurnals = Jurnal::where('user_id', $user->id)
            ->with(['hasilPenilaian.kategoriPenilaian', 'hasilPenilaian.reviewer'])
            ->latest()
            ->get();
        
        // Basic Statistics
        $totalJurnals = $jurnals->count();
        $pendingReviews = $jurnals->filter(function($jurnal) {
            return $jurnal->hasilPenilaian->isEmpty();
        })->count();
        $needsRevision = $jurnals->filter(function($jurnal) {
            return $jurnal->hasilPenilaian->contains('is_accepted', false);
        })->count();
        $acceptedJurnals = $jurnals->filter(function($jurnal) {
            return $jurnal->hasilPenilaian->isNotEmpty() && 
                   $jurnal->hasilPenilaian->every('is_accepted', true);
        })->count();

        // buat Recent 
        $recentJurnals = $jurnals->take(5);
        
       // bulan seting di statsitik
        $monthlyStats = collect();
        for ($i = 3; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = $jurnals->filter(function($jurnal) use ($date) {
                return $jurnal->created_at->format('Y-m') === $date->format('Y-m');
            })->count();
            $monthlyStats->put($date->format('F Y'), $count);
        }

        
        $categoryStats = $jurnals->groupBy('kategori')
            ->map(function ($items) {
                return $items->count();
            });

      // categori
        $allCategories = ['Scopus', 'Sinta 1', 'Sinta 2', 'Sinta 3'];
        foreach ($allCategories as $category) {
            if (!$categoryStats->has($category)) {
                $categoryStats->put($category, 0);
            }
        }

        // Review Score Statistics
        $reviewScores = [];
        foreach ($jurnals as $jurnal) {
            foreach ($jurnal->hasilPenilaian as $hasil) {
                $aspek = $hasil->kategoriPenilaian->aspek;
                if (!isset($reviewScores[$aspek])) {
                    $reviewScores[$aspek] = [
                        'total' => 0,
                        'count' => 0
                    ];
                }
                $reviewScores[$aspek]['total'] += $hasil->is_accepted ? 1 : 0;
                $reviewScores[$aspek]['count']++;
            }
        }

        
        foreach ($reviewScores as &$score) {
            $score['average'] = $score['count'] > 0 
                ? ($score['total'] / $score['count']) * 100 
                : 0;
        }

        
        $latestReviews = $jurnals->flatMap(function($jurnal) {
            return $jurnal->hasilPenilaian;
        })->sortByDesc('created_at')->take(5);

        
        $upcomingDeadlines = $jurnals->filter(function($jurnal) {
            return $jurnal->hasilPenilaian->isEmpty() || 
                   $jurnal->hasilPenilaian->contains('is_accepted', false);
        })->take(5);

        
        $completionRate = $totalJurnals > 0 
            ? ($acceptedJurnals / $totalJurnals) * 100 
            : 0;

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


        return view('dashboard', compact(
            'totalJurnals',
            'pendingReviews',
            'needsRevision',
            'acceptedJurnals',
            'recentJurnals',
            'monthlyStats',
            'categoryStats',
            'reviewScores',
            'latestReviews',
            'upcomingDeadlines',
            'completionRate',
            'user',
            'greeting'
        ));
    }
}
