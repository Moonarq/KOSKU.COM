<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kos;
use App\Models\Apartment;

class LandingController extends Controller
{
    private $indonesianCities = [
        'Jakarta' => [
            'Menteng', 'Kemang', 'Kuningan', 'Sudirman', 'Thamrin', 'Tebet', 'Kelapa Gading', 'Depok'
        ],
        'Bandung' => [
            'Dago', 'Riau', 'Buah Batu', 'Pasteur', 'Setiabudi', 'Dipatiukur', 'Ciumbuleuit'
        ],
        'Yogyakarta' => [
            'Malioboro', 'Seturan', 'Jakal', 'Kaliurang', 'Prawirotaman', 'Gejayan', 'Babarsari'
        ],
        'Surabaya' => [
            'Gubeng', 'Wonokromo', 'Darmo', 'Rungkut', 'Wiyung', 'Mulyorejo', 'Tenggilis'
        ],
        'Malang' => [
            'Soekarno Hatta', 'Dieng', 'Sawojajar', 'Sulfat', 'Tidar', 'Tlogomas', 'Lowokwaru'
        ],
        'Semarang' => [
            'Tembalang', 'Pleburan', 'Banyumanik', 'Pedurungan', 'Gayamsari', 'Ngaliyan'
        ]
    ];

    private $popularAreas = [
        'Jakarta' => ['Kemang', 'Menteng', 'Kebayoran Baru', 'Kelapa Gading', 'Tebet'],
        'Bandung' => ['Dago', 'Setiabudi', 'Cihampelas', 'Pasteur', 'Buah Batu'],
        'Surabaya' => ['Gubeng', 'Wonokromo', 'Rungkut', 'Wiyung', 'Kenjeran'],
        'Yogyakarta' => ['Malioboro', 'Seturan', 'Kaliurang', 'Pogung', 'Jakal'],
        'Semarang' => ['Tembalang', 'Pleburan', 'Pedurungan', 'Banyumanik', 'Ngaliyan']
    ];

