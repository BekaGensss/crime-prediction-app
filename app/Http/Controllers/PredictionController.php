<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\File;

class PredictionController extends Controller
{
    public function showForm()
    {
        $locations = $this->getLocations();
        return view('prediction', compact('locations'));
    }

    public function predict(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'model' => 'required|string'
        ]);
        
        $client = new Client();
        $api_url = 'http://127.0.0.1:5000/predict';

        try {
            $response = $client->post($api_url, [
                'json' => [
                    'lokasi' => $request->input('location'),
                    'model' => $request->input('model')
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            if (isset($data['error'])) {
                return response()->json(['error' => $data['error']], 400);
            }
            return response()->json(['prediction' => $data['prediksi']]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response) {
                $data = json_decode($response->getBody(), true);
                if (isset($data['error'])) {
                    return response()->json(['error' => $data['error']], $response->getStatusCode());
                }
            }
            return response()->json(['error' => 'Gagal terhubung ke server prediksi. Pastikan server Python sedang berjalan.'], 500);
        }
    }

    private function getCrimeData()
    {
        $csvPath = base_path('python_scripts/crime_data.csv');
        if (!File::exists($csvPath)) {
            return false;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file);
        
        $cleanedHeader = array_map(function($h) {
            return trim(str_replace(['(%)', ' '], ['', '_'], $h));
        }, $header);

        $data = [];
        while (($row = fgetcsv($file)) !== FALSE) {
            if (count($row) === count($cleanedHeader)) {
                $data[] = array_combine($cleanedHeader, $row);
            }
        }
        fclose($file);

        return array_filter($data, function($item) {
            return strtolower($item['Kepolisian_Daerah']) != 'indonesia';
        });
    }

    private function getLocations()
    {
        return [
            'ACEH', 'SUMATERA UTARA', 'SUMATERA BARAT', 'RIAU', 'JAMBI', 'SUMATERA SELATAN',
            'BENGKULU', 'LAMPUNG', 'KEP. BANGKA BELITUNG', 'KEP. RIAU', 'METRO JAYA',
            'JAWA BARAT', 'JAWA TENGAH', 'DI YOGYAKARTA', 'JAWA TIMUR', 'BANTEN', 'BALI',
            'NUSA TENGGARA BARAT', 'NUSA TENGGARA TIMUR', 'KALIMANTAN BARAT', 'KALIMANTAN TENGAH',
            'KALIMANTAN SELATAN', 'KALIMANTAN TIMUR', 'KALIMANTAN UTARA', 'SULAWESI UTARA',
            'SULAWESI TENGAH', 'SULAWESI SELATAN', 'SULAWESI TENGGARA', 'GORONTALO',
            'SULAWESI BARAT', 'MALUKU', 'MALUKU UTARA', 'PAPUA BARAT', 'PAPUA'
        ];
    }
    
    private function calculateRiskLevels($dataTotal)
    {
        if (count($dataTotal) < 3) {
            return array_fill(0, count($dataTotal), 'Low');
        }
        
        $dataTotal = array_map('intval', $dataTotal);
        sort($dataTotal);
        $min = $dataTotal[0];
        $max = end($dataTotal);
        
        $q33 = $min + ($max - $min) / 3;
        $q66 = $min + 2 * ($max - $min) / 3;
        
        $riskLevels = [];
        foreach ($dataTotal as $value) {
            if ($value <= $q33) $riskLevels[] = 'Low';
            elseif ($value <= $q66) $riskLevels[] = 'Medium';
            else $riskLevels[] = 'High';
        }
        return $riskLevels;
    }

    public function showStatistics(Request $request)
    {
        $data = $this->getCrimeData();
        if ($data === false) {
            return view('statistics')->withErrors('File data tidak ditemukan.');
        }
        
        $locations = array_column($data, 'Kepolisian_Daerah');
        
        $filterYear = $request->get('tahun', 'all');
        $filterRisk = $request->get('resiko', 'all');
        $compare1 = $request->get('banding1', 'all');
        $compare2 = $request->get('banding2', 'all');

        $labels = [];
        $chartData = [];
        $comparisonData = [];

        // Logika untuk Mode Perbandingan
        if ($compare1 !== 'all' && $compare2 !== 'all') {
            $labels = [$compare1, $compare2];
            
            $loc1Data = collect($data)->firstWhere('Kepolisian_Daerah', $compare1);
            $loc2Data = collect($data)->firstWhere('Kepolisian_Daerah', $compare2);
            
            if ($loc1Data && $loc2Data) {
                $comparisonData = [
                    [
                        'location' => $loc1Data['Kepolisian_Daerah'],
                        '2021' => (int) $loc1Data['Jumlah_Tindak_Pidana_2021'],
                        '2022' => (int) $loc1Data['Jumlah_Tindak_Pidana_2022']
                    ],
                    [
                        'location' => $loc2Data['Kepolisian_Daerah'],
                        '2021' => (int) $loc2Data['Jumlah_Tindak_Pidana_2021'],
                        '2022' => (int) $loc2Data['Jumlah_Tindak_Pidana_2022']
                    ]
                ];
            } else {
                return view('statistics')->with('error', 'Salah satu lokasi tidak ditemukan.');
            }

        } else {
            // Logika untuk Mode Filter
            $dataTotal = array_map(function($row) {
                return (int)$row['Jumlah_Tindak_Pidana_2021'] + (int)$row['Jumlah_Tindak_Pidana_2022'];
            }, $data);
            
            $riskLevels = $this->calculateRiskLevels($dataTotal);
            
            $filteredData = [];
            foreach ($data as $index => $row) {
                if ($filterRisk === 'all' || $riskLevels[$index] === $filterRisk) {
                    $filteredData[] = $row;
                }
            }

            foreach ($filteredData as $row) {
                $labels[] = $row['Kepolisian_Daerah'];
                $chartData[] = [
                    'location' => $row['Kepolisian_Daerah'],
                    '2021' => (int) $row['Jumlah_Tindak_Pidana_2021'],
                    '2022' => (int) $row['Jumlah_Tindak_Pidana_2022']
                ];
            }
        }
        
        return view('statistics', compact('labels', 'chartData', 'comparisonData', 'locations', 'filterYear', 'filterRisk', 'compare1', 'compare2'));
    }

    public function showLocationDetail(Request $request, $lokasi)
    {
        $data = $this->getCrimeData();
        if ($data === false) {
            return redirect()->route('statistics')->withErrors('File data tidak ditemukan.');
        }

        $locationData = collect($data)->firstWhere('Kepolisian_Daerah', $lokasi);
        
        if (!$locationData) {
            return redirect()->route('statistics')->withErrors('Lokasi tidak ditemukan.');
        }
        
        $data2021 = array_column($data, 'Jumlah_Tindak_Pidana_2021');
        $data2022 = array_column($data, 'Jumlah_Tindak_Pidana_2022');
        $avg2021 = count($data2021) > 0 ? array_sum($data2021) / count($data2021) : 0;
        $avg2022 = count($data2022) > 0 ? array_sum($data2022) / count($data2022) : 0;

        $totalSolved2021 = (float)$locationData['Penyelesaian_tindak_pidana_2021'];
        $totalSolved2022 = (float)$locationData['Penyelesaian_tindak_pidana_2022'];

        return view('location-detail', compact('lokasi', 'locationData', 'avg2021', 'avg2022', 'totalSolved2021', 'totalSolved2022'));
    }

    public function showAbout()
    {
        return view('about');
    }

    public function showContact()
    {
        return view('contact');
    }
    
    public function showForecastForm()
    {
        $locations = $this->getLocations();
        return view('forecast', compact('locations'));
    }
    
    public function forecast(Request $request)
    {
        $client = new Client();
        $api_url = 'http://127.0.0.1:5000/forecast';

        try {
            $response = $client->post($api_url, [
                'json' => [
                    'lokasi' => $request->input('location'),
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            if (isset($data['error'])) {
                return redirect()->back()->with('error', $data['error']);
            }
            return redirect()->back()->with('forecastData', $data);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response) {
                $data = json_decode($response->getBody(), true);
                if (isset($data['error'])) {
                    return redirect()->back()->with('error', $data['error']);
                }
            }
            return redirect()->back()->with('error', 'Gagal terhubung ke server peramalan. Pastikan server Python sedang berjalan.');
        }
    }

    public function showModelComparison()
    {
        $client = new Client();
        $api_url = 'http://127.0.0.1:5000/compare-models';

        try {
            $response = $client->get($api_url);
            $data = json_decode($response->getBody(), true);
            
            return view('compare-models', ['comparisonData' => $data]);
        } catch (RequestException $e) {
            return view('compare-models')->with('error', 'Gagal memuat data perbandingan model. Pastikan server Python sedang berjalan.');
        }
    }
}