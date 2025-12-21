<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\PdfToText\Pdf;

class ResumesAnalysisServices
{
    public function extractResumeInformation(string $fileUri)
    {
        try {
            $rawtext = $this->extractTextFromPdf($fileUri);

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' =>
                            'Extract JSON with keys: summary, skills, experience, education.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $rawtext
                    ]
                ],
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0.1
            ]);

            return json_decode($response->choices[0]->message->content, true);

        } catch (\Exception $e) {
            Log::error('Resume extraction error: ' . $e->getMessage());
            return [
                'summary' => '',
                'skills' => '',
                'experience' => '',
                'education' => '',
            ];
        }
    }

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

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' =>
                            "Return ONLY JSON with: aiGeneratedScore, aiGeneratedFeedback."
                    ],
                    [
                        'role' => 'user',
                        'content' =>
                            json_encode(['job' => $jobDetails, 'resume' => $resumeData])
                    ]
                ],
                'response_format' => ['type' => 'json_object'],
            ]);

            return json_decode($response->choices[0]->message->content, true);

        } catch (\Exception $e) {
            Log::error('Resume analysis error: ' . $e->getMessage());

            return [
                'aiGeneratedScore' => 0,
                'aiGeneratedFeedback' =>
                    'An error occurred while analyzing the resume.',
            ];
        }
    }

    private function extractTextFromPdf(string $fileUri): string
    {
        if (!Storage::disk('local')->exists($fileUri)) {
            throw new \Exception("File not found at: $fileUri");
        }

        $fileContent = Storage::disk('local')->get($fileUri);

        $tempFile = tempnam(sys_get_temp_dir(), 'pdf_');
        file_put_contents($tempFile, $fileContent);

        $pdf = new Pdf();
        $pdf->setPdf($tempFile);
        $text = $pdf->text();

        unlink($tempFile);

        return $text;
    }
}
