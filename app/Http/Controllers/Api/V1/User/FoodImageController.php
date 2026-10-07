<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FoodImageController extends Controller
{
    public function __invoke(Request $request)
    {
        // Laravel decodes the query parameter automatically.
        $foodName = trim((string) $request->query('food', ''));

        if ($foodName === '') {
            return response()->json([
                'message' => 'Food name is required.',
            ], 422);
        }

        $apiKey = config('services.pollinations.api_key');

        if (empty($apiKey)) {
            return response()->json(['message' => 'Pollinations API key is not configured.'], 500);
        }



        $response = Http::get('https://api.mymemory.translated.net/get', [
            'q' => $foodName,
            'langpair' => 'ar|en',
        ]);

         $foodNameEn = $response->json('responseData.translatedText');

        // IMPORTANT:
        // Do NOT urlencode() here.
        // rawurlencode() will be applied only once to the complete prompt.
        $prompt =
            "realistic food photography of {$foodNameEn}, " .
            "served on a white plate, clean white background, " .
            "high quality, natural food, professional food photography, " .
            "no text, no labels";

        // Encode the prompt exactly once because it is part of the URL path.
        $encodedPrompt = rawurlencode($prompt);

        $url = 'https://gen.pollinations.ai/image/' . $encodedPrompt;

        try {
            $response = Http::withToken($apiKey)
                ->connectTimeout(5)
                ->timeout(20)
                ->get($url, [
                    'model' => 'flux',
                    'width' => 400,
                    'height' => 400,
                ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to generate food image.',
            ], 504);
        }

        if (!$response->successful()) {
            report(new \RuntimeException(
                'Pollinations image generation failed: ' .
                $response->status() .
                ' - ' .
                $response->body()
            ));

            return response()->json([
                'message' => 'Unable to generate food image.',
            ], 502);
        }

        return response($response->body(), 200)
            ->header(
                'Content-Type',
                $response->header('Content-Type', 'image/jpeg')
            )
            ->header(
                'Cache-Control',
                'public, max-age=86400'
            );
    }
}
