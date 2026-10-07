@extends('layouts.admin')
@section('title',lng('dashboard.medications.create_medications','اضافة دواء عام'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard','لوحة التحكم')">
        <x-header.breadcrumb-item :href="route('system.patient_medications.index')" :name="lng('dashboard.medications.patient_medications','إدارة أدوية المرضى')"/>

        <x-header.breadcrumb-item :name="lng('dashboard.patient_medications.create_medication','اضافة دواء للمريض')"/>
    </x-header.title>
@endsection

@push('css')
    <style>
        .card-title{
            color:#133e4a !important;
            font-size:700px
        }
    </style>

    @endpush
@section('content')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

        <div class="d-flex flex-column flex-column-fluid">


            {{-- Content --}}
            <div
                id="kt_app_content"
                class="app-content flex-column-fluid"
            >

                <div
                    id="kt_app_content_container"
                    class="app-container container-fluid"
                >

                    {{-- Validation Errors --}}
                    @if ($errors->any())

                        <div class="alert alert-danger d-flex align-items-start mb-7">

                            <i class="ki-duotone ki-information-5 fs-2hx me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>

                            <div>

                                <h4 class="mb-1">
                                    يرجى مراجعة البيانات
                                </h4>

                                <ul class="mb-0 ps-5">

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    @endif


                    <form
                        method="POST"
                        action="{{ route('system.patient_medications.store') }}"
                        id="patient-medication-form"
                    >

                        @csrf


                        <div class="row g-7">

                            {{-- ========================================= --}}
                            {{-- LEFT COLUMN --}}
                            {{-- ========================================= --}}

                            <div class="col-xl-8">


                                {{-- ========================================= --}}
                                {{-- Patient & Medication --}}
                                {{-- ========================================= --}}

                                <div class="card card-flush mb-7">

                                    <div class="card-header">

                                        <div class="card-title">

                                            <div class="d-flex align-items-center">

                                                <div class="symbol symbol-40px me-3">
                                                <span class="symbol-label bg-light-primary">

                                                    <i class="ki-duotone ki-profile-user fs-2 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>

                                                </span>
                                                </div>

                                                <div>

                                                    <h3 class="card-title fw-bold mb-1">
                                                        المريض والدواء
                                                    </h3>

                                                    <div class="text-muted fs-7">
                                                        حدد المريض والدواء العام المراد وصفه
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="card-body pt-5">

                                        <div class="row g-5">


                                            {{-- Patient --}}
                                            <div class="col-md-6">

                                                <label class="form-label required">
                                                    المريض
                                                </label>

                                                <select
                                                    name="patient_id"
                                                    id="patient_id"
                                                    class="form-select form-select-solid @error('patient_id') is-invalid @enderror"
                                                    data-control="select2"
                                                    data-placeholder="اختر المريض"
                                                    data-allow-clear="true"
                                                >

                                                    <option></option>

                                                    @foreach ($patients as $patient)

                                                        <option
                                                            value="{{ $patient->id }}"
                                                            @selected(old('patient_id') == $patient->id)
                                                        >
                                                            {{ $patient->user?->name ?? 'بدون اسم' }}

                                                            @if($patient->user?->phone)
                                                                — {{ $patient->user->phone }}
                                                            @endif
                                                        </option>

                                                    @endforeach

                                                </select>

                                                @error('patient_id')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>


                                            {{-- Medication --}}
                                            <div class="col-md-6">

                                                <label class="form-label required">
                                                    الدواء
                                                </label>

                                                <select
                                                    name="medication_id"
                                                    id="medication_id"
                                                    class="form-select form-select-solid @error('medication_id') is-invalid @enderror"
                                                    data-control="select2"
                                                    data-placeholder="اختر الدواء"
                                                    data-allow-clear="true"
                                                >

                                                    <option></option>

                                                    @foreach ($medications as $medication)

                                                        <option
                                                            value="{{ $medication->id }}"
                                                            @selected(old('medication_id') == $medication->id)
                                                        >
                                                            {{ $medication->name }}

                                                            @if($medication->name_en)
                                                                — {{ $medication->name_en }}
                                                            @endif
                                                        </option>

                                                    @endforeach

                                                </select>

                                                @error('medication_id')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>


                                        </div>

                                    </div>

                                </div>


                                {{-- ========================================= --}}
                                {{-- Prescription Details --}}
                                {{-- ========================================= --}}

                                <div class="card card-flush mb-7">

                                    <div class="card-header">

                                        <div class="card-title">

                                            <div class="d-flex align-items-center">

                                                <div class="symbol symbol-40px me-3">
                                                <span class="symbol-label bg-light-success">

                                                    <i class="ki-duotone ki-prescription fs-2 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>

                                                </span>
                                                </div>

                                                <div>

                                                    <h3 class="card-title fw-bold mb-1">
                                                        تفاصيل الوصفة
                                                    </h3>

                                                    <div class="text-muted fs-7">
                                                        حدد الجرعة وطريقة الاستخدام والتكرار
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="card-body pt-5">

                                        <div class="row g-5">


                                            {{-- Doctor --}}
                                            <div class="col-md-6">

                                                <label class="form-label">
                                                    الطبيب الواصف
                                                </label>

                                                <select
                                                    name="doctor_id"
                                                    id="doctor_id"
                                                    class="form-select form-select-solid @error('doctor_id') is-invalid @enderror"
                                                    data-control="select2"
                                                    data-placeholder="اختر الطبيب"
                                                    data-allow-clear="true"
                                                >

                                                    <option></option>

                                                    @foreach ($doctors as $doctor)

                                                        <option
                                                            value="{{ $doctor->id }}"
                                                            @selected(old('doctor_id') == $doctor->id)
                                                        >
                                                            د. {{ $doctor->user?->name ?? 'بدون اسم' }}

                                                            @if($doctor->specialization)
                                                                — {{ $doctor->specialization }}
                                                            @endif
                                                        </option>

                                                    @endforeach

                                                </select>

                                                @error('doctor_id')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>


                                            {{-- Dosage --}}
                                            <div class="col-md-6">

                                                <label class="form-label required">
                                                    الجرعة
                                                </label>

                                                <input
                                                    type="text"
                                                    name="dosage"
                                                    value="{{ old('dosage') }}"
                                                    class="form-control form-control-solid @error('dosage') is-invalid @enderror"
                                                    placeholder="مثال: 500 mg أو قرص واحد"
                                                >

                                                <div class="form-text">
                                                    يمكن إدخال الجرعة كنص مثل: 500 mg، قرص واحد، 5 ml
                                                </div>

                                                @error('dosage')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>


                                            {{-- Frequency --}}
                                            <div class="col-md-6">

                                                <label class="form-label required">
                                                    تكرار الدواء
                                                </label>

                                                <select
                                                    name="frequency"
                                                    id="frequency"
                                                    class="form-select form-select-solid @error('frequency') is-invalid @enderror"
                                                    data-control="select2"
                                                    data-placeholder="اختر التكرار"
                                                >

                                                    <option></option>

                                                    <option
                                                        value="once_daily"
                                                        @selected(old('frequency') === 'once_daily')
                                                    >
                                                        مرة يوميًا
                                                    </option>

                                                    <option
                                                        value="twice_daily"
                                                        @selected(old('frequency') === 'twice_daily')
                                                    >
                                                        مرتين يوميًا
                                                    </option>

                                                    <option
                                                        value="three_times_daily"
                                                        @selected(old('frequency') === 'three_times_daily')
                                                    >
                                                        3 مرات يوميًا
                                                    </option>

                                                    <option
                                                        value="four_times_daily"
                                                        @selected(old('frequency') === 'four_times_daily')
                                                    >
                                                        4 مرات يوميًا
                                                    </option>

                                                    <option
                                                        value="every_12_hours"
                                                        @selected(old('frequency') === 'every_12_hours')
                                                    >
                                                        كل 12 ساعة
                                                    </option>

                                                    <option
                                                        value="every_8_hours"
                                                        @selected(old('frequency') === 'every_8_hours')
                                                    >
                                                        كل 8 ساعات
                                                    </option>

                                                    <option
                                                        value="every_6_hours"
                                                        @selected(old('frequency') === 'every_6_hours')
                                                    >
                                                        كل 6 ساعات
                                                    </option>

                                                    <option
                                                        value="as_needed"
                                                        @selected(old('frequency') === 'as_needed')
                                                    >
                                                        عند الحاجة
                                                    </option>

                                                </select>

                                                @error('frequency')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>


                                            {{-- Route --}}
                                            <div class="col-md-6">

                                                <label class="form-label required">
                                                    طريقة الاستخدام
                                                </label>

                                                <select
                                                    name="route"
                                                    class="form-select form-select-solid @error('route') is-invalid @enderror"
                                                    data-control="select2"
                                                    data-placeholder="اختر طريقة الاستخدام"
                                                >

                                                    <option></option>

                                                    <option value="oral" @selected(old('route') === 'oral')}>
                                                        عن طريق الفم
                                                    </option>

                                                    <option value="intravenous" @selected(old('route') === 'intravenous')}>
                                                        وريدي
                                                    </option>

                                                    <option value="intramuscular" @selected(old('route') === 'intramuscular')}>
                                                        عضلي
                                                    </option>

                                                    <option value="subcutaneous" @selected(old('route') === 'subcutaneous')}>
                                                        تحت الجلد
                                                    </option>

                                                    <option value="topical" @selected(old('route') === 'topical')}>
                                                        موضعي
                                                    </option>

                                                    <option value="inhalation" @selected(old('route') === 'inhalation')}>
                                                        استنشاق
                                                    </option>

                                                    <option value="other" @selected(old('route') === 'other')}>
                                                        أخرى
                                                    </option>

                                                </select>

                                                @error('route')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>


                                        </div>

                                    </div>

                                </div>


                                {{-- ========================================= --}}
                                {{-- Schedule --}}
                                {{-- ========================================= --}}

                                <div class="card card-flush mb-7">

                                    <div class="card-header">

                                        <div class="card-title">

                                            <div class="d-flex align-items-center">

                                                <div class="symbol symbol-40px me-3">
                                                <span class="symbol-label bg-light-warning">

                                                    <i class="ki-duotone ki-calendar-8 fs-2 text-warning">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                        <span class="path6"></span>
                                                    </i>

                                                </span>
                                                </div>

                                                <div>

                                                    <h3 class="card-title fw-bold mb-1">
                                                        مدة العلاج والجدولة
                                                    </h3>

                                                    <div class="text-muted fs-7">
                                                        حدد فترة استخدام الدواء وأوقات التذكير
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="card-body pt-5">


                                        {{-- Dates --}}
                                        <div class="row g-5 mb-7">

                                            <div class="col-md-6">

                                                <label class="form-label required">
                                                    تاريخ البداية
                                                </label>

                                                <input
                                                    type="date"
                                                    name="start_date"
                                                    value="{{ old('start_date', now()->format('Y-m-d')) }}"
                                                    class="form-control form-control-solid @error('start_date') is-invalid @enderror"
                                                >

                                                @error('start_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>


                                            <div class="col-md-6">

                                                <label class="form-label">
                                                    تاريخ النهاية
                                                </label>

                                                <input
                                                    type="date"
                                                    name="end_date"
                                                    value="{{ old('end_date') }}"
                                                    class="form-control form-control-solid @error('end_date') is-invalid @enderror"
                                                >

                                                <div class="form-text">
                                                    اتركه فارغًا إذا كان العلاج مستمرًا.
                                                </div>

                                                @error('end_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                            </div>

                                        </div>


                                        {{-- Reminder --}}
                                        <div class="separator separator-dashed mb-7"></div>


                                        <div class="d-flex flex-stack mb-5">

                                            <div class="d-flex align-items-center">

                                                <div class="symbol symbol-40px me-4">

                                                <span class="symbol-label bg-light-info">

                                                    <i class="ki-duotone ki-notification-on fs-2 text-info">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>

                                                </span>

                                                </div>

                                                <div>

                                                    <div class="fw-bold fs-6">
                                                        تذكيرات الدواء
                                                    </div>

                                                    <div class="text-muted fs-7">
                                                        إرسال تنبيهات للمريض حسب أوقات الجرعات
                                                    </div>

                                                </div>

                                            </div>


                                            <div class="form-check form-switch form-check-custom form-check-solid">

                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="reminder_enabled"
                                                    value="1"
                                                    id="reminder_enabled"
                                                    @checked(old('reminder_enabled'))
                                                >

                                                <label
                                                    class="form-check-label fw-semibold"
                                                    for="reminder_enabled"
                                                >
                                                    تفعيل
                                                </label>

                                            </div>

                                        </div>


                                        {{-- Reminder Times --}}
                                        <div
                                            id="reminder-section"
                                            class="{{ old('reminder_enabled') ? '' : 'd-none' }}"
                                        >

                                            <div class="alert alert-light-primary d-flex align-items-center mb-5">

                                                <i class="ki-duotone ki-information-5 fs-2 text-primary me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>

                                                <div class="fs-7">

                                                    <div class="fw-bold mb-1">
                                                        أوقات التذكير
                                                    </div>

                                                    يتم اقتراح الأوقات تلقائيًا حسب تكرار الدواء،
                                                    ويمكنك تعديلها حسب الحاجة.

                                                </div>

                                            </div>


                                            <div id="reminder-times-container"></div>


                                            <button
                                                type="button"
                                                id="add-reminder-time"
                                                class="btn btn-sm btn-light-primary"
                                            >

                                                <i class="ki-duotone ki-plus fs-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>

                                                إضافة وقت آخر

                                            </button>

                                        </div>

                                    </div>

                                </div>


                                {{-- ========================================= --}}
                                {{-- Instructions --}}
                                {{-- ========================================= --}}

                                <div class="card card-flush mb-7">

                                    <div class="card-header">

                                        <div class="card-title">

                                            <div>

                                                <h3 class="card-title fw-bold mb-1">
                                                    تعليمات إضافية
                                                </h3>

                                                <div class="text-muted fs-7">
                                                    ملاحظات أو تعليمات خاصة باستخدام الدواء
                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="card-body">

                                    <textarea
                                        name="instructions"
                                        rows="4"
                                        class="form-control form-control-solid @error('instructions') is-invalid @enderror"
                                        placeholder="مثال: يؤخذ بعد الطعام، أو حسب تعليمات الطبيب..."
                                    >{{ old('instructions') }}</textarea>

                                        @error('instructions')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>

                                </div>


                                {{-- ========================================= --}}
                                {{-- Submit --}}
                                {{-- ========================================= --}}

                                <div class="d-flex justify-content-end gap-3">

                                    <a
                                        href="{{ route('system.patient_medications.index') }}"
                                        class="btn btn-light"
                                    >
                                        إلغاء
                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        id="submit-btn"
                                    >

                                    <span class="indicator-label">

                                        <i class="ki-duotone ki-check-circle fs-2 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>

                                        حفظ وصفة الدواء

                                    </span>

                                        <span class="indicator-progress">

                                        جارٍ الحفظ...

                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>

                                    </span>

                                    </button>

                                </div>


                            </div>


                            {{-- ========================================= --}}
                            {{-- RIGHT COLUMN --}}
                            {{-- ========================================= --}}

                            <div class="col-xl-4">


                                {{-- Prescription Summary --}}
                                <div class="card card-flush mb-7">

                                    <div class="card-header">

                                        <div class="card-title">

                                            <h3 class="card-title fw-bold">
                                                ملخص الوصفة
                                            </h3>

                                        </div>

                                    </div>


                                    <div class="card-body pt-5">

                                        <div class="d-flex align-items-center mb-6">

                                            <div class="symbol symbol-50px me-4">

                                            <span class="symbol-label bg-light-primary">

                                                <i class="ki-duotone ki-capsule fs-2x text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>

                                            </span>

                                            </div>

                                            <div>

                                                <div
                                                    id="summary-medication"
                                                    class="fw-bold fs-5 text-gray-900"
                                                >
                                                    لم يتم اختيار الدواء
                                                </div>

                                                <div
                                                    id="summary-patient"
                                                    class="text-muted fs-7"
                                                >
                                                    لم يتم اختيار المريض
                                                </div>

                                            </div>

                                        </div>


                                        <div class="separator separator-dashed mb-5"></div>


                                        <div class="d-flex flex-stack mb-4">

                                        <span class="text-muted">
                                            الجرعة
                                        </span>

                                            <span
                                                id="summary-dosage"
                                                class="fw-bold text-gray-800"
                                            >
                                            —
                                        </span>

                                        </div>


                                        <div class="d-flex flex-stack mb-4">

                                        <span class="text-muted">
                                            التكرار
                                        </span>

                                            <span
                                                id="summary-frequency"
                                                class="fw-bold text-gray-800"
                                            >
                                            —
                                        </span>

                                        </div>


                                        <div class="d-flex flex-stack mb-4">

                                        <span class="text-muted">
                                            طريقة الاستخدام
                                        </span>

                                            <span
                                                id="summary-route"
                                                class="fw-bold text-gray-800"
                                            >
                                            —
                                        </span>

                                        </div>


                                        <div class="d-flex flex-stack">

                                        <span class="text-muted">
                                            التذكيرات
                                        </span>

                                            <span
                                                id="summary-reminders"
                                                class="badge badge-light-secondary"
                                            >
                                            غير مفعلة
                                        </span>

                                        </div>

                                    </div>

                                </div>


                                {{-- Information --}}
                                <div class="card card-flush mb-7">

                                    <div class="card-body">

                                        <div class="d-flex align-items-start">

                                            <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>

                                            <div>

                                                <h4 class="fw-bold mb-2">
                                                    ملاحظة مهمة
                                                </h4>

                                                <p class="text-muted fs-7 mb-0">
                                                    يتم اختيار الدواء من قائمة الأدوية العامة
                                                    المسجلة في النظام، ثم ربطه بالمريض
                                                    كخطة دوائية خاصة به.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Status --}}
                                <div class="card card-flush">

                                    <div class="card-header">

                                        <div class="card-title">

                                            <h3 class="card-title fw-bold">
                                                حالة الوصفة
                                            </h3>

                                        </div>

                                    </div>


                                    <div class="card-body pt-5">

                                        <label class="form-label required">
                                            الحالة
                                        </label>

                                        <select
                                            name="status"
                                            id="status"
                                            class="form-select form-select-solid @error('status') is-invalid @enderror"
                                            data-control="select2"
                                        >

                                            <option
                                                value="active"
                                                @selected(old('status', 'active') === 'active')
                                            >
                                                نشطة
                                            </option>

                                            <option
                                                value="stopped"
                                                @selected(old('status') === 'stopped')
                                            >
                                                متوقفة
                                            </option>

                                            <option
                                                value="completed"
                                                @selected(old('status') === 'completed')
                                            >
                                                مكتملة
                                            </option>

                                        </select>

                                        @error('status')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>

                                </div>


                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('js')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('patient-medication-form');

            const frequency = document.getElementById('frequency');

            const reminderEnabled = document.getElementById('reminder_enabled');

            const reminderSection = document.getElementById('reminder-section');

            const reminderContainer =
                document.getElementById('reminder-times-container');

            const addReminderButton =
                document.getElementById('add-reminder-time');


            /*
            |--------------------------------------------------------------------------
            | Labels
            |--------------------------------------------------------------------------
            */

            const frequencyLabels = {

                once_daily: 'مرة يوميًا',

                twice_daily: 'مرتين يوميًا',

                three_times_daily: '3 مرات يوميًا',

                four_times_daily: '4 مرات يوميًا',

                every_12_hours: 'كل 12 ساعة',

                every_8_hours: 'كل 8 ساعات',

                every_6_hours: 'كل 6 ساعات',

                as_needed: 'عند الحاجة'

            };


            const routeLabels = {

                oral: 'عن طريق الفم',

                intravenous: 'وريدي',

                intramuscular: 'عضلي',

                subcutaneous: 'تحت الجلد',

                topical: 'موضعي',

                inhalation: 'استنشاق',

                other: 'أخرى'

            };


            /*
            |--------------------------------------------------------------------------
            | Default reminder times
            |--------------------------------------------------------------------------
            */

            const defaultReminderTimes = {

                once_daily: [
                    '08:00'
                ],

                twice_daily: [
                    '08:00',
                    '20:00'
                ],

                three_times_daily: [
                    '08:00',
                    '14:00',
                    '20:00'
                ],

                four_times_daily: [
                    '08:00',
                    '12:00',
                    '16:00',
                    '20:00'
                ],

                every_12_hours: [
                    '08:00',
                    '20:00'
                ],

                every_8_hours: [
                    '06:00',
                    '14:00',
                    '22:00'
                ],

                every_6_hours: [
                    '06:00',
                    '12:00',
                    '18:00',
                    '00:00'
                ],

                as_needed: []

            };


            /*
            |--------------------------------------------------------------------------
            | Add reminder input
            |--------------------------------------------------------------------------
            */

            function addReminderInput(time = '') {

                const wrapper =
                    document.createElement('div');

                wrapper.className =
                    'reminder-time-row d-flex align-items-center gap-3 mb-3';


                wrapper.innerHTML = `

            <div class="flex-grow-1">

                <div class="input-group">

                    <span class="input-group-text bg-light">

                        <i class="ki-duotone ki-time fs-2 text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                    </span>

                    <input
                        type="time"
                        name="reminder_times[]"
                        value="${time}"
                        class="form-control form-control-solid"
                    >

                </div>

            </div>


            <button
                type="button"
                class="btn btn-icon btn-light-danger remove-reminder-time"
                title="حذف الوقت"
            >

                <i class="ki-duotone ki-trash fs-2">

                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>

                </i>

            </button>

        `;


                reminderContainer.appendChild(wrapper);

            }


            /*
            |--------------------------------------------------------------------------
            | Render reminder times
            |--------------------------------------------------------------------------
            */

            function renderReminderTimes(times = []) {

                reminderContainer.innerHTML = '';

                times.forEach(function (time) {

                    addReminderInput(time);

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Frequency changed
            |--------------------------------------------------------------------------
            */

            frequency.addEventListener('change', function () {

                const selectedFrequency = this.value;

                const times =
                    defaultReminderTimes[selectedFrequency] ?? [];

                if (reminderEnabled.checked) {

                    renderReminderTimes(times);

                }

                updateSummary();

            });


            /*
            |--------------------------------------------------------------------------
            | Reminder enabled
            |--------------------------------------------------------------------------
            */

            reminderEnabled.addEventListener('change', function () {

                if (this.checked) {

                    reminderSection.classList.remove('d-none');

                    const existingInputs =
                        reminderContainer.querySelectorAll(
                            'input[name="reminder_times[]"]'
                        );

                    if (existingInputs.length === 0) {

                        const times =
                            defaultReminderTimes[frequency.value] ?? [];

                        renderReminderTimes(times);

                    }

                } else {

                    reminderSection.classList.add('d-none');

                }

                updateSummary();

            });


            /*
            |--------------------------------------------------------------------------
            | Add custom reminder
            |--------------------------------------------------------------------------
            */

            addReminderButton.addEventListener('click', function () {

                addReminderInput('');

            });


            /*
            |--------------------------------------------------------------------------
            | Remove reminder
            |--------------------------------------------------------------------------
            */

            reminderContainer.addEventListener('click', function (event) {

                const button =
                    event.target.closest('.remove-reminder-time');

                if (!button) {
                    return;
                }

                const row =
                    button.closest('.reminder-time-row');

                if (row) {
                    row.remove();
                }

            });


            /*
            |--------------------------------------------------------------------------
            | Summary
            |--------------------------------------------------------------------------
            */

            function updateSummary() {

                const patientSelect =
                    document.getElementById('patient_id');

                const medicationSelect =
                    document.getElementById('medication_id');

                const dosage =
                    document.querySelector('[name="dosage"]');

                const route =
                    document.querySelector('[name="route"]');


                const patientText =
                    patientSelect?.selectedOptions[0]?.text ?? '';

                const medicationText =
                    medicationSelect?.selectedOptions[0]?.text ?? '';

                const dosageText =
                    dosage?.value?.trim() || '—';

                const frequencyText =
                    frequencyLabels[frequency.value] || '—';

                const routeText =
                    routeLabels[route.value] || '—';


                document.getElementById('summary-patient').textContent =
                    patientText.trim() || 'لم يتم اختيار المريض';

                document.getElementById('summary-medication').textContent =
                    medicationText.trim() || 'لم يتم اختيار الدواء';

                document.getElementById('summary-dosage').textContent =
                    dosageText;

                document.getElementById('summary-frequency').textContent =
                    frequencyText;

                document.getElementById('summary-route').textContent =
                    routeText;


                const reminderBadge =
                    document.getElementById('summary-reminders');


                if (!reminderEnabled.checked) {

                    reminderBadge.textContent =
                        'غير مفعلة';

                    reminderBadge.className =
                        'badge badge-light-secondary';

                    return;

                }


                const reminderInputs =
                    reminderContainer.querySelectorAll(
                        'input[name="reminder_times[]"]'
                    );


                const reminderCount =
                    Array.from(reminderInputs)
                        .filter(input => input.value)
                        .length;


                if (reminderCount > 0) {

                    reminderBadge.textContent =
                        `${reminderCount} أوقات`;

                    reminderBadge.className =
                        'badge badge-light-success';

                } else {

                    reminderBadge.textContent =
                        'بدون أوقات';

                    reminderBadge.className =
                        'badge badge-light-warning';

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Live summary
            |--------------------------------------------------------------------------
            */

            document
                .getElementById('patient_id')
                .addEventListener('change', updateSummary);

            document
                .getElementById('medication_id')
                .addEventListener('change', updateSummary);

            document
                .querySelector('[name="dosage"]')
                .addEventListener('input', updateSummary);

            document
                .querySelector('[name="route"]')
                .addEventListener('change', updateSummary);


            reminderContainer.addEventListener(
                'input',
                updateSummary
            );


            /*
            |--------------------------------------------------------------------------
            | Old reminder times after validation error
            |--------------------------------------------------------------------------
            */

            const oldReminderTimes =
                @json(old('reminder_times', []));


            if (
                Array.isArray(oldReminderTimes) &&
                oldReminderTimes.length > 0
            ) {

                renderReminderTimes(oldReminderTimes);

            } else if (
                reminderEnabled.checked &&
                frequency.value
            ) {

                renderReminderTimes(
                    defaultReminderTimes[frequency.value] ?? []
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Submit loading
            |--------------------------------------------------------------------------
            */

            form.addEventListener('submit', function () {

                const button =
                    document.getElementById('submit-btn');

                button.setAttribute(
                    'data-kt-indicator',
                    'on'
                );

                button.disabled = true;

            });


            /*
            |--------------------------------------------------------------------------
            | Initial summary
            |--------------------------------------------------------------------------
            */

            updateSummary();

        });

    </script>

@endpush
