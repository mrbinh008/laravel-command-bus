<?php

namespace App\services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AudioService
{
    /**
     * Handle convert audio to text using whisper AI
     *
     * @throws ConnectionException
     */
    public function handle(mixed $file): mixed
    {
        $fileName = $file->getClientOriginalName();
        $fileContent = file_get_contents($file);
        Storage::disk('public')->put('audios/' . $fileName, $fileContent);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.huggingface.key'),
        ])->attach('inputs', $fileContent, $fileName)->post(config('services.huggingface.url'));

        return $response->json();
    }
}