    // Definisi area pusat kota untuk beberapa kota
    private $pusatKotaAreas = [
        'Jakarta' => ['Menteng', 'Sudirman', 'Thamrin', 'Kebayoran Baru'],
        'Bandung' => ['Dago', 'Riau', 'Setiabudi', 'Sukajadi'],
        'Yogyakarta' => ['Malioboro', 'Seturan', 'Kaliurang'],
        'Surabaya' => ['Gubeng', 'Wonokromo', 'Darmo'],
        'Semarang' => ['Tembalang', 'Pleburan', 'Pedurungan'],
        'Malang' => ['Soekarno Hatta', 'Dieng', 'Sawojajar'],
    ];

// Definisi area dekat kampus untuk beberapa kota
private $dekatkampusAreas = [
    'Jakarta' => [
        'Depok', 'Salemba', 'Pancoran', 'UI Depok', 'Binus Kemanggisan', 'Trisakti',
        'Kuningan', 'Thamrin', 'Menteng', 'Cikini', 'Kalibata', 'Senayan',
        'Pasar Minggu', 'Cawang', 'Mampang Prapatan', 'Setiabudi', 'Kebayoran Baru'
    ],
    'Bandung' => [
        'Dago', 'Dipatiukur', 'Ganesha', 'ITB', 'Unpad Jatinangor', 'Buah Batu',
        'Ciumbuleuit', 'Cibiru', 'Sukajadi', 'Cicendo', 'Pasteur', 'Soreang',
        'Rancaekek', 'Lembang', 'Margacinta', 'Cidadap'
    ],
    'Yogyakarta' => [
        'Seturan', 'Babarsari', 'Gejayan', 'UGM', 'Pogung', 'Jakal',
        'Malioboro', 'Tegalrejo', 'Gamping', 'Wonosari', 'Sleman', 'Kotagede',
        'Kota Baru', 'Pathuk'
    ],
    'Surabaya' => [
        'Mulyorejo', 'Gubeng', 'ITS Sukolilo', 'Unair', 'Rungkut', 'Tenggilis',
        'Dukuh Pakis', 'Wonokromo', 'Gunungsari', 'Bubutan', 'Simokerto',
        'Wiyung', 'Lakarsantri', 'Genteng'
    ],
    'Semarang' => [
        'Tembalang', 'Undip', 'Pleburan', 'Banyumanik', 'Unnes',
        'Candisari', 'Genuk', 'Pedurungan', 'Gayamsari', 'Mijen', 'Tugu',
        'Semarang Tengah', 'Semarang Utara'
    ],
    'Malang' => [
        'Dieng', 'Sawojajar', 'Tlogomas', 'UB Malang', 'Lowokwaru', 'Sulfat',
        'Klojen', 'Blimbing', 'Kedungkandang', 'Batu', 'Pakisaji', 'Singosari'
    ]
];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kos = Kos::orderBy('created_at', 'desc')->paginate(10);
        $apartments = Apartment::orderBy('created_at', 'desc')->take(10)->get();
        $locations = $this->getFormattedLocations();
        return view('landing.index', [
            'kos' => $kos,
            'apartments' => $apartments,
            'locations' => $locations,
            'popularAreas' => $this->popularAreas,
        ]);
    }

    private function getFormattedLocations()
    {
        $formatted = [];
        foreach ($this->indonesianCities as $cityName => $areas) {
            $formatted[] = [
                'name' => $cityName,
                'areas' => array_map(function($area) {
                    return [
                        'name' => $area,
                    ];
                }, $areas)
            ];
        }
        return $formatted;
    }

    public function search(Request $request)
    {
        $query = strtolower(trim($request->get('query')));
        $displayQuery = $request->get('query');
        $gender = $request->get('gender');
        $priceRange = $request->get('price_range');
        $locationType = $request->get('location_type');

        if (empty($query) && empty($gender) && empty($priceRange) && empty($locationType)) {
            return redirect()->route('index');
        }

        // Label untuk tampilan hasil jika pakai location_type tanpa query text
        if (empty($displayQuery) && $locationType === 'popular_area') {
            $displayQuery = 'Popular Area';
        }
        
        // Label untuk tampilan hasil jika pakai query 'premium'
        if (strtolower($query) === 'premium') {
            $displayQuery = 'Premium';
        }

        $matchedLocations = [];
        $kosQuery = Kos::query();

        // Filter berdasarkan location_type dari dropdown
        if ($locationType) {
            if ($locationType === 'pusat_kota') {
                // Gabungkan semua area pusat kota
                $allPusatKotaAreas = [];
                foreach ($this->pusatKotaAreas as $areas) {
                    $allPusatKotaAreas = array_merge($allPusatKotaAreas, $areas);
                }

                $kosQuery->where(function($q) use ($allPusatKotaAreas) {
                    foreach ($allPusatKotaAreas as $area) {
                        $q->orWhere('address', 'like', "%{$area}%");
                    }
                    $q->orWhere('address', 'like', "%pusat kota%");
                });
            } elseif ($locationType === 'dekat_kampus') {
                // Gabungkan semua area dekat kampus
                $allDekatkampusAreas = [];
                foreach ($this->dekatkampusAreas as $areas) {
                    $allDekatkampusAreas = array_merge($allDekatkampusAreas, $areas);
                }

                $kosQuery->where(function($q) use ($allDekatkampusAreas) {
                    foreach ($allDekatkampusAreas as $area) {
                        $q->orWhere('address', 'like', "%{$area}%");
                    }
                    $q->orWhere('address', 'like', "%kampus%");
                    $q->orWhere('address', 'like', "%universitas%");
                    $q->orWhere('address', 'like', "%college%");
                });
            } elseif ($locationType === 'popular_area') {
                $allPopularAreas = [];
                foreach ($this->popularAreas as $areas) {
                    $allPopularAreas = array_merge($allPopularAreas, $areas);
                }

                $kosQuery->where(function ($q) use ($allPopularAreas) {
                    foreach ($allPopularAreas as $area) {
                        $q->orWhere('address', 'like', "%{$area}%");
                    }
                    $q->orWhere('address', 'like', "%popular%");
                });
            }
        }

        // Jika ada query pencarian, tambahkan ke filter
        if (!empty($query)) {
            // Jika pencarian mengandung kata 'pusat kota'
            if (strpos($query, 'pusat kota') !== false) {
                // Gabungkan semua area pusat kota
                $allPusatKotaAreas = [];
                foreach ($this->pusatKotaAreas as $areas) {
                    $allPusatKotaAreas = array_merge($allPusatKotaAreas, $areas);
                }

                if ($locationType) {
                    // Jika sudah ada location_type filter, gunakan AND
                    $kosQuery->where(function($q) use ($allPusatKotaAreas) {
                        foreach ($allPusatKotaAreas as $area) {
                            $q->orWhere('address', 'like', "%{$area}%");
                        }
                        $q->orWhere('address', 'like', "%pusat kota%");
                    });
                } else {
                    // Jika belum ada location_type filter
                    $kosQuery->where(function($q) use ($allPusatKotaAreas) {
                        foreach ($allPusatKotaAreas as $area) {
                            $q->orWhere('address', 'like', "%{$area}%");
                        }
                        $q->orWhere('address', 'like', "%pusat kota%");
                    });
                }
            }
            // Jika pencarian mengandung kata 'popular'
            elseif (strpos($query, 'popular') !== false) {
                $allPopularAreas = [];
                foreach ($this->popularAreas as $areas) {
                    $allPopularAreas = array_merge($allPopularAreas, $areas);
                }

                $kosQuery->where(function($q) use ($allPopularAreas) {
                    foreach ($allPopularAreas as $area) {
                        $q->orWhere('address', 'like', "%{$area}%");
                    }
                    $q->orWhere('address', 'like', "%popular%");
                });
            }
            // Jika pencarian mengandung kata 'premium' - filter kos dengan minimal 5 fasilitas
            elseif (strpos($query, 'premium') !== false) {
                // Filter kos yang memiliki minimal 5 fasilitas
                $kosQuery->whereRaw('JSON_LENGTH(facilities) >= 5');
            }
            // Jika pencarian mengandung kata 'dekat kampus'
            elseif (strpos($query, 'dekat kampus') !== false) {
                // Gabungkan semua area dekat kampus
                $allDekatkampusAreas = [];
                foreach ($this->dekatkampusAreas as $areas) {
                    $allDekatkampusAreas = array_merge($allDekatkampusAreas, $areas);
                }

                if ($locationType) {
                    // Jika sudah ada location_type filter, gunakan AND
                    $kosQuery->where(function($q) use ($allDekatkampusAreas) {
                        foreach ($allDekatkampusAreas as $area) {
                            $q->orWhere('address', 'like', "%{$area}%");
                        }
                        $q->orWhere('address', 'like', "%kampus%");
                        $q->orWhere('address', 'like', "%universitas%");
                        $q->orWhere('address', 'like', "%college%");
                    });
                } else {
                    // Jika belum ada location_type filter
                    $kosQuery->where(function($q) use ($allDekatkampusAreas) {
                        foreach ($allDekatkampusAreas as $area) {
                            $q->orWhere('address', 'like', "%{$area}%");
                        }
                        $q->orWhere('address', 'like', "%kampus%");
                        $q->orWhere('address', 'like', "%universitas%");
                        $q->orWhere('address', 'like', "%college%");
                    });
                }
            } else {
                // Logika pencarian biasa berdasarkan kota dan area
                foreach ($this->indonesianCities as $city => $areas) {
                    if (stripos($city, $query) !== false) {
                        $matchedLocations[] = $city;
                        $matchedLocations = array_merge($matchedLocations, $areas);
                    } else {
                        foreach ($areas as $area) {
                            if (stripos($area, $query) !== false) {
                                $matchedLocations[] = $area;
                                if (!in_array($city, $matchedLocations)) {
                                    $matchedLocations[] = $city;
                                }
                            }
                        }
                    }
                }

                if (!empty($matchedLocations)) {
                    if ($locationType) {
                        // Jika sudah ada location_type filter, gunakan AND
                        $kosQuery->where(function($q) use ($matchedLocations, $query) {
                            foreach ($matchedLocations as $location) {
                                $q->orWhere('address', 'like', "%{$location}%");
                            }
                            $q->orWhere('address', 'like', "%{$query}%");
                        });
                    } else {
                        // Jika belum ada location_type filter
                        $kosQuery->where(function($q) use ($matchedLocations, $query) {
                            foreach ($matchedLocations as $location) {
                                $q->orWhere('address', 'like', "%{$location}%");
                            }
                            $q->orWhere('address', 'like', "%{$query}%");
                        });
                    }
                } else {
                    if ($locationType) {
                        // Jika sudah ada location_type filter, gunakan AND
                        $kosQuery->where('address', 'like', "%{$query}%");
                    } else {
                        // Jika belum ada location_type filter
                        $kosQuery->where('address', 'like', "%{$query}%");
                    }
                }
            }
        }

        // Filter gender jika ada
        if ($gender) {
            $kosQuery->where('gender', $gender);
        }

        // Filter price_range jika ada
        if ($priceRange) {
            $rangeParts = explode('-', $priceRange);
            if (count($rangeParts) === 2) {
                [$min, $max] = $rangeParts;
                $kosQuery->whereBetween('price', [(int)$min, (int)$max]);
            }
        }

        $kos = $kosQuery->orderBy('created_at', 'desc')->paginate(10);

        $apartmentQuery = Apartment::query();

        if (!empty($query)) {
            $apartmentQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('address', 'like', "%{$query}%");
            });
        }

        if ($gender) {
            $apartmentQuery->where('gender', $gender);
        }

        if ($priceRange) {
            $rangeParts = explode('-', $priceRange);
            if (count($rangeParts) === 2) {
                [$min, $max] = $rangeParts;
                $apartmentQuery->whereBetween('price', [(int) $min, (int) $max]);
            }
        }

        $apartments = $apartmentQuery->orderBy('created_at', 'desc')->take(10)->get();

        return view('landing.index', [
            'kos' => $kos,
            'apartments' => $apartments,
            'searchQuery' => $displayQuery ?? $query,
            'locations' => $this->getFormattedLocations(),
            'matchedLocations' => $matchedLocations,
            'genderFilter' => $gender,
            'priceRangeFilter' => $priceRange,
            'locationTypeFilter' => $locationType,
        ]);
    }

    public function testimonials()
    {
        return view('landing.testimonials');
    }
}
