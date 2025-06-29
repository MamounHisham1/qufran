<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

            // Try both API endpoints
            $endpoints = [
                "{$this->apiUrl}/v1/site/hadith/search",
                "{$this->apiUrl}/v1/api/hadith/search"
            ];

            $data = null;
            $lastError = null;

            foreach ($endpoints as $endpoint) {
                try {
                    $response = Http::timeout(30)->get($endpoint, $params);
                    
                    if ($response->successful()) {
                        $responseData = $response->json();
                        
                        // Check if we have valid data
                        if (isset($responseData['data']) || isset($responseData['metadata'])) {
                            $data = $responseData;
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    continue;
                }
            }

            if ($data) {
                // Ensure we have the expected structure
                if (!isset($data['data'])) {
                    $data['data'] = [];
                }
                if (!isset($data['metadata'])) {
                    $data['metadata'] = [
                        'length' => count($data['data']),
                        'page' => $params['page'],
                        'removeHTML' => true,
                        'specialist' => false
                    ];
                }

                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);
            } else {
                // Log the last error if available
                if ($lastError) {
                    Log::error('Hadith search API error: ' . $lastError);
                }

                // Return sample data for demonstration if API is not working
                $sampleData = $this->getSampleHadithData($request->input('value'));
                
                return response()->json([
                    'success' => false,
                    'data' => $sampleData,
                    'note' => 'عذراً، خدمة البحث غير متاحة حالياً. هذه بيانات تجريبية للعرض.'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Hadith search error: ' . $e->getMessage());
            
            // Return sample data as fallback
            $sampleData = $this->getSampleHadithData($request->input('value'));
            
            return response()->json([
                'success' => true,
                'data' => $sampleData,
                'note' => 'عذراً، خدمة البحث غير متاحة حالياً. هذه بيانات تجريبية للعرض.'
            ]);
        }
    }

    private function getSampleHadithData($searchTerm)
    {
        $sampleHadiths = [
            [
                'hadith' => 'إِنَّمَا الأَعْمَالُ بالنِّيَّاتِ وإِنَّمَا لِكُلِّ امْرِئٍ ما نَوَى، فَمَنْ كَانَتْ هِجْرَتُهُ إِلَى اللهِ وَرَسُولِهِ فَهِجْرَتُهُ إِلَى اللهِ وَرَسُولِهِ، وَمَنْ كَانَتْ هِجْرَتُهُ لِدُنْيَا يُصِيبُهَا أَو امْرَأَةٍ يَنْكِحُهَا فَهِجْرَتُهُ إِلَى مَا هَاجَرَ إِلَيْهِ',
                'rawi' => 'عمر بن الخطاب',
                'mohdith' => 'البخاري',
                'book' => 'صحيح البخاري',
                'numberOrPage' => '1',
                'grade' => 'صحيح',
                'explainGrade' => 'متفق عليه'
            ],
            [
                'hadith' => 'بُنِيَ الإِسْلاَمُ عَلَى خَمْسٍ: شَهَادَةِ أَنْ لاَ إِلَهَ إِلاَّ اللهُ وَأَنَّ مُحَمَّدًا رَسُولُ اللهِ، وَإِقامِ الصَّلاَةِ، وإِيتَاءِ الزَّكَاةِ، وَحَجِّ البَيْتِ، وَصَوْمِ رَمَضَانَ',
                'rawi' => 'ابن عمر',
                'mohdith' => 'البخاري',
                'book' => 'صحيح البخاري',
                'numberOrPage' => '8',
                'grade' => 'صحيح',
                'explainGrade' => 'متفق عليه'
            ],
            [
                'hadith' => 'مَنْ أَحْدَثَ فِي أَمْرِنَا هَذَا مَا لَيْسَ مِنْهُ فَهُوَ رَدٌّ',
                'rawi' => 'عائشة',
                'mohdith' => 'البخاري',
                'book' => 'صحيح البخاري',
                'numberOrPage' => '2697',
                'grade' => 'صحيح',
                'explainGrade' => 'متفق عليه'
            ]
        ];

        // Filter based on search term
        $filteredHadiths = array_filter($sampleHadiths, function($hadith) use ($searchTerm) {
            return stripos($hadith['hadith'], $searchTerm) !== false ||
                   stripos($hadith['rawi'], $searchTerm) !== false ||
                   stripos($hadith['mohdith'], $searchTerm) !== false;
        });

        // If no matches, return all sample hadiths
        if (empty($filteredHadiths)) {
            $filteredHadiths = $sampleHadiths;
        }

        return [
            'data' => array_values($filteredHadiths),
            'metadata' => [
                'length' => count($filteredHadiths),
                'page' => 1,
                'removeHTML' => true,
                'specialist' => false,
                'numberOfNonSpecialist' => count($filteredHadiths),
                'numberOfSpecialist' => 0,
                'isCached' => false
            ]
        ];
    }

    private function getBooks()
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/book");
            if ($response->successful()) {
                $data = $response->json();
                // Check if the response has the expected structure
                if (isset($data['data']) && is_array($data['data'])) {
                    // Transform the API response to match our expected format
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The book name
                            'value' => $item['key']  // The book ID
                        ];
                    }, $data['data']);
                } elseif (is_array($data)) {
                    // Transform direct array response
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The book name
                            'value' => $item['key']  // The book ID
                        ];
                    }, $data);
                }
            }
            return $this->getSampleBooks();
        } catch (\Exception $e) {
            Log::error('Error fetching books: ' . $e->getMessage());
            return $this->getSampleBooks();
        }
    }

    private function getScholars()
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/mohdith");
            if ($response->successful()) {
                $data = $response->json();
                // Check if the response has the expected structure
                if (isset($data['data']) && is_array($data['data'])) {
                    // Transform the API response to match our expected format
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The scholar name
                            'value' => $item['key']  // The scholar ID
                        ];
                    }, $data['data']);
                } elseif (is_array($data)) {
                    // Transform direct array response
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The scholar name
                            'value' => $item['key']  // The scholar ID
                        ];
                    }, $data);
                }
            }
            return $this->getSampleScholars();
        } catch (\Exception $e) {
            Log::error('Error fetching scholars: ' . $e->getMessage());
            return $this->getSampleScholars();
        }
    }

    private function getDegrees()
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/degree");
            if ($response->successful()) {
                $data = $response->json();
                // Check if the response has the expected structure
                if (isset($data['data']) && is_array($data['data'])) {
                    // Transform the API response to match our expected format
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The degree name
                            'value' => $item['key']  // The degree ID
                        ];
                    }, $data['data']);
                } elseif (is_array($data)) {
                    // Transform direct array response
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The degree name
                            'value' => $item['key']  // The degree ID
                        ];
                    }, $data);
                }
            }
            return $this->getSampleDegrees();
        } catch (\Exception $e) {
            Log::error('Error fetching degrees: ' . $e->getMessage());
            return $this->getSampleDegrees();
        }
    }

    private function getNarrators()
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/rawi");
            if ($response->successful()) {
                $data = $response->json();
                // Check if the response has the expected structure
                if (isset($data['data']) && is_array($data['data'])) {
                    // Transform the API response to match our expected format
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The narrator name
                            'value' => $item['key']  // The narrator ID
                        ];
                    }, $data['data']);
                } elseif (is_array($data)) {
                    // Transform direct array response
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The narrator name
                            'value' => $item['key']  // The narrator ID
                        ];
                    }, $data);
                }
            }
            return $this->getSampleNarrators();
        } catch (\Exception $e) {
            Log::error('Error fetching narrators: ' . $e->getMessage());
            return $this->getSampleNarrators();
        }
    }

    private function getSearchZones()
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/zoneSearch");
            if ($response->successful()) {
                $data = $response->json();
                // Check if the response has the expected structure
                if (isset($data['data']) && is_array($data['data'])) {
                    // Transform the API response to match our expected format
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The zone name
                            'value' => $item['key']  // The zone ID
                        ];
                    }, $data['data']);
                } elseif (is_array($data)) {
                    // Transform direct array response
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The zone name
                            'value' => $item['key']  // The zone ID
                        ];
                    }, $data);
                }
            }
            return $this->getSampleSearchZones();
        } catch (\Exception $e) {
            Log::error('Error fetching search zones: ' . $e->getMessage());
            return $this->getSampleSearchZones();
        }
    }

    private function getSearchMethods()
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/v1/data/methodSearch");
            if ($response->successful()) {
                $data = $response->json();
                // Check if the response has the expected structure
                if (isset($data['data']) && is_array($data['data'])) {
                    // Transform the API response to match our expected format
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The method name
                            'value' => $item['key']  // The method ID
                        ];
                    }, $data['data']);
                } elseif (is_array($data)) {
                    // Transform direct array response
                    return array_map(function($item) {
                        return [
                            'key' => $item['value'], // The method name
                            'value' => $item['key']  // The method ID
                        ];
                    }, $data);
                }
            }
            return $this->getSampleSearchMethods();
        } catch (\Exception $e) {
            Log::error('Error fetching search methods: ' . $e->getMessage());
            return $this->getSampleSearchMethods();
        }
    }

    private function getSampleBooks()
    {
        return [
            ['key' => 'صحيح البخاري', 'value' => '6216'],
            ['key' => 'صحيح مسلم', 'value' => '3088'],
            ['key' => 'الأربعون النووية', 'value' => '13457'],
            ['key' => 'سنن أبي داود', 'value' => '6267'],
            ['key' => 'سنن الترمذي', 'value' => '13509']
        ];
    }

    private function getSampleScholars()
    {
        return [
            ['key' => 'البخاري', 'value' => '256'],
            ['key' => 'مسلم', 'value' => '261'],
            ['key' => 'أبو داود', 'value' => '275'],
            ['key' => 'الترمذي', 'value' => '279'],
            ['key' => 'النسائي', 'value' => '303']
        ];
    }

    private function getSampleDegrees()
    {
        return [
            ['key' => 'جميع الدرجات', 'value' => '0'],
            ['key' => 'صحيح', 'value' => '1'],
            ['key' => 'صحيح الإسناد', 'value' => '2'],
            ['key' => 'ضعيف', 'value' => '3'],
            ['key' => 'ضعيف الإسناد', 'value' => '4']
        ];
    }

    private function getSampleNarrators()
    {
        return [
            ['key' => 'أبو هريرة', 'value' => '2664'],
            ['key' => 'عمر بن الخطاب', 'value' => '8918'],
            ['key' => 'ابن عباس', 'value' => '2665'],
            ['key' => 'عائشة', 'value' => '1819'],
            ['key' => 'أنس بن مالك', 'value' => '1234']
        ];
    }

    private function getSampleSearchZones()
    {
        return [
            ['key' => 'جميع النطاقات', 'value' => '0'],
            ['key' => 'الأحاديث النبوية', 'value' => '1'],
            ['key' => 'الأحاديث القدسية', 'value' => '2']
        ];
    }

    private function getSampleSearchMethods()
    {
        return [
            ['key' => 'البحث العادي', 'value' => '0'],
            ['key' => 'البحث الدقيق', 'value' => '1'],
            ['key' => 'البحث بالجذر', 'value' => '2']
        ];
    }
} 