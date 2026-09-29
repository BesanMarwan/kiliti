<?php

namespace Database\Seeders;

use App\Models\GeneralData;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Medication;
use App\Models\PatientMedication;
use Illuminate\Database\Seeder;

class PatientMedicationSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $medications = Medication::all();
        $route      = GeneralData::where('uuid','routes')->first();
        $general_route      = GeneralData::where('parent_id',$route->id)->first();

        if ($patients->isEmpty()) {
            $this->command->warn('No patients found.');
            return;
        }

        if ($doctors->isEmpty()) {
            $this->command->warn('No doctors found.');
            return;
        }

        if ($medications->isEmpty()) {
            $this->command->warn('No medications found.');
            return;
        }

        foreach ($patients as $patient) {

            $selectedMedications = $medications->random(
                min(3, $medications->count())
            );

            foreach ($selectedMedications as $medication) {

                $doctor = $doctors->random();

                PatientMedication::updateOrCreate(
                    [
                        'patient_id' => $patient->id,
                        'medication_id' => $medication->id,
                    ],
                    [
                        'doctor_id' => $doctor->id,

                        'dosage' => '800 mg',

                        'frequency' => rand(1,3),

                        'route' => $general_route->id,

                        'start_date' => now()->toDateString(),

                        'end_date' => now()
                            ->addMonths(3)
                            ->toDateString(),

                        'reminder_times' => [
                            '08:00',
                            '14:00',
                            '20:00',
                        ],

                        'reminder_enabled' => true,
                    ]
                );
            }
        }

        $this->command->info(
            'Patient medications seeded successfully.'
        );
    }
}
