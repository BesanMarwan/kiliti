<?php

return array (
  'titles' =>
  array (
    'AccountActivated' => 'تفعيل الحساب',
    'sms_message' => 'رسالة SMS',
      'FluidLimitApproaching' => 'تنبيه السوائل',
      'FluidLimitWarning' => 'تنبيه السوائل',
      'FluidLimitExceeded' => 'تجاوز حد السوائل',
      'MedicationDoseUpcoming' => 'تذكير بالدواء',
      'MedicationDoseDue' => 'موعد الدواء',
      'MedicationDoseMissed' => 'تنبيه الدواء',
  ),
  'messages' =>
  array (
    'AccountActivated' => 'تم تفعيل حسابك بنجاح',
    'sms_message' => ':message',
      'FluidLimitApproaching' => 'استهلكت :percentage% من الحد اليومي للسوائل (:consumed مل من :limit مل).',

      'FluidLimitWarning' => 'أنت قريب جدًا من تجاوز الحد اليومي للسوائل. استهلكت :percentage% (:consumed مل من :limit مل).',

      'FluidLimitExceeded' => 'تم تجاوز الحد اليومي للسوائل. استهلكت :consumed مل من أصل :limit مل.',

      'MedicationDoseUpcoming' => 'موعد جرعة :medication (:dosage) قريب، الساعة :scheduled_at.',

      'MedicationDoseDue' => 'حان الآن موعد جرعة :medication (:dosage).',

      'MedicationDoseMissed' => 'لم يتم تسجيل جرعة :medication (:dosage) المقررة الساعة :scheduled_at.',
  ),
);
