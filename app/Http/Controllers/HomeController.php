<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PrayerTimeService;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    protected $prayerTimeService;
    
    public function __construct(PrayerTimeService $prayerTimeService = null)
    {
        // Use dependency injection if possible, otherwise create the service
        $this->prayerTimeService = $prayerTimeService ?? new PrayerTimeService();
    }
    
    public function index()
    {
        // Get featured posts
        $featured = Post::with(['user', 'categories'])
            ->where('is_approved', true)
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();
            
        // Get recent announcements
        $announcements = Post::with(['user', 'categories'])
            ->where('is_approved', true)
            ->where('type', 'announcement')
            ->latest()
            ->take(5)
            ->get();
            
        // Get upcoming events
        $events = Post::with(['user', 'categories'])
            ->where('is_approved', true)
            ->where('type', 'event')
            ->whereNotNull('event_date')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get();
        
        // Get today's prayer times
        $prayerTimes = $this->prayerTimeService->getPrayerTimes();
        $todayPrayers = $prayerTimes['data']['timings'] ?? null;
            
        return view('home', compact('featured', 'announcements', 'events', 'todayPrayers'));
    }
    
    public function contact()
    {
        return view('contact');
    }
    
    public function prayerTimes(Request $request)
    {
        $latitude = $request->input('latitude', 41.8387);  // Default to Tetovo, North Macedonia
        $longitude = $request->input('longitude', 20.9574);
        
        $month = (int) $request->input('month', Carbon::now()->month);
        $year = (int) $request->input('year', Carbon::now()->year);
        
        // Get prayer times for today
        $today = $this->prayerTimeService->getPrayerTimes(
            Carbon::now()->format('d-m-Y'),
            $latitude, 
            $longitude
        );
        
        // Get prayer times for the entire month
        $monthly = $this->prayerTimeService->getMonthlyPrayerTimes(
            $month,
            $year,
            $latitude,
            $longitude
        );
        
        $monthName = Carbon::createFromDate($year, $month, 1)->format('F');
        
        return view('prayer-times', compact('today', 'monthly', 'month', 'year', 'monthName'));
    }
}