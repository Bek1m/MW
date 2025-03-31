<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class PrayerTimeService
{
    protected $baseUrl = 'http://api.aladhan.com/v1/';

    /**
     * Get prayer times for a specific date and location
     *
     * @param string $date Format: DD-MM-YYYY
     * @param float $latitude
     * @param float $longitude
     * @param int $method Calculation method (default: 2 for ISNA)
     * @return array
     */
    public function getPrayerTimes($date = null, $latitude = 41.8387, $longitude = 20.9574, $method = 2)
    {
        // Default to today if no date provided
        $date = $date ?? Carbon::now()->format('d-m-Y');
        
        try {
            $response = Http::get($this->baseUrl . 'timings/' . $date, [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'method' => $method,
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['error' => 'Failed to fetch prayer times'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    /**
     * Get prayer times for the current month
     *
     * @param int $month
     * @param int $year
     * @param float $latitude
     * @param float $longitude
     * @param int $method
     * @return array
     */
    public function getMonthlyPrayerTimes($month = null, $year = null, $latitude = 41.8387, $longitude = 20.9574, $method = 2)
    {
        $month = $month ?? Carbon::now()->month;
        $year = $year ?? Carbon::now()->year;
        
        try {
            $response = Http::get($this->baseUrl . 'calendar', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'method' => $method,
                'month' => $month,
                'year' => $year,
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return ['error' => 'Failed to fetch monthly prayer times'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}