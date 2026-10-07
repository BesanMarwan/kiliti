@extends('layouts.admin')

@section('title', lng('dashboard.dialysis_sessions.dialysis_sessions', 'جلسات الغسيل'))

@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard', 'لوحة التحكم')">

        <x-header.breadcrumb-item
            :href="route('system.dialysis_sessions.index')"
            :name="lng('dashboard.dialysis_sessions.dialysis_sessions', 'جلسات الغسيل')"
        />

        <x-header.breadcrumb-item
            :name="lng('dashboard.dialysis_sessions.create_session', 'إنشاء جدول جلسات الغسيل')"
        />

    </x-header.title>

@endsection
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard', 'لوحة التحكم')">

        <x-header.breadcrumb-item
            :href="route('system.dialysis_sessions.index')"
            :name="lng('dashboard.dialysis_sessions.dialysis_sessions', 'جلسات الغسيل')"
        />

        <x-header.breadcrumb-item
            :name="lng('dashboard.dialysis_sessions.create_session', 'إنشاء جدول جلسات الغسيل')"
        />

    </x-header.title>
@endsection

@push('css')
    <style>
        .patient-treatment-card {
            transition: all 0.2s ease;
        }

        .patient-treatment-card.disabled {
            opacity: 0.6;
        }

        .session-day-card {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .session-day-card:hover {
            border-color: var(--bs-primary) !important;
        }

        .session-day-card:has(.form-check-input:checked) {
            border-color: var(--bs-primary) !important;
            background-color: var(--bs-light-primary);
        }

        .preview-session-count {
            font-size: 42px;
            line-height: 1;
        }
    </style>
@endpush

@section('content')

    <div class="d-flex flex-column flex-column-fluid">

        <div id="kt_app_content" class="app-content flex-column-fluid">

            <div
                id="kt_app_content_container"
                class="app-container container-fluid"
            >

                {{-- ======================================================== --}}
                {{-- Errors --}}
                {{-- ======================================================== --}}

                @if ($errors->any())

                    <div class="alert alert-danger d-flex align-items-start mb-8">

                        <i class="ki-duotone ki-information-5 fs-2tx text-danger me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>

                        <div>

                            <h4 class="text-danger fw-bold mb-2">
                                يرجى مراجعة البيانات
                            </h4>

                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                    </div>

                @endif


                {{-- ======================================================== --}}
                {{-- Form --}}
                {{-- ======================================================== --}}

                <form
                    method="POST"
                    action="{{ route('system.dialysis_sessions.store') }}"
                    id="dialysis-session-form"
                >

                    @csrf

                    <div class="row g-5">

                        {{-- ================================================= --}}
                        {{-- Main --}}
                        {{-- ================================================= --}}

                        <div class="col-lg-8">

                            {{-- ================================================= --}}
                            {{-- Patient --}}
                            {{-- ================================================= --}}

                            <div class="card card-flush mb-5">

                                <div class="card-header">

                                    <div class="card-title">

                                        <div>

                                            <h2 class="fw-bold mb-1">
                                                اختيار المريض
                                            </h2>

                                            <div class="text-muted fs-7">
                                                اختر المريض لتحميل خطة العلاج الحالية.
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <div class="mb-3">

                                        <label class="required form-label">
                                            المريض
                                        </label>

                                        <select
                                            name="patient_id"
                                            id="patient_id"
                                            class="form-select @error('patient_id') is-invalid @enderror"
                                            data-control="select2"
                                            data-placeholder="اختر المريض"
                                            data-allow-clear="true"
                                        >

                                            <option value=""></option>

                                            @foreach($patients as $patient)

                                                <option
                                                    value="{{ $patient->id }}"

                                                    data-dialysis-type="{{ $patient->dialysis_type ?? '' }}"

                                                    data-start-date="{{ optional($patient->dialysis_start_date)->format('Y-m-d') }}"

                                                    data-end-date="{{ optional($patient->dialysis_end_date)->format('Y-m-d') }}"

                                                    data-sessions-per-week="{{ $patient->sessions_per_week ?? '' }}"

                                                    data-center="{{ $patient->centers->first()->name ?? '-' }}"

                                                    data-doctor="{{ $patient->doctors->first()->user->name ?? '-' }}"

                                                    data-center-id="{{ $patient->centers->first()->id ?? '' }}"

                                                    data-doctor-id="{{ $patient->doctors->first()->id ?? '' }}"

                                                    @selected(old('patient_id') == $patient->id)
                                                >

                                                    {{ $patient->user->name ?? 'مريض #' . $patient->id }}

                                                </option>

                                            @endforeach

                                        </select>

                                        @error('patient_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>

                                    <div class="text-muted fs-7">

                                        <i class="ki-duotone ki-information-5 fs-5 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>

                                        سيتم تحميل نوع الغسيل والمركز والطبيب وبيانات العلاج من ملف المريض.

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- Hidden Patient Data --}}
                            {{-- ================================================= --}}

                            <input
                                type="hidden"
                                name="center_id"
                                id="center_id"
                                value="{{ old('center_id') }}"
                            >

                            <input
                                type="hidden"
                                name="doctor_id"
                                id="doctor_id"
                                value="{{ old('doctor_id') }}"
                            >

                            <input
                                type="hidden"
                                name="session_type"
                                id="session_type"
                                value="{{ old('session_type') }}"
                            >


                            {{-- ================================================= --}}
                            {{-- Patient Treatment --}}
                            {{-- ================================================= --}}

                            <div
                                class="card card-flush mb-5 patient-treatment-card disabled"
                                id="patient-treatment-card"
                            >

                                <div class="card-header">

                                    <div class="card-title">

                                        <div>

                                            <h2 class="fw-bold mb-1">
                                                خطة العلاج
                                            </h2>

                                            <div class="text-muted fs-7">
                                                بيانات مرتبطة بالمريض.
                                            </div>

                                        </div>

                                    </div>

                                    <div class="card-toolbar">

                                        <span
                                            class="badge badge-light"
                                            id="patient-data-status"
                                        >
                                            بانتظار اختيار المريض
                                        </span>

                                    </div>

                                </div>

                                <div class="card-body">

                                    {{-- ================================================= --}}
                                    {{-- Patient Medical Information --}}
                                    {{-- ================================================= --}}

                                    <div class="mb-10">

                                        <div class="row g-4">

                                            {{-- Dialysis Type --}}
                                            <div class="col-md-4">

                                                <div class="border border-gray-300 border-dashed rounded p-5 h-100">

                                                    <div class="text-muted fs-7 mb-2">
                                                        نوع الغسيل
                                                    </div>

                                                    <div
                                                        class="fw-bold fs-5"
                                                        id="patient-dialysis-type"
                                                    >
                                                        -
                                                    </div>

                                                </div>

                                            </div>


                                            {{-- Center --}}
                                            <div class="col-md-4">

                                                <div class="border border-gray-300 border-dashed rounded p-5 h-100">

                                                    <div class="text-muted fs-7 mb-2">
                                                        مركز الغسيل
                                                    </div>

                                                    <div
                                                        class="fw-bold fs-5"
                                                        id="patient-center"
                                                    >
                                                        -
                                                    </div>

                                                </div>

                                            </div>


                                            {{-- Doctor --}}
                                            <div class="col-md-4">

                                                <div class="border border-gray-300 border-dashed rounded p-5 h-100">

                                                    <div class="text-muted fs-7 mb-2">
                                                        الطبيب المسؤول
                                                    </div>

                                                    <div
                                                        class="fw-bold fs-5"
                                                        id="patient-doctor"
                                                    >
                                                        -
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- ================================================= --}}
                                    {{-- Dates --}}
                                    {{-- ================================================= --}}

                                    <div class="row">

                                        {{-- Start Date --}}
                                        <div class="col-md-6 mb-8">

                                            <label class="required form-label">
                                                تاريخ بداية الجدول
                                            </label>

                                            <input
                                                type="date"
                                                name="start_date"
                                                id="start_date"
                                                value="{{ old('start_date') }}"
                                                class="form-control @error('start_date') is-invalid @enderror"
                                            >

                                            @error('start_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                            <div class="form-text">
                                                يتم تعبئته من تاريخ بداية غسيل المريض ويمكن تعديله.
                                            </div>

                                        </div>


                                        {{-- End Date --}}
                                        <div class="col-md-6 mb-8">

                                            <label class="form-label">
                                                تاريخ نهاية الجدول
                                            </label>

                                            <input
                                                type="date"
                                                name="end_date"
                                                id="end_date"
                                                value="{{ old('end_date') }}"
                                                class="form-control @error('end_date') is-invalid @enderror"
                                            >

                                            @error('end_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                            <div class="form-text">
                                                اختياري، وإذا ترك فارغًا سيتم إنشاء الجدول لمدة 3 أشهر.
                                            </div>

                                        </div>

                                    </div>


                                    {{-- ================================================= --}}
                                    {{-- Sessions Per Week --}}
                                    {{-- ================================================= --}}

                                    <div class="mb-5">

                                        <label class="required form-label">
                                            عدد الجلسات أسبوعيًا
                                        </label>

                                        <select
                                            name="sessions_per_week"
                                            id="sessions_per_week"
                                            class="form-select @error('sessions_per_week') is-invalid @enderror"
                                            data-control="select2"
                                            data-placeholder="اختر عدد الجلسات"
                                        >

                                            <option value="">
                                                اختر العدد
                                            </option>

                                            @for($i = 1; $i <= 7; $i++)

                                                <option
                                                    value="{{ $i }}"
                                                    @selected(old('sessions_per_week') == $i)
                                                >
                                                    {{ $i }} جلسات أسبوعيًا
                                                </option>

                                            @endfor

                                        </select>

                                        @error('sessions_per_week')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- Schedule --}}
                            {{-- ================================================= --}}

                            <div class="card card-flush mb-5">

                                <div class="card-header">

                                    <div class="card-title">

                                        <div>

                                            <h2 class="fw-bold mb-1">
                                                إعداد جدول الجلسات
                                            </h2>

                                            <div class="text-muted fs-7">
                                                حدد الأيام والوقت الذي ستتكرر فيه جلسات المريض.
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <div class="card-body">

                                    {{-- ================================================= --}}
                                    {{-- Days --}}
                                    {{-- ================================================= --}}

                                    <div class="mb-10">

                                        <div class="d-flex align-items-center justify-content-between mb-4">

                                            <div>

                                                <label class="required form-label mb-1">
                                                    أيام الجلسات
                                                </label>

                                                <div class="text-muted fs-7">
                                                    يجب اختيار عدد أيام يساوي عدد الجلسات أسبوعيًا.
                                                </div>

                                            </div>

                                            <span
                                                class="badge badge-light"
                                                id="days-counter"
                                            >
                                                0 / 0
                                            </span>

                                        </div>


                                        @php

                                            $days = [
                                                'saturday' => 'السبت',
                                                'sunday' => 'الأحد',
                                                'monday' => 'الاثنين',
                                                'tuesday' => 'الثلاثاء',
                                                'wednesday' => 'الأربعاء',
                                                'thursday' => 'الخميس',
                                                'friday' => 'الجمعة',
                                            ];

                                        @endphp


                                        <div class="row g-3">

                                            @foreach($days as $value => $label)

                                                <div class="col-6 col-md-3">

                                                    <label class="form-check form-check-custom form-check-solid border border-gray-300 rounded p-4 w-100 session-day-card">

                                                        <input
                                                            class="form-check-input dialysis-day"
                                                            type="checkbox"
                                                            name="days[]"
                                                            value="{{ $value }}"
                                                            @checked(in_array($value, old('days', [])))
                                                        >

                                                        <span class="form-check-label fw-semibold ms-3">
                                                            {{ $label }}
                                                        </span>

                                                    </label>

                                                </div>

                                            @endforeach

                                        </div>


                                        <div
                                            id="days-error"
                                            class="text-danger mt-3 d-none"
                                        ></div>


                                        @error('days')
                                        <div class="text-danger mt-3">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>


                                    {{-- ================================================= --}}
                                    {{-- Time --}}
                                    {{-- ================================================= --}}

                                    <div>

                                        <label class="required form-label">
                                            وقت الجلسة
                                        </label>

                                        <input
                                            type="time"
                                            name="time"
                                            id="session_time"
                                            value="{{ old('time', '08:00') }}"
                                            class="form-control @error('time') is-invalid @enderror"
                                        >

                                        @error('time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="form-text">
                                            سيتم إنشاء جميع الجلسات في الوقت المحدد.
                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- Submit --}}
                            {{-- ================================================= --}}

                            <div class="card card-flush">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">

                                        <div>

                                            <div class="fw-bold fs-5">
                                                إنشاء جدول الجلسات
                                            </div>

                                            <div class="text-muted fs-7">
                                                سيتم إنشاء الجلسات الفعلية حسب البيانات المحددة.
                                            </div>

                                        </div>


                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            id="submit-btn"
                                        >

                                            <i class="ki-duotone ki-calendar-add fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>

                                            إنشاء الجلسات

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- Preview --}}
                        {{-- ================================================= --}}

                        <div class="col-lg-4">

                            <div
                                class="card card-flush sticky-top"
                                style="top: 100px;"
                            >

                                <div class="card-header">

                                    <div class="card-title">

                                        <h2 class="fw-bold">
                                            معاينة الجدول
                                        </h2>

                                    </div>

                                </div>


                                <div class="card-body">

                                    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-5 mb-8">

                                        <i class="ki-duotone ki-information-5 fs-2tx text-primary me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>

                                        <div class="fw-semibold">

                                            <div class="fs-7 text-gray-700">

                                                إذا لم يتم تحديد تاريخ نهاية،
                                                سيتم احتساب المدة لمدة 3 أشهر.

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Count --}}
                                    <div class="text-center mb-8">

                                        <div
                                            class="preview-session-count fw-bold text-primary"
                                            id="sessions-count"
                                        >
                                            0
                                        </div>

                                        <div class="text-muted fw-semibold mt-2">
                                            جلسة متوقعة
                                        </div>

                                    </div>


                                    <div class="separator mb-6"></div>


                                    {{-- Patient --}}
                                    <div class="d-flex flex-stack mb-5">

                                        <span class="text-muted">
                                            المريض
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-patient"
                                        >
                                            -
                                        </span>

                                    </div>


                                    {{-- Dialysis Type --}}
                                    <div class="d-flex flex-stack mb-5">

                                        <span class="text-muted">
                                            نوع الغسيل
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-session-type"
                                        >
                                            -
                                        </span>

                                    </div>


                                    {{-- Center --}}
                                    <div class="d-flex flex-stack mb-5">

                                        <span class="text-muted">
                                            المركز
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-center"
                                        >
                                            -
                                        </span>

                                    </div>


                                    {{-- Doctor --}}
                                    <div class="d-flex flex-stack mb-5">

                                        <span class="text-muted">
                                            الطبيب
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-doctor"
                                        >
                                            -
                                        </span>

                                    </div>


                                    {{-- Start --}}
                                    <div class="d-flex flex-stack mb-5">

                                        <span class="text-muted">
                                            البداية
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-start"
                                        >
                                            -
                                        </span>

                                    </div>


                                    {{-- End --}}
                                    <div class="d-flex flex-stack mb-5">

                                        <span class="text-muted">
                                            النهاية
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-end"
                                        >
                                            -
                                        </span>

                                    </div>


                                    {{-- Frequency --}}
                                    <div class="d-flex flex-stack mb-5">

                                        <span class="text-muted">
                                            الجلسات أسبوعيًا
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-frequency"
                                        >
                                            -
                                        </span>

                                    </div>


                                    {{-- Days --}}
                                    <div class="d-flex flex-stack mb-5">

                                        <span class="text-muted">
                                            الأيام
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-days"
                                        >
                                            -
                                        </span>

                                    </div>


                                    {{-- Time --}}
                                    <div class="d-flex flex-stack">

                                        <span class="text-muted">
                                            الوقت
                                        </span>

                                        <span
                                            class="fw-bold text-end"
                                            id="preview-time"
                                        >
                                            -
                                        </span>

                                    </div>

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

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const patientSelect =
                document.getElementById('patient_id');

            const treatmentCard =
                document.getElementById('patient-treatment-card');

            const patientDataStatus =
                document.getElementById('patient-data-status');

            const patientDialysisType =
                document.getElementById('patient-dialysis-type');

            const patientCenter =
                document.getElementById('patient-center');

            const patientDoctor =
                document.getElementById('patient-doctor');

            const centerId =
                document.getElementById('center_id');

            const doctorId =
                document.getElementById('doctor_id');

            const sessionType =
                document.getElementById('session_type');

            const startDate =
                document.getElementById('start_date');

            const endDate =
                document.getElementById('end_date');

            const sessionsPerWeek =
                document.getElementById('sessions_per_week');

            const sessionTime =
                document.getElementById('session_time');

            const countElement =
                document.getElementById('sessions-count');

            const previewPatient =
                document.getElementById('preview-patient');

            const previewSessionType =
                document.getElementById('preview-session-type');

            const previewCenter =
                document.getElementById('preview-center');

            const previewDoctor =
                document.getElementById('preview-doctor');

            const previewStart =
                document.getElementById('preview-start');

            const previewEnd =
                document.getElementById('preview-end');

            const previewFrequency =
                document.getElementById('preview-frequency');

            const previewDays =
                document.getElementById('preview-days');

            const previewTime =
                document.getElementById('preview-time');

            const daysCounter =
                document.getElementById('days-counter');

            const daysError =
                document.getElementById('days-error');


            /*
            |--------------------------------------------------------------------------
            | Labels
            |--------------------------------------------------------------------------
            */

            const dayLabels = {

                saturday: 'السبت',
                sunday: 'الأحد',
                monday: 'الاثنين',
                tuesday: 'الثلاثاء',
                wednesday: 'الأربعاء',
                thursday: 'الخميس',
                friday: 'الجمعة'

            };


            const sessionTypeLabels = {

                hemodialysis: 'غسيل دموي',
                peritoneal: 'غسيل بريتوني',
                other: 'أخرى'

            };


            /*
            |--------------------------------------------------------------------------
            | Get Selected Days
            |--------------------------------------------------------------------------
            */

            function getSelectedDays() {

                return Array.from(
                    document.querySelectorAll('.dialysis-day:checked')
                ).map(input => input.value);

            }


            /*
            |--------------------------------------------------------------------------
            | Parse Date
            |--------------------------------------------------------------------------
            */

            function parseDate(dateString) {

                if (!dateString) {
                    return null;
                }

                const parts =
                    dateString.split('-');

                if (parts.length !== 3) {
                    return null;
                }

                return new Date(
                    Date.UTC(
                        Number(parts[0]),
                        Number(parts[1]) - 1,
                        Number(parts[2])
                    )
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Format Date
            |--------------------------------------------------------------------------
            */

            function formatDate(dateString) {

                if (!dateString) {
                    return '-';
                }

                const date =
                    parseDate(dateString);

                if (!date) {
                    return '-';
                }

                return new Intl.DateTimeFormat('ar', {

                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'

                }).format(date);

            }


            /*
            |--------------------------------------------------------------------------
            | Enable Treatment Fields
            |--------------------------------------------------------------------------
            */

            function enableTreatmentFields(enabled) {

                treatmentCard.classList.toggle(
                    'disabled',
                    !enabled
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Update Select2
            |--------------------------------------------------------------------------
            */

            function updateSelect2(element) {

                if (
                    window.jQuery &&
                    $(element).hasClass('select2-hidden-accessible')
                ) {

                    $(element).trigger('change.select2');

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Clear Patient Information
            |--------------------------------------------------------------------------
            */

            function clearPatientInformation() {

                patientDialysisType.textContent = '-';

                patientCenter.textContent = '-';

                patientDoctor.textContent = '-';

                previewPatient.textContent = '-';

                previewSessionType.textContent = '-';

                previewCenter.textContent = '-';

                previewDoctor.textContent = '-';

                centerId.value = '';

                doctorId.value = '';

                sessionType.value = '';

            }


            /*
            |--------------------------------------------------------------------------
            | Load Patient
            |--------------------------------------------------------------------------
            */

            function loadPatientData() {

                const option =
                    patientSelect.options[
                        patientSelect.selectedIndex
                        ];


                /*
                |--------------------------------------------------------------------------
                | No Patient Selected
                |--------------------------------------------------------------------------
                */

                if (!option || !option.value) {

                    enableTreatmentFields(false);

                    patientDataStatus.textContent =
                        'بانتظار اختيار المريض';

                    patientDataStatus.className =
                        'badge badge-light';

                    startDate.value = '';

                    endDate.value = '';

                    sessionsPerWeek.value = '';

                    centerId.value = '';

                    doctorId.value = '';

                    sessionType.value = '';

                    updateSelect2(
                        sessionsPerWeek
                    );

                    clearPatientInformation();

                    updatePreview();

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Patient Data
                |--------------------------------------------------------------------------
                */

                const dialysisType =
                    option.dataset.dialysisType || '';

                const center =
                    option.dataset.center || '-';

                const doctor =
                    option.dataset.doctor || '-';

                const patientStartDate =
                    option.dataset.startDate || '';

                const patientEndDate =
                    option.dataset.endDate || '';

                const patientSessionsPerWeek =
                    option.dataset.sessionsPerWeek || '';

                const patientCenterId =
                    option.dataset.centerId || '';

                const patientDoctorId =
                    option.dataset.doctorId || '';


                /*
                |--------------------------------------------------------------------------
                | Set Hidden Form Values
                |--------------------------------------------------------------------------
                */

                centerId.value =
                    patientCenterId;

                doctorId.value =
                    patientDoctorId;

                sessionType.value =
                    dialysisType;


                /*
                |--------------------------------------------------------------------------
                | Enable Treatment
                |--------------------------------------------------------------------------
                */

                enableTreatmentFields(true);


                /*
                |--------------------------------------------------------------------------
                | Display Patient Data
                |--------------------------------------------------------------------------
                */

                patientDialysisType.textContent =
                    sessionTypeLabels[dialysisType] ||
                    dialysisType ||
                    '-';

                patientCenter.textContent =
                    center;

                patientDoctor.textContent =
                    doctor;


                /*
                |--------------------------------------------------------------------------
                | Fill Treatment Data
                |--------------------------------------------------------------------------
                */

                startDate.value =
                    startDate.value ||
                    patientStartDate;

                endDate.value =
                    endDate.value ||
                    patientEndDate;

                sessionsPerWeek.value =
                    sessionsPerWeek.value ||
                    patientSessionsPerWeek;


                updateSelect2(
                    sessionsPerWeek
                );


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                patientDataStatus.textContent =
                    'تم تحميل بيانات المريض';

                patientDataStatus.className =
                    'badge badge-light-success';


                /*
                |--------------------------------------------------------------------------
                | Update Preview
                |--------------------------------------------------------------------------
                */

                updatePreview();


                /*
                |--------------------------------------------------------------------------
                | Debug
                |--------------------------------------------------------------------------
                */

                console.log('Dialysis Session Data:', {

                    patient_id: patientSelect.value,

                    center_id: centerId.value,

                    doctor_id: doctorId.value,

                    session_type: sessionType.value,

                    start_date: startDate.value,

                    end_date: endDate.value,

                    sessions_per_week: sessionsPerWeek.value

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Calculate Sessions
            |--------------------------------------------------------------------------
            */

            function calculateSessions() {

                const start =
                    parseDate(startDate.value);

                if (!start) {

                    countElement.textContent =
                        '0';

                    return 0;

                }


                let end;


                /*
                |--------------------------------------------------------------------------
                | Empty End Date => 3 Months
                |--------------------------------------------------------------------------
                */

                if (endDate.value) {

                    end =
                        parseDate(
                            endDate.value
                        );

                } else {

                    end =
                        new Date(start);

                    end.setUTCMonth(
                        end.getUTCMonth() + 3
                    );

                }


                const selectedDays =
                    getSelectedDays();


                if (
                    !selectedDays.length ||
                    !end ||
                    end < start
                ) {

                    countElement.textContent =
                        '0';

                    return 0;

                }


                const dayMap = {

                    0: 'sunday',
                    1: 'monday',
                    2: 'tuesday',
                    3: 'wednesday',
                    4: 'thursday',
                    5: 'friday',
                    6: 'saturday'

                };


                let count = 0;

                const current =
                    new Date(start);


                while (current <= end) {

                    const dayName =
                        dayMap[current.getUTCDay()];


                    if (
                        selectedDays.includes(dayName)
                    ) {

                        count++;

                    }


                    current.setUTCDate(
                        current.getUTCDate() + 1
                    );

                }


                countElement.textContent =
                    count;


                return count;

            }


            /*
            |--------------------------------------------------------------------------
            | Validate Days
            |--------------------------------------------------------------------------
            */

            function validateDays() {

                const selectedDays =
                    getSelectedDays();

                const requiredDays =
                    parseInt(
                        sessionsPerWeek.value || 0
                    );


                daysCounter.textContent =
                    `${selectedDays.length} / ${requiredDays}`;


                if (!requiredDays) {

                    daysCounter.className =
                        'badge badge-light';

                    daysError.classList.add(
                        'd-none'
                    );

                    daysError.textContent = '';

                    return true;

                }


                if (
                    selectedDays.length ===
                    requiredDays
                ) {

                    daysCounter.className =
                        'badge badge-light-success';

                    daysError.classList.add(
                        'd-none'
                    );

                    daysError.textContent = '';

                    return true;

                }


                daysCounter.className =
                    'badge badge-light-danger';

                daysError.classList.remove(
                    'd-none'
                );

                daysError.textContent =
                    `يجب اختيار ${requiredDays} ${requiredDays === 1 ? 'يوم' : 'أيام'} للجلسات الأسبوعية.`;

                return false;

            }


            /*
            |--------------------------------------------------------------------------
            | Update Preview
            |--------------------------------------------------------------------------
            */

            function updatePreview() {

                const option =
                    patientSelect.options[
                        patientSelect.selectedIndex
                        ];


                const selectedDays =
                    getSelectedDays();


                /*
                |--------------------------------------------------------------------------
                | Patient
                |--------------------------------------------------------------------------
                */

                if (
                    option &&
                    option.value
                ) {

                    previewPatient.textContent =
                        option.textContent.trim();

                } else {

                    previewPatient.textContent =
                        '-';

                }


                /*
                |--------------------------------------------------------------------------
                | Medical Data
                |--------------------------------------------------------------------------
                */

                if (
                    option &&
                    option.value
                ) {

                    const dialysisType =
                        option.dataset.dialysisType || '';

                    const center =
                        option.dataset.center || '-';

                    const doctor =
                        option.dataset.doctor || '-';


                    previewSessionType.textContent =
                        sessionTypeLabels[dialysisType] ||
                        dialysisType ||
                        '-';

                    previewCenter.textContent =
                        center;

                    previewDoctor.textContent =
                        doctor;

                } else {

                    previewSessionType.textContent =
                        '-';

                    previewCenter.textContent =
                        '-';

                    previewDoctor.textContent =
                        '-';

                }


                /*
                |--------------------------------------------------------------------------
                | Dates
                |--------------------------------------------------------------------------
                */

                previewStart.textContent =
                    formatDate(
                        startDate.value
                    );


                previewEnd.textContent =
                    endDate.value
                        ? formatDate(endDate.value)
                        : 'بعد 3 أشهر';


                /*
                |--------------------------------------------------------------------------
                | Frequency
                |--------------------------------------------------------------------------
                */

                previewFrequency.textContent =
                    sessionsPerWeek.value
                        ? `${sessionsPerWeek.value} جلسات`
                        : '-';


                /*
                |--------------------------------------------------------------------------
                | Days
                |--------------------------------------------------------------------------
                */

                previewDays.textContent =
                    selectedDays.length
                        ? selectedDays
                            .map(day => dayLabels[day])
                            .join('، ')
                        : '-';


                /*
                |--------------------------------------------------------------------------
                | Time
                |--------------------------------------------------------------------------
                */

                previewTime.textContent =
                    sessionTime.value || '-';


                /*
                |--------------------------------------------------------------------------
                | Calculations
                |--------------------------------------------------------------------------
                */

                calculateSessions();

                validateDays();

            }


            /*
            |--------------------------------------------------------------------------
            | Patient Change
            |--------------------------------------------------------------------------
            */

            if (window.jQuery) {

                $('#patient_id').on(
                    'change',
                    loadPatientData
                );

            } else {

                patientSelect.addEventListener(
                    'change',
                    loadPatientData
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Treatment Events
            |--------------------------------------------------------------------------
            */

            [
                startDate,
                endDate,
                sessionsPerWeek,
                sessionTime
            ].forEach(element => {

                element.addEventListener(
                    'change',
                    updatePreview
                );

                element.addEventListener(
                    'input',
                    updatePreview
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Days Events
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll('.dialysis-day')
                .forEach(element => {

                    element.addEventListener(
                        'change',
                        updatePreview
                    );

                });


            /*
            |--------------------------------------------------------------------------
            | Submit Validation
            |--------------------------------------------------------------------------
            */

            document
                .getElementById('dialysis-session-form')
                .addEventListener('submit', function (event) {

                    const requiredDays =
                        parseInt(
                            sessionsPerWeek.value || 0
                        );

                    const selectedDays =
                        getSelectedDays();


                    /*
                    |--------------------------------------------------------------------------
                    | Patient
                    |--------------------------------------------------------------------------
                    */

                    if (!patientSelect.value) {

                        event.preventDefault();

                        patientSelect.focus();

                        return false;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Center
                    |--------------------------------------------------------------------------
                    */

                    if (!centerId.value) {

                        event.preventDefault();

                        alert(
                            'المريض المحدد لا يحتوي على مركز غسيل مرتبط.'
                        );

                        return false;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Doctor
                    |--------------------------------------------------------------------------
                    */

                    if (!doctorId.value) {

                        event.preventDefault();

                        alert(
                            'المريض المحدد لا يحتوي على طبيب مرتبط.'
                        );

                        return false;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Session Type
                    |--------------------------------------------------------------------------
                    */

                    if (!sessionType.value) {

                        event.preventDefault();

                        alert(
                            'نوع الغسيل غير موجود للمريض المحدد.'
                        );

                        return false;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Start Date
                    |--------------------------------------------------------------------------
                    */

                    if (!startDate.value) {

                        event.preventDefault();

                        startDate.focus();

                        return false;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Days
                    |--------------------------------------------------------------------------
                    */

                    if (
                        requiredDays &&
                        selectedDays.length !== requiredDays
                    ) {

                        event.preventDefault();

                        validateDays();

                        daysError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        return false;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | End Date
                    |--------------------------------------------------------------------------
                    */

                    if (
                        startDate.value &&
                        endDate.value &&
                        endDate.value < startDate.value
                    ) {

                        event.preventDefault();

                        endDate.focus();

                        return false;

                    }

                });


            /*
            |--------------------------------------------------------------------------
            | Initial State
            |--------------------------------------------------------------------------
            */

            enableTreatmentFields(
                !!patientSelect.value
            );


            /*
            |--------------------------------------------------------------------------
            | Restore Patient Data After Validation
            |--------------------------------------------------------------------------
            */

            if (patientSelect.value) {

                loadPatientData();

            } else {

                updatePreview();

            }

        });

    </script>

@endpush
