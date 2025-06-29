<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class HadithSearchController extends Controller
{
    private $apiUrl = 'http://localhost:5000';

    public function index()
    {
        $data = [
            'books' => $this->getBooks(),
            'scholars' => $this->getScholars(),
            'degrees' => $this->getDegrees(),
            'narrators' => $this->getNarrators(),
            'searchZones' => $this->getSearchZones(),
            'searchMethods' => $this->getSearchMethods(),
        ];

        return view('hadith-search.index', $data);
    }

    public function search(Request $request)
    {
        $request->validate([
            'value' => 'required|string|min:2',
            'page' => 'nullable|integer|min:1',
        ]);

        // Cache key for this specific search
        $cacheKey = 'hadith_search_' . md5(json_encode($request->all()));
        
        // Try to get from cache first (cache for 1 hour)
        if (Cache::has($cacheKey)) {
            Log::info('Returning cached hadith search results');
            return response()->json(Cache::get($cacheKey));
        }

        try {
            $params = [
                'value' => $request->input('value'),
                'page' => $request->input('page', 1),
                'removehtml' => 'true',
                'specialist' => 'false',
            ];

            if ($request->filled('books')) {
                foreach ($request->input('books') as $book) {
                    $params['s[]'] = $book;
                }
            }

            if ($request->filled('scholars')) {
                foreach ($request->input('scholars') as $scholar) {
                    $params['m[]'] = $scholar;
                }
            }

            if ($request->filled('degrees')) {
                foreach ($request->input('degrees') as $degree) {
                    $params['d[]'] = $degree;
                }
            }

            if ($request->filled('narrators')) {
                foreach ($request->input('narrators') as $narrator) {
                    $params['rawi[]'] = $narrator;
                }
            }

            if ($request->filled('search_zone')) {
                $params['t'] = $request->input('search_zone');
            }

            if ($request->filled('search_method')) {
                $params['st'] = $request->input('search_method');
            }

            $response = Http::timeout(30)->get("{$this->apiUrl}/v1/site/hadith/search", $params);
            
            Log::info('API Request URL: ' . $response->effectiveUri());
            Log::info('API Response Status: ' . $response->status());

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Check for the actual API response structure: {status, metadata, data}
                if (isset($responseData['status']) && $responseData['status'] === 'success' && 
                    isset($responseData['metadata']) && isset($responseData['data'])) {
                    
                    // Transform the response to match our expected structure
                    $transformedData = [
                        'metadata' => $responseData['metadata'],
                        'data' => $responseData['data']
                    ];
                    
                    $result = [
                        'success' => true,
                        'data' => $transformedData
                    ];
                    
                    // Cache successful results
                    Cache::put($cacheKey, $result, 3600); // 1 hour
                    
                    return response()->json($result);
                } else {
                    Log::warning('Unexpected API response structure: ' . json_encode($responseData));
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'استجابة غير متوقعة من خدمة البحث. يرجى المحاولة مرة أخرى.'
                    ]);
                }
            } else {
                if ($response->status() === 429) {
                    Log::warning('API rate limit exceeded');
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'تم تجاوز حد الطلبات المسموح (500 طلب لكل 24 ساعة). يرجى المحاولة مرة أخرى بعد 24 ساعة.'
                    ]);
                } else {
                    Log::error('API request failed with status: ' . $response->status());
                    Log::error('API error response: ' . $response->body());
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'خدمة البحث غير متاحة حالياً. يرجى المحاولة مرة أخرى لاحقاً.'
                    ]);
                }
            }

        } catch (\Exception $e) {
            Log::error('Hadith search error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في الاتصال بخدمة البحث. يرجى التحقق من الاتصال بالإنترنت والمحاولة مرة أخرى.'
            ]);
        }
    }

    private function getBooks()
    {
        return Cache::remember('hadith_books', 3600, function () {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/book");
            $data = $response->json();
            if (isset($data['data']) && is_array($data['data'])) {
                return array_map(function($item) {
                    return [
                        'key' => $item['value'],
                        'value' => $item['key']
                    ];
                }, $data['data']);
            }
            return [];
        });
    }

    private function getScholars()
    {
        return Cache::remember('hadith_scholars', 3600, function () {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/mohdith");
            $data = $response->json();
            if (isset($data['data']) && is_array($data['data'])) {
                return array_map(function($item) {
                    return [
                        'key' => $item['value'],
                        'value' => $item['key']
                    ];
                }, $data['data']);
            }
            return [];
        });
    }

    private function getDegrees()
    {
        return Cache::remember('hadith_degrees', 3600, function () {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/degree");
            $data = $response->json();
            if (isset($data['data']) && is_array($data['data'])) {
                return array_map(function($item) {
                    return [
                        'key' => $item['value'],
                        'value' => $item['key']
                    ];
                }, $data['data']);
            }
            return [];
        });
    }

    private function getNarrators()
    {
        return Cache::remember('hadith_narrators', 3600, function () {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/rawi");
            $data = $response->json();
            if (isset($data['data']) && is_array($data['data'])) {
                return array_map(function($item) {
                    return [
                        'key' => $item['value'],
                        'value' => $item['key']
                    ];
                }, $data['data']);
            }
            return [];
        });
    }

    private function getSearchZones()
    {
        return Cache::remember('hadith_search_zones', 3600, function () {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/zoneSearch");
            $data = $response->json();
            if (isset($data['data']) && is_array($data['data'])) {
                return array_map(function($item) {
                    return [
                        'key' => $item['value'],
                        'value' => $item['key']
                    ];
                }, $data['data']);
            }
            return [];
        });
    }

    private function getSearchMethods()
    {
        return Cache::remember('hadith_search_methods', 3600, function () {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/methodSearch");
            $data = $response->json();
            if (isset($data['data']) && is_array($data['data'])) {
                return array_map(function($item) {
                    return [
                        'key' => $item['value'],
                        'value' => $item['key']
                    ];
                }, $data['data']);
            }
            return [];
        });
    }
}
