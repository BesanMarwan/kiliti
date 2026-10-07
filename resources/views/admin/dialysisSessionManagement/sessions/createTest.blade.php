@extends('layouts.admin')

@section('title', 'إضافة جدول جلسات غسيل')

@section('content')

    <div class="d-flex flex-column flex-column-fluid">

        {{-- Toolbar --}}
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div
                id="kt_app_toolbar_container"
                class="app-container container-fluid d-flex flex-stack"
            >

                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        إضافة جدول جلسات غسيل
                    </h1>

                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                        <li class="breadcrumb-item text-muted">
                            لوحة التحكم
                        </li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">
                            جلسات الغسيل
                        </li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-gray-900">
                            إضافة جدول
                        </li>

                    </ul>

                </div>

                <div class="d-flex align-items-center gap-2">

                    <a
                        href="{{ route('system.dialysis_sessions.index') }}"
                        class="btn btn-light"
                    >
                        <i class="ki-duotone ki-arrow-right fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        رجوع
                    </a>

                </div>

            </div>
        </div>


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

                    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">

                        <i class="ki-duotone ki-information-5 fs-2hx text-danger me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>

                        <div class="d-flex flex-column">

                            <h4 class="mb-1 text-danger">
                                تعذر إنشاء جدول الجلسات
                            </h4>

                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('system.dialysis_sessions.store') }}"
                    id="dialysis-session-form"
                >

                    @csrf


                    <div class="row g-7">

                        {{-- ================================================= --}}
                        {{-- RIGHT SIDE --}}
                        {{-- ================================================= --}}

                        <div class="col-xl-8">

                            {{-- Patient --}}
                            <div class="card card-flush mb-7">

                                <div class="card-header">

                                    <div class="card-title">
                                        <h2 class="fw-bold">
                                            بيانات المريض
                                        </h2>
                                    </div>

                                </div>


                                <div class="card-body">

                                    <div class="mb-7">

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

                                            @foreach($patients as $patient)

                                                @php

                                                    $hasSessions =
                                                        $patient->active_sessions_count > 0;

                                                    $patientName =
                                                        $patient->user?->name
                                                        ?? 'مريض بدون اسم';

                                                    $centerName =
                                                        $patient->dialysisCenter?->name
                                                        ?? 'غير محدد';

                                                    $doctorName =
                                                        $patient->doctor?->user?->name
                                                        ?? 'غير محدد';

                                                @endphp

                                                <option
                                                    value="{{ $patient->id }}"

                                                    data-name="{{ $patientName }}"

                                                    data-center="{{ $centerName }}"

                                                    data-doctor="{{ $doctorName }}"

                                                    data-sessions="{{ $patient->active_sessions_count }}"

                                                    data-has-sessions="{{ $hasSessions ? '1' : '0' }}"

                                                    data-dialysis-type="{{ $patient->dialysis_type }}"

                                                    data-start-date="{{ optional($patient->dialysis_start_date)->format('Y-m-d') }}"

                                                    data-end-date="{{ optional($patient->dialysis_end_date)->format('Y-m-d') }}"

                                                    data-sessions-per-week="{{ $patient->sessions_per_week }}"
                                                >

                                                    {{ $patientName }}

                                                    @if($hasSessions)
                                                        — لديه {{ $patient->active_sessions_count }} جلسة
                                                    @else
                                                        — لا توجد جلسات
                                                    @endif

                                                </option>

                                            @endforeach

                                        </select>

                                        @error('patient_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="form-text">
                                            اختر المريض لعرض بيانات خطة الغسيل المرتبطة به.
                                        </div>

                                    </div>


                                    {{-- Patient Info --}}
                                    <div
                                        id="patient-info-card"
                                        class="card card-flush border border-dashed border-gray-300 d-none"
                                    >

                                        <div class="card-body p-6">

                                            {{-- Header --}}
                                            <div class="d-flex align-items-center mb-6">

                                                <div class="symbol symbol-50px symbol-circle me-4">

                                                    <div class="symbol-label bg-light-primary">

                                                        <i class="ki-duotone ki-profile-user fs-2x text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>

                                                    </div>

                                                </div>


                                                <div class="flex-grow-1">

                                                    <div
                                                        id="patient-name"
                                                        class="fw-bold fs-5 text-gray-900"
                                                    >
                                                        -
                                                    </div>

                                                    <div class="text-muted fs-7">
                                                        بيانات خطة الغسيل
                                                    </div>

                                                </div>


                                                <div id="patient-session-status"></div>

                                            </div>


                                            <div class="separator separator-dashed mb-6"></div>


                                            {{-- Info --}}
                                            <div class="row g-5">

                                                {{-- Sessions --}}
                                                <div class="col-md-4">

                                                    <div class="d-flex align-items-center">

                                                        <div class="symbol symbol-40px symbol-circle bg-light-info me-3">

                                                            <i class="ki-duotone ki-calendar fs-2 text-info">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>

                                                        </div>

                                                        <div>

                                                            <div class="text-muted fs-8">
                                                                الجلسات الحالية
                                                            </div>

                                                            <div
                                                                id="patient-sessions"
                                                                class="fw-bold text-gray-900"
                                                            >
                                                                -
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                                {{-- Center --}}
                                                <div class="col-md-4">

                                                    <div class="d-flex align-items-center">

                                                        <div class="symbol symbol-40px symbol-circle bg-light-success me-3">

                                                            <i class="ki-duotone ki-geolocation fs-2 text-success">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>

                                                        </div>

                                                        <div>

                                                            <div class="text-muted fs-8">
                                                                مركز الغسيل
                                                            </div>

                                                            <div
                                                                id="patient-center"
                                                                class="fw-bold text-gray-900"
                                                            >
                                                                -
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                                {{-- Doctor --}}
                                                <div class="col-md-4">

                                                    <div class="d-flex align-items-center">

                                                        <div class="symbol symbol-40px symbol-circle bg-light-warning me-3">

                                                            <i class="ki-duotone ki-profile-circle fs-2 text-warning">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>

                                                        </div>

                                                        <div>

                                                            <div class="text-muted fs-8">
                                                                الطبيب
                                                            </div>

                                                            <div
                                                                id="patient-doctor"
                                                                class="fw-bold text-gray-900"
                                                            >
                                                                -
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                                {{-- Dialysis Type --}}
                                                <div class="col-md-4">

                                                    <div class="d-flex align-items-center">

                                                        <div class="symbol symbol-40px symbol-circle bg-light-primary me-3">

                                                            <i class="ki-duotone ki-heart-circle fs-2 text-primary">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>

                                                        </div>

                                                        <div>

                                                            <div class="text-muted fs-8">
                                                                نوع الغسيل
                                                            </div>

                                                            <div
                                                                id="patient-dialysis-type"
                                                                class="fw-bold text-gray-900"
                                                            >
                                                                -
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                                {{-- Sessions Per Week --}}
                                                <div class="col-md-4">

                                                    <div class="d-flex align-items-center">

                                                        <div class="symbol symbol-40px symbol-circle bg-light-dark me-3">

                                                            <i class="ki-duotone ki-chart-simple fs-2 text-dark">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                            </i>

                                                        </div>

                                                        <div>

                                                            <div class="text-muted fs-8">
                                                                الجلسات أسبوعيًا
                                                            </div>

                                                            <div
                                                                id="patient-sessions-per-week"
                                                                class="fw-bold text-gray-900"
                                                            >
                                                                -
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                                {{-- Current Start Date --}}
                                                <div class="col-md-4">

                                                    <div class="d-flex align-items-center">

                                                        <div class="symbol symbol-40px symbol-circle bg-light-warning me-3">

                                                            <i class="ki-duotone ki-calendar-add fs-2 text-warning">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>

                                                        </div>

                                                        <div>

                                                            <div class="text-muted fs-8">
                                                                بداية خطة الغسيل
                                                            </div>

                                                            <div
                                                                id="patient-start-date-info"
                                                                class="fw-bold text-gray-900"
                                                            >
                                                                -
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- Schedule --}}
                            <div class="card card-flush mb-7">

                                <div class="card-header">

                                    <div class="card-title">

                                        <h2 class="fw-bold">
                                            إعداد جدول الجلسات
                                        </h2>

                                    </div>

                                </div>


                                <div class="card-body">

                                    <div class="row g-5">

                                        {{-- Start --}}
                                        <div class="col-md-6">

                                            <label class="form-label required">
                                                تاريخ بداية الجدول
                                            </label>

                                            <input
                                                type="date"
                                                name="start_date"
                                                id="start_date"
                                                value="{{ old('start_date') }}"
                                                class="form-control form-control-solid @error('start_date') is-invalid @enderror"
                                            >

                                            @error('start_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                        </div>


                                        {{-- End --}}
                                        <div class="col-md-6">

                                            <label class="form-label">
                                                تاريخ نهاية الجدول
                                            </label>

                                            <input
                                                type="date"
                                                name="end_date"
                                                id="end_date"
                                                value="{{ old('end_date') }}"
                                                class="form-control form-control-solid @error('end_date') is-invalid @enderror"
                                            >

                                            <div class="form-text">
                                                إذا تركته فارغًا سيتم إنشاء الجلسات لمدة 3 أشهر من تاريخ البداية.
                                            </div>

                                            @error('end_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                        </div>


                                        {{-- Sessions per week --}}
                                        <div class="col-md-6">

                                            <label class="form-label required">
                                                عدد الجلسات أسبوعيًا
                                            </label>

                                            <select
                                                name="sessions_per_week"
                                                id="sessions_per_week"
                                                class="form-select form-select-solid @error('sessions_per_week') is-invalid @enderror"
                                                data-control="select2"
                                                data-hide-search="true"
                                                data-placeholder="اختر عدد الجلسات"
                                            >

                                                <option value="">
                                                    اختر العدد
                                                </option>

                                                @for($i = 1; $i <= 7; $i++)

                                                    <option
                                                        value="{{ $i }}"
                                                        {{ old('sessions_per_week') == $i ? 'selected' : '' }}
                                                    >
                                                        {{ $i }} {{ $i == 1 ? 'جلسة' : 'جلسات' }}
                                                    </option>

                                                @endfor

                                            </select>

                                            @error('sessions_per_week')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                        </div>


                                        {{-- Time --}}
                                        <div class="col-md-6">

                                            <label class="form-label required">
                                                وقت الجلسة
                                            </label>

                                            <input
                                                type="time"
                                                name="time"
                                                id="session_time"
                                                value="{{ old('time') }}"
                                                class="form-control form-control-solid @error('time') is-invalid @enderror"
                                            >

                                            @error('time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Days --}}
                                    <div class="mt-8">

                                        <label class="form-label required">
                                            أيام الجلسات الأسبوعية
                                        </label>

                                        <div class="text-muted fs-7 mb-5">
                                            اختر عدد الأيام المطابق لعدد الجلسات الأسبوعية.
                                        </div>


                                        <div class="row g-4">

                                            @php

                                                $days = [
                                                    'saturday' => 'السبت',
                                                    'sunday' => 'الأحد',
                                                    'monday' => 'الإثنين',
                                                    'tuesday' => 'الثلاثاء',
                                                    'wednesday' => 'الأربعاء',
                                                    'thursday' => 'الخميس',
                                                    'friday' => 'الجمعة',
                                                ];

                                                $oldDays = old('days', []);

                                            @endphp


                                            @foreach($days as $value => $label)

                                                <div class="col-6 col-md-4 col-lg-3">

                                                    <label
                                                        class="form-check form-check-custom form-check-solid border border-gray-300 rounded p-4 h-100 cursor-pointer"
                                                    >

                                                        <input
                                                            class="form-check-input session-day"
                                                            type="checkbox"
                                                            name="days[]"
                                                            value="{{ $value }}"
                                                            {{ in_array($value, $oldDays) ? 'checked' : '' }}
                                                        >

                                                        <span class="form-check-label fw-semibold">
                                                            {{ $label }}
                                                        </span>

                                                    </label>

                                                </div>

                                            @endforeach

                                        </div>


                                        <div
                                            id="days-error"
                                            class="text-danger fs-7 mt-3 d-none"
                                        ></div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- LEFT SIDE --}}
                        {{-- ================================================= --}}

                        <div class="col-xl-4">

                            {{-- Preview --}}
                            <div class="card card-flush mb-7">

                                <div class="card-header">

                                    <div class="card-title">

                                        <h2 class="fw-bold">
                                            معاينة الجدول
                                        </h2>

                                    </div>

                                </div>


                                <div class="card-body">

                                    <div class="d-flex flex-column gap-6">

                                        {{-- Total --}}
                                        <div class="d-flex align-items-center">

                                            <div class="symbol symbol-45px symbol-circle bg-light-primary me-4">

                                                <i class="ki-duotone ki-calendar-tick fs-2x text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>

                                            </div>

                                            <div>

                                                <div class="text-muted fs-7">
                                                    عدد الجلسات المتوقع
                                                </div>

                                                <div
                                                    id="preview-total"
                                                    class="fs-2 fw-bold text-gray-900"
                                                >
                                                    0
                                                </div>

                                            </div>

                                        </div>


                                        {{-- Period --}}
                                        <div class="d-flex align-items-center">

                                            <div class="symbol symbol-45px symbol-circle bg-light-info me-4">

                                                <i class="ki-duotone ki-calendar-8 fs-2x text-info">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>

                                            </div>

                                            <div>

                                                <div class="text-muted fs-7">
                                                    الفترة
                                                </div>

                                                <div
                                                    id="preview-period"
                                                    class="fw-bold text-gray-900"
                                                >
                                                    -
                                                </div>

                                            </div>

                                        </div>


                                        {{-- Frequency --}}
                                        <div class="d-flex align-items-center">

                                            <div class="symbol symbol-45px symbol-circle bg-light-success me-4">

                                                <i class="ki-duotone ki-chart-simple fs-2x text-success">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>

                                            </div>

                                            <div>

                                                <div class="text-muted fs-7">
                                                    التكرار
                                                </div>

                                                <div
                                                    id="preview-frequency"
                                                    class="fw-bold text-gray-900"
                                                >
                                                    -
                                                </div>

                                            </div>

                                        </div>


                                        {{-- Time --}}
                                        <div class="d-flex align-items-center">

                                            <div class="symbol symbol-45px symbol-circle bg-light-warning me-4">

                                                <i class="ki-duotone ki-time fs-2x text-warning">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>

                                            </div>

                                            <div>

                                                <div class="text-muted fs-7">
                                                    وقت الجلسة
                                                </div>

                                                <div
                                                    id="preview-time"
                                                    class="fw-bold text-gray-900"
                                                >
                                                    -
                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="separator my-7"></div>


                                    {{-- Warning --}}
                                    <div
                                        id="preview-warning"
                                        class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-5 d-none"
                                    >

                                        <i class="ki-duotone ki-information-5 fs-2tx text-warning me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>

                                        <div class="fw-semibold">

                                            <div class="fs-6 text-gray-900">
                                                تحقق من أيام الجلسات
                                            </div>

                                            <div
                                                id="preview-warning-text"
                                                class="fs-7 text-gray-600"
                                            ></div>

                                        </div>

                                    </div>


                                    {{-- Existing sessions info --}}
                                    <div
                                        id="existing-sessions-notice"
                                        class="notice d-flex bg-light-info rounded border-info border border-dashed p-5 d-none mt-5"
                                    >

                                        <i class="ki-duotone ki-information-5 fs-2tx text-info me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>

                                        <div>

                                            <div class="fw-bold fs-6 text-gray-900">
                                                المريض لديه جلسات سابقة
                                            </div>

                                            <div class="fs-7 text-gray-600">
                                                سيتم التحقق من عدم وجود تعارض في تواريخ الجلسات قبل الحفظ.
                                            </div>

                                        </div>

                                    </div>


                                </div>

                            </div>


                            {{-- Rules --}}
                            <div class="card card-flush mb-7">

                                <div class="card-header">

                                    <div class="card-title">

                                        <h3 class="fw-bold">
                                            ملاحظات
                                        </h3>

                                    </div>

                                </div>


                                <div class="card-body">

                                    <div class="d-flex flex-column gap-5">

                                        <div class="d-flex">

                                            <i class="ki-duotone ki-check-circle fs-2 text-success me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>

                                            <span class="text-gray-700 fs-7">
                                                سيتم إنشاء جلسة في كل يوم تم اختياره.
                                            </span>

                                        </div>


                                        <div class="d-flex">

                                            <i class="ki-duotone ki-check-circle fs-2 text-success me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>

                                            <span class="text-gray-700 fs-7">
                                                عدد الأيام يجب أن يساوي عدد الجلسات أسبوعيًا.
                                            </span>

                                        </div>


                                        <div class="d-flex">

                                            <i class="ki-duotone ki-check-circle fs-2 text-success me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>

                                            <span class="text-gray-700 fs-7">
                                                إذا لم تحدد تاريخ نهاية سيتم إنشاء الجدول لمدة 3 أشهر.
                                            </span>

                                        </div>


                                        <div class="d-flex">

                                            <i class="ki-duotone ki-check-circle fs-2 text-success me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>

                                            <span class="text-gray-700 fs-7">
                                                المركز والطبيب ونوع الغسيل يتم أخذهم من بيانات المريض.
                                            </span>

                                        </div>


                                        <div class="d-flex">

                                            <i class="ki-duotone ki-shield-check fs-2 text-primary me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>

                                            <span class="text-gray-700 fs-7">
                                                سيتم منع إنشاء جلسات متعارضة للمريض تلقائيًا.
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- Submit --}}
                            <div class="card card-flush">

                                <div class="card-body">

                                    <button
                                        type="submit"
                                        id="submit-btn"
                                        class="btn btn-primary w-100"
                                    >

                                        <i class="ki-duotone ki-calendar-add fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>

                                        إنشاء جدول الجلسات

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@push('js')

    <script>

        $(document).ready(function () {

            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const patientSelect = $('#patient_id');

            const patientInfoCard = $('#patient-info-card');

            const startDate = $('#start_date');
            const endDate = $('#end_date');

            const sessionsPerWeek = $('#sessions_per_week');

            const sessionTime = $('#session_time');

            const dayCheckboxes = $('.session-day');

            const form = $('#dialysis-session-form');

            const submitButton = $('#submit-btn');


            /*
            |--------------------------------------------------------------------------
            | Select2
            |--------------------------------------------------------------------------
            */

            patientSelect.select2({
                placeholder: 'اختر المريض',
                allowClear: true,
                width: '100%'
            });


            /*
            |--------------------------------------------------------------------------
            | Patient Selection
            |--------------------------------------------------------------------------
            */

            patientSelect.on('change', function () {

                const option = $(this).find(':selected');

                if (!option.val()) {

                    patientInfoCard.addClass('d-none');

                    $('#existing-sessions-notice').addClass('d-none');

                    return;
                }


                const name =
                    option.data('name') || '-';

                const center =
                    option.data('center') || 'غير محدد';

                const doctor =
                    option.data('doctor') || 'غير محدد';

                const sessions =
                    parseInt(option.data('sessions')) || 0;

                const hasSessions =
                    option.data('has-sessions') == 1;

                const dialysisType =
                    option.data('dialysis-type');

                const patientStartDate =
                    option.data('start-date');

                const patientEndDate =
                    option.data('end-date');

                const patientSessionsPerWeek =
                    option.data('sessions-per-week');


                /*
                |--------------------------------------------------------------------------
                | Patient Info
                |--------------------------------------------------------------------------
                */

                $('#patient-name').text(name);

                $('#patient-center').text(center);

                $('#patient-doctor').text(doctor);


                /*
                |--------------------------------------------------------------------------
                | Sessions Count
                |--------------------------------------------------------------------------
                */

                if (sessions > 0) {

                    $('#patient-sessions').html(`
                    <span class="text-info">
                        ${sessions}
                    </span>
                    جلسة
                `);

                } else {

                    $('#patient-sessions').html(`
                    <span class="text-muted">
                        لا توجد جلسات
                    </span>
                `);

                }


                /*
                |--------------------------------------------------------------------------
                | Dialysis Type
                |--------------------------------------------------------------------------
                */

                let dialysisTypeText = 'غير محدد';

                if (dialysisType === 'hemodialysis') {
                    dialysisTypeText = 'غسيل دموي';
                }

                if (dialysisType === 'peritoneal') {
                    dialysisTypeText = 'غسيل بروتوني';
                }

                $('#patient-dialysis-type').text(
                    dialysisTypeText
                );


                /*
                |--------------------------------------------------------------------------
                | Sessions Per Week
                |--------------------------------------------------------------------------
                */

                $('#patient-sessions-per-week').text(
                    patientSessionsPerWeek
                        ? `${patientSessionsPerWeek} جلسات أسبوعيًا`
                        : 'غير محدد'
                );


                /*
                |--------------------------------------------------------------------------
                | Patient Start Date
                |--------------------------------------------------------------------------
                */

                $('#patient-start-date-info').text(
                    patientStartDate || 'غير محدد'
                );


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                if (hasSessions) {

                    $('#patient-session-status').html(`
                    <span class="badge badge-light-info fs-7 px-4 py-3">

                        <i class="ki-duotone ki-calendar-8 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        لديه جلسات
                    </span>
                `);


                    $('#existing-sessions-notice')
                        .removeClass('d-none');

                } else {

                    $('#patient-session-status').html(`
                    <span class="badge badge-light-success fs-7 px-4 py-3">

                        <i class="ki-duotone ki-check-circle me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>

                        لا توجد جلسات
                    </span>
                `);


                    $('#existing-sessions-notice')
                        .addClass('d-none');

                }


                /*
                |--------------------------------------------------------------------------
                | Fill Schedule Defaults From Patient
                |--------------------------------------------------------------------------
                */

                if (patientStartDate && !startDate.val()) {

                    startDate.val(patientStartDate);

                }


                if (patientEndDate && !endDate.val()) {

                    endDate.val(patientEndDate);

                }


                if (
                    patientSessionsPerWeek &&
                    !sessionsPerWeek.val()
                ) {

                    sessionsPerWeek
                        .val(patientSessionsPerWeek)
                        .trigger('change');

                }


                /*
                |--------------------------------------------------------------------------
                | Show Card
                |--------------------------------------------------------------------------
                */

                patientInfoCard.removeClass('d-none');

                updatePreview();

            });


            /*
            |--------------------------------------------------------------------------
            | Preview
            |--------------------------------------------------------------------------
            */

            function updatePreview() {

                const startValue =
                    startDate.val();

                const endValue =
                    endDate.val();

                const frequency =
                    parseInt(sessionsPerWeek.val()) || 0;

                const time =
                    sessionTime.val();

                const selectedDays =
                    dayCheckboxes.filter(':checked').length;


                /*
                |--------------------------------------------------------------------------
                | Frequency
                |--------------------------------------------------------------------------
                */

                $('#preview-frequency').text(
                    frequency
                        ? `${frequency} جلسات أسبوعيًا`
                        : '-'
                );


                /*
                |--------------------------------------------------------------------------
                | Time
                |--------------------------------------------------------------------------
                */

                $('#preview-time').text(
                    time || '-'
                );


                /*
                |--------------------------------------------------------------------------
                | Days Validation
                |--------------------------------------------------------------------------
                */

                const warning =
                    $('#preview-warning');

                const warningText =
                    $('#preview-warning-text');

                const daysError =
                    $('#days-error');


                if (
                    frequency > 0 &&
                    selectedDays !== frequency
                ) {

                    const message =
                        `يجب اختيار ${frequency} ${frequency === 1 ? 'يوم' : 'أيام'} بالضبط.`;

                    warning.removeClass('d-none');

                    warningText.text(message);

                    daysError.removeClass('d-none');

                    daysError.text(message);

                } else {

                    warning.addClass('d-none');

                    daysError.addClass('d-none');

                    daysError.text('');

                }


                /*
                |--------------------------------------------------------------------------
                | Period
                |--------------------------------------------------------------------------
                */

                if (!startValue) {

                    $('#preview-period').text('-');

                    $('#preview-total').text('0');

                    return;

                }


                const start =
                    new Date(startValue + 'T00:00:00');


                let end;

                if (endValue) {

                    end =
                        new Date(endValue + 'T23:59:59');

                } else {

                    end =
                        new Date(start);

                    end.setMonth(
                        end.getMonth() + 3
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Display Period
                |--------------------------------------------------------------------------
                */

                const formatDate =
                    function (date) {

                        const year =
                            date.getFullYear();

                        const month =
                            String(
                                date.getMonth() + 1
                            ).padStart(2, '0');

                        const day =
                            String(
                                date.getDate()
                            ).padStart(2, '0');

                        return `${year}-${month}-${day}`;
                    };


                $('#preview-period').text(
                    `${formatDate(start)} → ${formatDate(end)}`
                );


                /*
                |--------------------------------------------------------------------------
                | Calculate Sessions
                |--------------------------------------------------------------------------
                */

                if (
                    frequency <= 0 ||
                    selectedDays !== frequency
                ) {

                    $('#preview-total').text('0');

                    return;

                }


                const dayMap = {

                    sunday: 0,
                    monday: 1,
                    tuesday: 2,
                    wednesday: 3,
                    thursday: 4,
                    friday: 5,
                    saturday: 6

                };


                const selectedDayNumbers =
                    [];


                dayCheckboxes
                    .filter(':checked')
                    .each(function () {

                        const value =
                            $(this).val();

                        if (
                            dayMap[value] !== undefined
                        ) {

                            selectedDayNumbers.push(
                                dayMap[value]
                            );

                        }

                    });


                let total = 0;

                const cursor =
                    new Date(start);


                while (cursor <= end) {

                    if (
                        selectedDayNumbers.includes(
                            cursor.getDay()
                        )
                    ) {

                        total++;

                    }

                    cursor.setDate(
                        cursor.getDate() + 1
                    );

                }


                $('#preview-total').text(total);

            }


            /*
            |--------------------------------------------------------------------------
            | Events
            |--------------------------------------------------------------------------
            */

            startDate.on(
                'change input',
                updatePreview
            );

            endDate.on(
                'change input',
                updatePreview
            );

            sessionTime.on(
                'change input',
                updatePreview
            );

            sessionsPerWeek.on(
                'change',
                updatePreview
            );

            dayCheckboxes.on(
                'change',
                updatePreview
            );


            /*
            |--------------------------------------------------------------------------
            | Submit Validation
            |--------------------------------------------------------------------------
            */

            form.on('submit', function (event) {

                const frequency =
                    parseInt(sessionsPerWeek.val()) || 0;

                const selectedDays =
                    dayCheckboxes.filter(':checked').length;


                /*
                |--------------------------------------------------------------------------
                | Validate Days
                |--------------------------------------------------------------------------
                */

                if (
                    frequency <= 0 ||
                    selectedDays !== frequency
                ) {

                    event.preventDefault();

                    const message =
                        frequency > 0
                            ? `يجب اختيار ${frequency} أيام بالضبط.`
                            : 'يرجى تحديد عدد الجلسات أسبوعيًا.';


                    $('#days-error')
                        .removeClass('d-none')
                        .text(message);


                    $('html, body').animate({
                        scrollTop:
                            $('#days-error').offset().top - 150
                    }, 300);


                    return false;

                }


                /*
                |--------------------------------------------------------------------------
                | Disable Submit
                |--------------------------------------------------------------------------
                */

                submitButton
                    .attr('disabled', true);

                submitButton.html(`

                <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                ></span>

                جاري إنشاء الجلسات...

            `);

            });


            /*
            |--------------------------------------------------------------------------
            | Initial Preview
            |--------------------------------------------------------------------------
            */

            updatePreview();


            /*
            |--------------------------------------------------------------------------
            | Restore Patient After Validation Error
            |--------------------------------------------------------------------------
            */

            @if(old('patient_id'))

            patientSelect
                .val('{{ old('patient_id') }}')
                .trigger('change');

            @endif

        });

    </script>

@endpush

