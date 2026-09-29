<?php

return array (
  'titles' =>
  array (
    'AccountActivated' => 'Activate account',
    'sms_message' => 'SMS Message',
      'FluidLimitApproaching' => 'Fluid Intake Alert',
      'FluidLimitWarning' => 'Fluid Intake Warning',
      'FluidLimitExceeded' => 'Fluid Limit Exceeded',

      'MedicationDoseUpcoming' => 'Medication Reminder',
      'MedicationDoseDue' => 'Medication Due',
      'MedicationDoseMissed' => 'Medication Alert',

  ),
  'messages' =>
  array (
    'AccountActivated' => 'Account activated',
    'sms_message' => ':message',
    'FluidLimitApproaching' => 'You have consumed :percentage% of your daily fluid limit (:consumed ml of :limit ml).',
    'FluidLimitWarning' => 'You are very close to exceeding your daily fluid limit. You have consumed :percentage% (:consumed ml of :limit ml).',
    'FluidLimitExceeded' => 'Your daily fluid limit has been exceeded. You consumed :consumed ml out of :limit ml.',
      'MedicationDoseUpcoming' => 'Your :medication (:dosage) dose is coming up at :scheduled_at.',
      'MedicationDoseDue' => 'It is now time to take your :medication (:dosage) dose.',
      'MedicationDoseMissed' => 'The :medication (:dosage) dose scheduled at :scheduled_at has not been recorded.',
  ),
);
