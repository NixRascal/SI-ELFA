<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    /**
     * Analyze survey results using Gemini AI
     */
    public function analyzeSurveyResults($kuesioner, $analisis, $totalResponden)
    {
        try {
            // Prepare data summary for AI
            $summary = $this->prepareSummary($kuesioner, $analisis, $totalResponden);
            
            // Create prompt for Gemini
            $prompt = $this->createAnalysisPrompt($summary);
            
            Log::info('Calling Gemini API...', [
                'url' => $this->baseUrl,
                'has_api_key' => !empty($this->apiKey),
                'prompt_length' => strlen($prompt)
            ]);
            
            // Retry with exponential backoff
            $maxRetries = 3;
            $baseDelay = 2; // seconds
            
            for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                Log::info("Gemini API attempt {$attempt}/{$maxRetries}");
                
                // Call Gemini API
                $response = Http::timeout(60)
                    ->post("{$this->baseUrl}/v1/models/gemini-2.5-flash:generateContent?key={$this->apiKey}", [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'topK' => 40,
                            'topP' => 0.95,
                            'maxOutputTokens' => 8192,
                        ]
                    ]);

                $statusCode = $response->status();
                
                Log::info('Gemini API response received', [
                    'attempt' => $attempt,
                    'status' => $statusCode,
                    'successful' => $response->successful()
                ]);

                // Success
                if ($response->successful()) {
                    $result = $response->json();
                    
                    Log::info('Gemini API response structure', [
                        'has_candidates' => isset($result['candidates'])
                    ]);
                    
                    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                        return [
                            'success' => true,
                            'analysis' => $result['candidates'][0]['content']['parts'][0]['text']
                        ];
                    } else {
                        Log::error('Invalid response structure from Gemini API', ['result' => $result]);
                    }
                }
                
                // Rate limit - retry with exponential backoff
                if ($statusCode === 429) {
                    if ($attempt < $maxRetries) {
                        $waitTime = $baseDelay * pow(2, $attempt - 1); // 2s, 4s, 8s
                        Log::warning("Rate limit hit. Waiting {$waitTime} seconds before retry...");
                        sleep($waitTime);
                        continue;
                    } else {
                        Log::error('Rate limit exceeded after all retries', [
                            'attempts' => $maxRetries,
                            'response' => $response->body()
                        ]);
                        
                        return [
                            'success' => false,
                            'error' => 'Terlalu banyak permintaan. Mohon tunggu 1-2 menit lalu coba lagi.'
                        ];
                    }
                }
                
                // Other errors
                Log::error("Gemini API request failed on attempt {$attempt}", [
                    'status' => $statusCode,
                    'body' => $response->body()
                ]);
                
                // Retry for server errors (5xx)
                if ($statusCode >= 500 && $attempt < $maxRetries) {
                    $waitTime = $baseDelay * $attempt;
                    Log::warning("Server error. Waiting {$waitTime} seconds before retry...");
                    sleep($waitTime);
                    continue;
                }
                
                // Don't retry for client errors (4xx except 429)
                if ($statusCode >= 400 && $statusCode < 500 && $statusCode !== 429) {
                    break;
                }
            }

            return [
                'success' => false,
                'error' => 'Gagal mendapatkan respons dari AI. Status: ' . $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return [
                'success' => false,
                'error' => 'Terjadi kesalahan saat menghubungi AI: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Prepare summary data for AI analysis
     */
    protected function prepareSummary($kuesioner, $analisis, $totalResponden)
    {
        $summary = [
            'judul' => $kuesioner->judul,
            'deskripsi' => $kuesioner->deskripsi,
            'target' => $kuesioner->target_responden,
            'total_responden' => $totalResponden,
            'total_pertanyaan' => $kuesioner->pertanyaan->count(),
            'pertanyaan' => []
        ];

        foreach ($analisis as $index => $item) {
            $pertanyaan = $item['pertanyaan'];
            $data = [
                'nomor' => $index + 1,
                'teks' => $pertanyaan->teks_pertanyaan,
                'jenis' => $pertanyaan->jenis_pertanyaan,
                'kategori' => $pertanyaan->kategori,
                'total_jawaban' => $item['total_jawaban']
            ];

            if ($pertanyaan->jenis_pertanyaan === 'likert') {
                $data['rata_rata'] = $item['rata_rata'];
                $data['distribusi'] = $item['distribusi']->toArray();
            } elseif ($pertanyaan->jenis_pertanyaan === 'pilihan_ganda') {
                $data['distribusi'] = $item['distribusi']->toArray();
            } elseif ($pertanyaan->jenis_pertanyaan === 'isian') {
                // Only include sample of text answers to avoid token limit
                $data['sample_jawaban'] = $item['jawaban_text']->take(10)->toArray();
                $data['total_jawaban_text'] = $item['jawaban_text']->count();
            }

            $summary['pertanyaan'][] = $data;
        }

        return $summary;
    }

    /**
     * Create analysis prompt for Gemini
     */
    protected function createAnalysisPrompt($summary)
    {
        $pertanyaanText = '';
        foreach ($summary['pertanyaan'] as $p) {
            $pertanyaanText .= "\n\nPertanyaan {$p['nomor']}: {$p['teks']}\n";
            $pertanyaanText .= "Jenis: {$p['jenis']}\n";
            
            if (isset($p['rata_rata'])) {
                $pertanyaanText .= "Rata-rata skor: {$p['rata_rata']}/5.0\n";
                $pertanyaanText .= "Distribusi:\n";
                foreach ($p['distribusi'] as $nilai => $data) {
                    $pertanyaanText .= "  Skala {$nilai}: {$data['count']} responden ({$data['percentage']}%)\n";
                }
            } elseif (isset($p['distribusi']) && $p['jenis'] === 'pilihan_ganda') {
                $pertanyaanText .= "Distribusi jawaban:\n";
                foreach ($p['distribusi'] as $opsi => $data) {
                    $pertanyaanText .= "  {$opsi}: {$data['count']} responden ({$data['percentage']}%)\n";
                }
            } elseif (isset($p['sample_jawaban'])) {
                $pertanyaanText .= "Sample jawaban (dari {$p['total_jawaban_text']} total):\n";
                foreach ($p['sample_jawaban'] as $idx => $jawaban) {
                    $pertanyaanText .= "  " . ($idx + 1) . ". {$jawaban}\n";
                }
            }
        }

        return "Saya adalah seorang analis data survei di institusi pendidikan. Berikut adalah hasil survei yang perlu dianalisis, langsung berikan laporan analisisnya:

INFORMASI SURVEI:
- Judul: {$summary['judul']}
- Deskripsi: {$summary['deskripsi']}
- Target Responden: {$summary['target']}
- Total Responden: {$summary['total_responden']} orang
- Total Pertanyaan: {$summary['total_pertanyaan']}

HASIL SURVEI:
{$pertanyaanText}

Berdasarkan data di atas, berikan analisis komprehensif dalam bahasa Indonesia yang mencakup:

1. **Ringkasan Utama**: Insight utama dari hasil survei secara keseluruhan
2. **Temuan Positif**: Aspek-aspek yang mendapat penilaian baik dan perlu dipertahankan
3. **Area Perbaikan**: Aspek-aspek yang perlu ditingkatkan berdasarkan data
4. **Tren dan Pola**: Pola atau tren menarik yang terlihat dari data
5. **Rekomendasi**: Saran konkret untuk perbaikan berdasarkan hasil survei

Format analisis dengan markdown yang rapi dengan heading, bullet points, dan penekanan teks yang sesuai.";
    }

    /**
     * Generate quick insights for a single question
     */
    public function generateQuestionInsight($pertanyaan, $data)
    {
        try {
            $prompt = $this->createQuestionPrompt($pertanyaan, $data);
            
            $response = Http::timeout(20)
                ->post("{$this->baseUrl}/models/gemini-1.5-flash:generateContent?key={$this->apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.5,
                        'maxOutputTokens' => 500,
                    ]
                ]);

            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    return $result['candidates'][0]['content']['parts'][0]['text'];
                }
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Gemini Question Insight Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create prompt for single question insight
     */
    protected function createQuestionPrompt($pertanyaan, $data)
    {
        $dataText = '';
        
        if ($pertanyaan->jenis_pertanyaan === 'likert' && isset($data['rata_rata'])) {
            $dataText = "Rata-rata: {$data['rata_rata']}/5.0";
        } elseif (isset($data['distribusi'])) {
            $dataText = "Distribusi jawaban: " . json_encode($data['distribusi']);
        }

        return "Berikan insight singkat (maksimal 2-3 kalimat) dalam bahasa Indonesia untuk pertanyaan survei berikut:

Pertanyaan: {$pertanyaan->teks_pertanyaan}
Jenis: {$pertanyaan->jenis_pertanyaan}
Data: {$dataText}

Fokus pada interpretasi data dan apa artinya bagi institusi.";
    }
}
