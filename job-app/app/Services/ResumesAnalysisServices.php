<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Spatie\PdfToText\Pdf;

class ResumesAnalysisServices
{
    /**
     * Extract resume structured data from PDF using DeepSeek
     */
    public function extractResumeInformation(string $fileUri): array
    {
        try {
            // 1️⃣ PDF → Text
            $rawText = $this->extractTextFromPdf($fileUri);

            // 2️⃣ Call DeepSeek
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.deepseek.key'),
                'Content-Type'  => 'application/json',
            ])->post(config('services.deepseek.url'), [
                'model' => 'deepseek-chat',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' =>
                            'Extract resume info and return ONLY valid JSON with keys:
                             summary, skills, experience, education.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $rawText
                    ]
                ],
                'temperature' => 0.1
            ]);

            if (!$response->successful()) {
                throw new \Exception($response->body());
            }

            return json_decode(
                $response->json('choices.0.message.content'),
                true
            );

        } catch (\Throwable $e) {
            Log::error('Resume extraction error: ' . $e->getMessage());

            // AI اختياري → ميفشلش الـ apply
            return [
                'summary' => '',
                'skills' => '',
                'experience' => '',
                'education' => '',
            ];
        }
    }

    /**
     * Analyze resume vs job vacancy using DeepSeek
     */
    public function analyzeResume($job_vacancy, $resumeData): array
    {
        try {
            $jobDetails = [
                'title' => $job_vacancy->utils,
                'description' => $job_vacancy->description,
                'location' => $job_vacancy->location,
                'type' => $job_vacancy->type,
                'salary' => $job_vacancy->salary,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.deepseek.key'),
                'Content-Type'  => 'application/json',
            ])->post(config('services.deepseek.url'), [
                'model' => 'deepseek-chat',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' =>
                            'Return ONLY valid JSON with:
                             aiGeneratedScore (0-100),
                             aiGeneratedFeedback (string).'
                    ],
                    [
                        'role' => 'user',
                        'content' => json_encode([
                            'job' => $jobDetails,
                            'resume' => $resumeData
                        ])
                    ]
                ],
            ]);

            if (!$response->successful()) {
                throw new \Exception($response->body());
            }

            return json_decode(
                $response->json('choices.0.message.content'),
                true
            );

        } catch (\Throwable $e) {
            Log::error('Resume analysis error: ' . $e->getMessage());

            return [
                'aiGeneratedScore' => 0,
                'aiGeneratedFeedback' =>
                'AI service unavailable. Please try later.',
            ];
        }
    }

    /**
     * Extract raw text from PDF
     */
    private function extractTextFromPdf(string $fileUri): string
    {
        if (!Storage::disk('cloud')->exists($fileUri)) {
            throw new \Exception("File not found at: $fileUri");
        }

        $fileContent = Storage::disk('cloud')->get($fileUri);

        $tempFile = tempnam(sys_get_temp_dir(), 'pdf_');
        file_put_contents($tempFile, $fileContent);

        $text = Pdf::getText($tempFile);

        unlink($tempFile);

        return $text;
    }
}
