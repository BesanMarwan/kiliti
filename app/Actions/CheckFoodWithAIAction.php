<?php

namespace App\Actions;

use App\Models\Patient;
use Illuminate\Support\Facades\Cache;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Exceptions\PrismProviderOverloadedException;
use RuntimeException;
use Throwable;

class CheckFoodWithAIAction
{
    public function execute(Patient $patient, string $foodName): array
    {
        $foodName = trim($foodName);

        if ($foodName === '') {
            throw new RuntimeException('Food name is required.');
        }

        /*
         * Cache result for 12 hours.
         */
        $cacheKey = 'food:v3:' . $patient->stage . ':' . md5(
                mb_strtolower($foodName)
            );

        return Cache::remember(
            $cacheKey,
            43200,
            function () use ($patient, $foodName) {

                /*
                 * Temporary test values.
                 *
                 * Later replace these with the patient's
                 * latest lab results.
                 */
                $k = 4.5;
                $p = 3.5;
                $na = 140;

                $prompt = <<<PROMPT
حلل الطعام التالي لمريض كلى داخل تطبيق "كليتي".

اسم الطعام:
{$foodName}

بيانات المريض:
- مرحلة مرض الكلى: {$patient->stage}
- بوتاسيوم الدم: {$k}
- فوسفور الدم: {$p}
- صوديوم الدم: {$na}

حلل الطعام على أساس 100 غرام.

أرجع JSON صالح فقط.

مهم جدًا:
- لا تستخدم Markdown.
- لا تستخدم ```json.
- لا تكتب أي نص قبل أو بعد JSON.
- يجب أن يكون الناتج JSON صالحًا يمكن لـ json_decode قراءته مباشرة.
- استخدم اللهجة الفلسطينية في reason و warning و tip.
- لا تقدم تشخيصًا طبيًا.
- لا تغير علاج المريض.
- لا تستبدل الطبيب أو أخصائي التغذية.

الشكل المطلوب:

{
    "food": "{$foodName}",
    "allowed": true,
    "status": "مسموح",
    "color": "green",
    "nutrition_per_100g": {
        "potassium_mg": 0,
        "sodium_mg": 0,
        "phosphorus_mg": 0,
        "protein_g": 0,
        "calories": 0
    },
    "daily_limit_percent": {
        "potassium": "0%",
        "sodium": "0%"
    },
    "reason": "شرح باللهجة الفلسطينية",
    "portion": "الكمية المقترحة",
    "alternatives": [
        {
            "name": "اسم البديل",
            "potassium_mg": 0,
            "sodium_mg": 0,
            "why_better": "لماذا البديل أفضل"
        }
    ],
    "warning": "تحذير باللهجة الفلسطينية",
    "tip": "نصيحة باللهجة الفلسطينية"
}

قواعد القيم:

- allowed يجب أن تكون true أو false فقط.
- status يجب أن تكون واحدة من:
  - مسموح
  - ممنوع
  - باعتدال
- color يجب أن تكون واحدة من:
  - green
  - yellow
  - red
- جميع القيم الغذائية يجب أن تكون أرقامًا.
- potassium_mg و sodium_mg و phosphorus_mg بوحدة mg لكل 100g.
- protein_g بوحدة gram لكل 100g.
- calories بوحدة kcal لكل 100g.
- daily_limit_percent يجب أن تكون strings مثل "12%".
- alternatives يجب أن تكون Array.
- كل alternative يجب أن يحتوي:
  - name
  - potassium_mg
  - sodium_mg
  - why_better
- إذا لم يوجد بديل مناسب، أرجع alternatives كـ [].
PROMPT;

                $prism = app(Prism::class);

                /*
                 * Retry Gemini when the provider is temporarily overloaded.
                 *
                 * 3 attempts:
                 * Attempt 1
                 * wait 2 seconds
                 * Attempt 2
                 * wait 2 seconds
                 * Attempt 3
                 */
                try {
                    $response = retry(
                        3,
                        function () use ($prism, $prompt) {
                            return $prism->text()
                                ->using(
                                    Provider::Gemini,
                                    'gemini-3.8-flash'
                                )
                                ->withSystemPrompt(
                                    'أنت مساعد غذائي متخصص في مساعدة مرضى الكلى داخل تطبيق كليتي. ' .
                                    'أجب فقط حسب المطلوب في الـ prompt. ' .
                                    'أرجع JSON صالح فقط بدون Markdown أو ``` أو أي نص إضافي. ' .
                                    'لا تقدم تشخيصًا طبيًا ولا تغير علاج المريض ولا تستبدل الطبيب أو أخصائي التغذية.'
                                )
                                ->withPrompt($prompt)
                                ->asText();
                        },
                        2000,
                        function (Throwable $exception) {
                            return $exception instanceof PrismProviderOverloadedException;
                        }
                    );
                } catch (PrismProviderOverloadedException $exception) {
                    throw new RuntimeException(
                        'خدمة تحليل الطعام مشغولة حاليًا. حاول مرة أخرى بعد قليل.',
                        0,
                        $exception
                    );
                } catch (Throwable $exception) {
                    report($exception);

                    throw new RuntimeException(
                        'Gemini Error: ' . $exception->getMessage(),
                        0,
                        $exception
                    );
//                    throw new RuntimeException(
//                        'حدث خطأ أثناء تحليل الطعام. حاول مرة أخرى.',
//                        0,
//                        $exception
//                    );
                }

                /*
                 * Get Gemini response text.
                 */
                $text = trim($response->text);

                /*
                 * Remove accidental Markdown fences.
                 */
                $text = preg_replace(
                    '/^```json\s*/i',
                    '',
                    $text
                );

                $text = preg_replace(
                    '/^```\s*/',
                    '',
                    $text
                );

                $text = preg_replace(
                    '/\s*```$/',
                    '',
                    $text
                );

                $text = trim($text);

                /*
                 * Decode JSON.
                 */
                $data = json_decode($text, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new RuntimeException(
                        'Gemini returned invalid JSON: ' .
                        json_last_error_msg()
                    );
                }

                if (!is_array($data)) {
                    throw new RuntimeException(
                        'Gemini returned an invalid response format.'
                    );
                }

                /*
                 * Validate required fields.
                 */
                $requiredFields = [
                    'food',
                    'allowed',
                    'status',
                    'color',
                    'nutrition_per_100g',
                    'daily_limit_percent',
                    'reason',
                    'portion',
                    'alternatives',
                    'warning',
                    'tip',
                ];

                foreach ($requiredFields as $field) {
                    if (!array_key_exists($field, $data)) {
                        throw new RuntimeException(
                            "Gemini response is missing required field: {$field}"
                        );
                    }
                }

                /*
                 * Validate allowed.
                 */
                if (!is_bool($data['allowed'])) {
                    throw new RuntimeException(
                        'Gemini response field "allowed" must be boolean.'
                    );
                }

                /*
                 * Validate status.
                 */
                $allowedStatuses = [
                    'مسموح',
                    'ممنوع',
                    'باعتدال',
                ];

                if (!in_array($data['status'], $allowedStatuses, true)) {
                    throw new RuntimeException(
                        'Gemini response field "status" contains an invalid value.'
                    );
                }

                /*
                 * Validate color.
                 */
                $allowedColors = [
                    'green',
                    'yellow',
                    'red',
                ];

                if (!in_array($data['color'], $allowedColors, true)) {
                    throw new RuntimeException(
                        'Gemini response field "color" contains an invalid value.'
                    );
                }

                /*
                 * Validate nutrition.
                 */
                if (!is_array($data['nutrition_per_100g'])) {
                    throw new RuntimeException(
                        'Gemini response field "nutrition_per_100g" must be an object.'
                    );
                }

                $nutritionFields = [
                    'potassium_mg',
                    'sodium_mg',
                    'phosphorus_mg',
                    'protein_g',
                    'calories',
                ];

                foreach ($nutritionFields as $field) {
                    if (
                        !array_key_exists(
                            $field,
                            $data['nutrition_per_100g']
                        )
                        ||
                        !is_numeric(
                            $data['nutrition_per_100g'][$field]
                        )
                    ) {
                        throw new RuntimeException(
                            "Invalid nutrition field: {$field}"
                        );
                    }
                }

                /*
                 * Validate daily limits.
                 */
                if (!is_array($data['daily_limit_percent'])) {
                    throw new RuntimeException(
                        'Gemini response field "daily_limit_percent" must be an object.'
                    );
                }

                /*
                 * Validate alternatives.
                 */
                if (!is_array($data['alternatives'])) {
                    throw new RuntimeException(
                        'Gemini response field "alternatives" must be an array.'
                    );
                }

                foreach ($data['alternatives'] as $index => $alternative) {

                    if (!is_array($alternative)) {
                        throw new RuntimeException(
                            "Alternative {$index} must be an object."
                        );
                    }

                    $alternativeFields = [
                        'name',
                        'potassium_mg',
                        'sodium_mg',
                        'why_better',
                    ];

                    foreach ($alternativeFields as $field) {
                        if (!array_key_exists($field, $alternative)) {
                            throw new RuntimeException(
                                "Alternative {$index} is missing field: {$field}"
                            );
                        }
                    }

                    if (!is_numeric($alternative['potassium_mg'])) {
                        throw new RuntimeException(
                            "Alternative {$index} potassium_mg must be numeric."
                        );
                    }

                    if (!is_numeric($alternative['sodium_mg'])) {
                        throw new RuntimeException(
                            "Alternative {$index} sodium_mg must be numeric."
                        );
                    }
                }

                /*
                 * Add image URL to the main food.
                 *
                 * This points to Laravel's FoodImageController.
                 * The Pollinations API key is never exposed to Flutter.
                 */
                $data['image_url'] = $this->getFoodImage(
                    $data['food']
                );

                /*
                 * Add image URL to every alternative.
                 */
                foreach ($data['alternatives'] as &$alternative) {

                    if (!empty($alternative['name'])) {
                        $alternative['image_url'] =
                            $this->getFoodImage(
                                $alternative['name']
                            );
                    }
                }

                unset($alternative);

                return $data;
            }
        );
    }

    /**
     * Return the Laravel proxy URL for the food image.
     *
     * Flutter calls this URL.
     * Laravel then calls Pollinations using the secret API key.
     */
    private function getFoodImage(string $foodName): string
    {
        return route('user.food-image', [
            'food' => $foodName,
        ]);
    }
}
