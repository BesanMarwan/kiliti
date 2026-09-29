<?php

use App\Jobs\GenerateMedicationLogsJob;
use App\Jobs\ProcessMissedMedicationLogsJob;
use App\Jobs\SendMedicationReminderJob;
use App\Services\MedicationAlertService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(SendMedicationReminderJob::class)->everyMinute();
Schedule::call(function () {app(MedicationAlertService::class)->checkUpcoming();})->everyMinute();


Schedule::job(new GenerateMedicationLogsJob())->hourly();
Schedule::job(new ProcessMissedMedicationLogsJob())->everyMinute();
