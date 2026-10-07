<?php

use App\Models\Symptom;
use App\Models\SymptomTip;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tips = [
            'dizziness' => [
                [
                    'title' =>['ar'=>'نصيحة','en'=>'Advice'],
                    'content' =>['ar'=> 'اجلس أو استلقِ في مكان آمن وتجنب الوقوف المفاجئ. إذا كانت الدوخة شديدة أو مستمرة، تواصل مع طبيبك.',
                                 'en'=>'Sit or lie down in a safe place and avoid standing suddenly. If the dizziness is severe or persistent, contact your doctor.']
                ],
            ],

            'severe fatigue' => [
                [
                    'title' =>['ar'=>'نصيحة','en'=>'Advice'],
                    'content' =>['ar'=> 'خذ قسطًا من الراحة وراقب حالتك. إذا كان التعب شديدًا أو غير معتاد أو يزداد سوءًا، تواصل مع طبيبك.',
                        'en'=>'Rest and monitor your condition. If the fatigue is severe, unusual, or getting worse, contact your doctor.']
                ],
            ],

            'nausea' => [

                [
                    'title' =>['ar'=>'نصيحة','en'=>'Advice'],
                    'content' =>['ar'=> 'حاول الراحة وتناول الطعام حسب الخطة الغذائية الموصى بها لك. إذا استمر الغثيان أو ازداد، تواصل مع طبيبك.',
                        'en'=>'Rest and follow your recommended dietary plan. If nausea persists or worsens, contact your doctor.']
                ],
            ],

            'pain' => [
                [
                    'title' =>['ar'=>'نصيحة','en'=>'Advice'],
                    'content' =>['ar'=> 'راقب شدة الألم ومكانه. إذا كان الألم شديدًا أو مفاجئًا أو مستمرًا، تواصل مع طبيبك.',
                        'en'=>'Monitor the severity and location of the pain. If the pain is severe, sudden, or persistent, contact your doctor.']
                ],
            ],

            'headache' => [
                [
                    'title' =>['ar'=>'نصيحة','en'=>'Advice'],
                    'content' =>['ar'=> 'خذ قسطًا من الراحة وراقب الأعراض. إذا كان الصداع شديدًا أو متكررًا أو مصحوبًا بأعراض أخرى، تواصل مع طبيبك.',
                        'en'=>'Rest and monitor your symptoms. If the headache is severe, recurrent, or accompanied by other symptoms, contact your doctor.']
                ],
            ],

            'muscle cramps' => [
                [
                    'title' =>['ar'=>'نصيحة','en'=>'Advice'],
                    'content' =>['ar'=> 'سجل حدوث التشنجات وشدتها، خاصة أثناء أو بعد جلسة الغسيل. إذا كانت شديدة أو متكررة، أخبر طبيبك.',
                        'en'=>'Record when the cramps occur and how severe they are, especially during or after dialysis. If they are severe or recurrent, inform your doctor.']
                ],

            ],

            'shortness of breath' => [

                [
                    'title' =>['ar'=>'تنبيه','en'=>'Warning'],
                    'content' =>['ar'=> 'ضيق التنفس قد يحتاج إلى تقييم طبي. إذا كان شديدًا أو مفاجئًا، اطلب المساعدة الطبية فورًا.',
                        'en'=>'Shortness of breath may require medical evaluation. If it is severe or sudden, seek medical help immediately.']
                ],
            ],
        ];

        foreach ($tips as $symptomName => $translations) {

            $symptom = Symptom::where('name->en', $symptomName)->first();

            if (!$symptom) {
                continue;
            }

            foreach ($translations as $index => $tip) {
                SymptomTip::updateOrCreate(
                    [
                        'symptom_id' => $symptom->id,
                        'title' => $tip['title'],
                    ],
                    [
                        'content' => $tip['content'],
                        'status' => 'enabled',
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symptom_tip', function (Blueprint $table) {
            //
        });
    }
};
