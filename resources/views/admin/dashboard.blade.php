@extends('layouts.admin')
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')"/>
@endsection

@push('css')

    <style>

        /* =========================================
           Dashboard Charts
        ========================================= */

        .dashboard-chart-card {
            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 16px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.035);

            overflow: hidden;

            transition: all .2s ease;
        }


        .dashboard-chart-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }


        /* Header */

        .dashboard-chart-header {
            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 15px;

            padding: 22px 24px 18px;

            border-bottom: 1px solid #f1f5f9;
        }


        .dashboard-chart-title {
            margin: 0 0 5px;

            font-size: 17px;

            font-weight: 750;

            color: #111827;
        }


        .dashboard-chart-subtitle {
            margin: 0;

            font-size: 12px;

            color: #64748b;
        }


        /* Badge */

        .dashboard-chart-badge {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            border-radius: 8px;

            font-size: 11px;

            font-weight: 600;

            white-space: nowrap;
        }


        .dashboard-chart-badge i {
            font-size: 11px;
        }


        .badge-blue {
            background: #eff6ff;

            color: #2563eb;
        }


        .badge-green {
            background: #f0fdf4;

            color: #16a34a;
        }


        /* Body */

        .dashboard-chart-body {
            padding: 20px 24px 24px;
        }


        .chart-container {
            position: relative;

            width: 100%;

            height: 300px;
        }


        .chart-doughnut-container {
            height: 300px;

            max-width: 400px;

            margin: 0 auto;
        }


        .chart-container canvas {
            width: 100% !important;

            height: 100% !important;
        }


        /* Responsive */

        @media (max-width: 768px) {

            .dashboard-chart-header {
                padding: 18px;
            }

            .dashboard-chart-body {
                padding: 15px;
            }

            .dashboard-chart-badge {
                display: none;
            }

            .chart-container {
                height: 260px;
            }

        }

    </style>
    <style>

        /* =========================================
           Dashboard Header
        ========================================= */

        .dashboard-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;

            padding: 24px 28px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }


        .dashboard-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 25px;
        }


        /* Breadcrumb */

        .dashboard-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;

            font-size: 12px;
            color: #94a3b8;
        }


        .dashboard-breadcrumb i {
            font-size: 10px;
        }


        .dashboard-breadcrumb i:first-child {
            color: #2563eb;
            font-size: 12px;
        }


        /* Title */

        .dashboard-title {
            font-size: 27px;
            font-weight: 800;

            color: #111827;

            line-height: 1.2;
        }


        /* Subtitle */

        .dashboard-subtitle {
            font-size: 13px;
            color: #64748b;
        }


        /* Date */

        .dashboard-date {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 10px 15px;

            background: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            min-width: 190px;
        }


        .dashboard-date-icon {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eff6ff;

            color: #2563eb;

            border-radius: 10px;

            font-size: 17px;
        }


        .dashboard-date-label {
            font-size: 11px;
            color: #94a3b8;

            margin-bottom: 3px;
        }


        .dashboard-date-value {
            font-size: 13px;
            font-weight: 700;

            color: #334155;

            white-space: nowrap;
        }


        /* =========================================
           Responsive
        ========================================= */

        @media (max-width: 768px) {

            .dashboard-header {
                padding: 20px;
            }

            .dashboard-header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .dashboard-date {
                width: 100%;
            }

            .dashboard-title {
                font-size: 23px;
            }

        }

    </style>

    <style>

        /* ========================================
           Statistics Cards
        ======================================== */

        .stat-card {
            position: relative;
            min-height: 155px;
            border-radius: 16px;
            padding: 24px;
            overflow: hidden;
            color: #ffffff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }


        .stat-card-content {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            justify-content: space-between;

            height: 100%;
            gap: 20px;
        }


        /* ========================================
           Text
        ======================================== */

        .stat-card-title {
            font-size: 15px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 8px;
        }

        .stat-card-number {
            font-size: 34px;
            line-height: 1.1;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .stat-card-description {
            font-size: 12px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.75);
        }


        /* ========================================
           Icon
        ======================================== */

        .stat-card-icon {
            flex-shrink: 0;

            width: 72px;
            height: 72px;

            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, 0.20);

            border: 1px solid rgba(255, 255, 255, 0.25);

            color: #ffffff;

            font-size: 32px;

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .stat-card-icon i {
            color: #ffffff !important;
            font-size: 32px !important;
            line-height: 1;
        }


        /* ========================================
           Decorative Circle
        ======================================== */

        .stat-card::before {
            content: "";

            position: absolute;

            width: 160px;
            height: 160px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.08);

            top: -80px;
            right: -50px;
        }

        .stat-card::after {
            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.05);

            bottom: -55px;
            left: -30px;
        }


        /* ========================================
           Colors
        ======================================== */

        .stat-card-primary {
            background: linear-gradient(
                135deg,
                #2563eb 0%,
                #1d4ed8 100%
            );
        }

        .stat-card-success {
            background: linear-gradient(
                135deg,
                #16a34a 0%,
                #15803d 100%
            );
        }

        .stat-card-info {
            background: linear-gradient(
                135deg,
                #0891b2 0%,
                #0e7490 100%
            );
        }

        .stat-card-warning {
            background: linear-gradient(
                135deg,
                #f59e0b 0%,
                #d97706 100%
            );
        }

        .stat-card-danger {
            background: linear-gradient(
                135deg,
                #ef4444 0%,
                #dc2626 100%
            );
        }

        .stat-card-purple {
            background: linear-gradient(
                135deg,
                #7c3aed 0%,
                #6d28d9 100%
            );
        }

        .stat-card-orange {
            background: linear-gradient(
                135deg,
                #f97316 0%,
                #ea580c 100%
            );
        }


        /* ========================================
           Responsive
        ======================================== */

        @media (max-width: 768px) {

            .stat-card {
                min-height: 140px;
                padding: 20px;
            }

            .stat-card-number {
                font-size: 28px;
            }

            .stat-card-icon {
                width: 60px;
                height: 60px;
                font-size: 26px;
            }

            .stat-card-icon i {
                font-size: 26px !important;
            }

        }

        /* ========================================
           Today's Summary
        ======================================== */

        .today-summary-card {
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
        }


        /* Header */

        .today-date {
            display: flex;
            align-items: center;
            gap: 7px;

            padding: 8px 14px;

            border-radius: 8px;

            background: #f8fafc;

            color: #64748b;

            font-size: 13px;
            font-weight: 600;
        }

        .today-date i {
            font-size: 14px;
        }


        /* ========================================
           Statistic Item
        ======================================== */

        .today-stat {
            position: relative;

            display: flex;
            align-items: center;

            gap: 14px;

            min-height: 95px;

            padding: 16px;

            border-radius: 13px;

            overflow: hidden;

            transition: all .2s ease;
        }

        .today-stat:hover {
            transform: translateY(-3px);
        }


        /* Icon */

        .today-stat-icon {
            flex-shrink: 0;

            width: 50px;
            height: 50px;

            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 21px;
        }


        .today-stat-icon i {
            font-size: 21px !important;
        }


        /* Content */

        .today-stat-number {
            font-size: 24px;

            line-height: 1.1;

            font-weight: 800;

            margin-bottom: 4px;
        }



        /* ========================================
           Blue
        ======================================== */


        .today-stat-blue .today-stat-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        .today-stat-blue .today-stat-number {
            color: #1d4ed8;
        }


        /* ========================================
           Cyan
        ======================================== */

        .today-stat-cyan .today-stat-icon {
            background: #cffafe;
            color: #0891b2;
        }

        .today-stat-cyan .today-stat-number {
            color: #0e7490;
        }


        /* ========================================
           Green
        ======================================== */

        .today-stat-green {
            background: #f0fdf4;
        }

        .today-stat-green .today-stat-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .today-stat-green .today-stat-number {
            color: #15803d;
        }


        /* ========================================
           Red
        ======================================== */

        .today-stat-red {
            background: #fef2f2;
        }

        .today-stat-red .today-stat-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .today-stat-red .today-stat-number {
            color: #b91c1c;
        }


        /* ========================================
           Orange
        ======================================== */

        .today-stat-orange {
            background: #fff7ed;
        }

        .today-stat-orange .today-stat-icon {
            background: #ffedd5;
            color: #ea580c;
        }

        .today-stat-orange .today-stat-number {
            color: #c2410c;
        }


        /* ========================================
           Purple
        ======================================== */

        .today-stat-purple {
            background: #faf5ff;
        }

        .today-stat-purple .today-stat-icon {
            background: #f3e8ff;
            color: #9333ea;
        }

        .today-stat-purple .today-stat-number {
            color: #7e22ce;
        }


        /* ========================================
           Mobile
        ======================================== */

        @media (max-width: 768px) {

            .today-date {
                display: none;
            }

            .today-stat {
                padding: 13px;
                gap: 10px;
            }

            .today-stat-icon {
                width: 43px;
                height: 43px;
            }

            .today-stat-number {
                font-size: 21px;
            }

            .today-stat-title {
                font-size: 11px;
            }

        }

        .today-overview-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }


        .today-overview-title {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
        }


        .today-overview-subtitle {
            font-size: 13px;
            color: #6b7280;
        }


        .today-overview-date {
            display: flex;
            align-items: center;
            gap: 7px;

            color: #64748b;

            font-size: 13px;
            font-weight: 600;
        }


        .today-overview-date i {
            font-size: 14px;
        }


        /* =========================================
           Statistics
        ========================================= */

        .today-statistics {
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }


        .today-item {
            min-height: 70px;

            display: flex;
            align-items: center;

            padding: 5px 20px;

            border-left: 1px solid #f1f5f9;

            transition: all .2s ease;
        }


        /* Remove border from last item */

        .today-statistics > div:last-child .today-item {
            border-left: none;
        }


        .today-item:hover {
            transform: translateY(-2px);
        }


        /* =========================================
           Icon
        ========================================= */

        .today-item-icon {
            width: 46px;
            height: 46px;

            min-width: 46px;

            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 19px;

            margin-left: 12px;
        }


        .today-item-icon i {
            font-size: 19px !important;
        }


        /* =========================================
           Number
        ========================================= */

        .today-item-number {
            font-size: 23px;
            line-height: 1;

            font-weight: 800;

            color: #111827;

            margin-bottom: 6px;
        }


        .today-item-label {
            font-size: 12px;

            color: #6b7280;

            white-space: nowrap;
        }


        /* =========================================
           Icon Colors
        ========================================= */

        .today-blue {
            background: #eff6ff;
            color: #2563eb;
        }


        .today-cyan {
            background: #ecfeff;
            color: #0891b2;
        }


        .today-green {
            background: #f0fdf4;
            color: #16a34a;
        }


        .today-red {
            background: #fef2f2;
            color: #dc2626;
        }


        .today-orange {
            background: #fff7ed;
            color: #ea580c;
        }


        .today-purple {
            background: #faf5ff;
            color: #9333ea;
        }


        /* =========================================
           Responsive
        ========================================= */

        @media (max-width: 1200px) {

            .today-item {
                padding: 15px;
                border-left: none;
            }

        }


        @media (max-width: 768px) {

            .today-overview-date {
                display: none;
            }

            .today-statistics {
                padding-top: 10px;
            }

            .today-item {
                padding: 12px 8px;
            }

            .today-item-icon {
                width: 42px;
                height: 42px;
                min-width: 42px;

                margin-left: 9px;
            }

            .today-item-number {
                font-size: 20px;
            }

            .today-item-label {
                font-size: 11px;
            }

        }


    </style>

@endpush

@section('content')


    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="dashboard-header mb-4">

            <div class="dashboard-header-content">

                <div>
                    <div class="dashboard-breadcrumb mb-2">
                        <i class="fa fa-home"></i>
                        <span>الرئيسية</span>
                        <i class="fa fa-angle-left"></i>
                        <span>لوحة التحكم</span>
                    </div>

                    <h1 class="dashboard-title mb-2">
                        لوحة التحكم
                    </h1>

                    <p class="dashboard-subtitle mb-0">
                        نظرة شاملة على المرضى، الأطباء، مراكز الغسيل، والمتابعة اليومية
                    </p>
                </div>


                <div class="dashboard-date">

                    <div class="dashboard-date-icon">
                        <i class="fa fa-calendar"></i>
                    </div>

                    <div>
                        <div class="dashboard-date-label">
                            تاريخ اليوم
                        </div>

                        <div class="dashboard-date-value">
                            {{ now()->translatedFormat('l، d F Y') }}
                        </div>
                    </div>

                </div>

            </div>

        </div>
        {{-- =========================
            Statistics Cards
         ========================== --}}
        <div class="row g-4 mb-5">

            {{-- إجمالي المرضى --}}
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-primary">

                    <div class="stat-card-content">
                        <div>
                            <div class="stat-card-title">
                                إجمالي المرضى
                            </div>

                            <div class="stat-card-number">
                                {{ number_format($totalPatients) }}
                            </div>

                            <div class="stat-card-description">
                                جميع المرضى المسجلين
                            </div>
                        </div>

                        <div class="stat-card-icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>

                </div>
            </div>


            {{-- الأطباء --}}
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-success">

                    <div class="stat-card-content">
                        <div>
                            <div class="stat-card-title">
                                الأطباء
                            </div>

                            <div class="stat-card-number">
                                {{ number_format($totalDoctors) }}
                            </div>

                            <div class="stat-card-description">
                                الأطباء المسجلون
                            </div>
                        </div>

                        <div class="stat-card-icon">
                            <i class="fa fa-user-md"></i>
                        </div>
                    </div>

                </div>
            </div>


            {{-- مراكز الغسيل --}}
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-info">

                    <div class="stat-card-content">
                        <div>
                            <div class="stat-card-title">
                                مراكز الغسيل
                            </div>

                            <div class="stat-card-number">
                                {{ number_format($totalCenters) }}
                            </div>

                            <div class="stat-card-description">
                                مراكز غسيل الكلى
                            </div>
                        </div>

                        <div class="stat-card-icon">
                            <i class="fa fa-hospital-o"></i>
                        </div>
                    </div>

                </div>
            </div>


            {{-- الأدوية --}}
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-warning">

                    <div class="stat-card-content">
                        <div>
                            <div class="stat-card-title">
                                الأدوية
                            </div>

                            <div class="stat-card-number">
                                {{ number_format($totalMedications) }}
                            </div>

                            <div class="stat-card-description">
                                أدوية المرضى
                            </div>
                        </div>

                        <div class="stat-card-icon">
                            <i class="fa fa-medkit"></i>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        {{-- =========================
            Secondary Statistics
        ========================== --}}
        <div class="row g-4 mb-5">

            {{-- المرضى النشطون --}}
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-success">

                    <div class="stat-card-content">

                        <div>
                            <div class="stat-card-title">
                                المرضى النشطون
                            </div>

                            <div class="stat-card-number">
                                {{ number_format($activePatients) }}
                            </div>

                            <div class="stat-card-description">
                                حسابات نشطة
                            </div>
                        </div>

                        <div class="stat-card-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>

                    </div>

                </div>
            </div>


            {{-- المرضى غير النشطين --}}
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-danger">

                    <div class="stat-card-content">

                        <div>
                            <div class="stat-card-title">
                                المرضى غير النشطين
                            </div>

                            <div class="stat-card-number">
                                {{ number_format($inactivePatients) }}
                            </div>

                            <div class="stat-card-description">
                                حسابات غير نشطة
                            </div>
                        </div>

                        <div class="stat-card-icon">
                            <i class="fa fa-user-times"></i>
                        </div>

                    </div>

                </div>
            </div>


            {{-- جلسات الغسيل --}}
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-purple">

                    <div class="stat-card-content">

                        <div>
                            <div class="stat-card-title">
                                جلسات الغسيل
                            </div>

                            <div class="stat-card-number">
                                {{ number_format($totalDialysisSessions) }}
                            </div>

                            <div class="stat-card-description">
                                إجمالي الجلسات
                            </div>
                        </div>

                        <div class="stat-card-icon">
                            <i class="fa fa-calendar"></i>
                        </div>

                    </div>

                </div>
            </div>


            {{-- الإشعارات --}}
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-orange">

                    <div class="stat-card-content">

                        <div>
                            <div class="stat-card-title">
                                الإشعارات
                            </div>

                            <div class="stat-card-number">
                                {{ number_format($totalNotifications) }}
                            </div>

                            <div class="stat-card-description">
                                إجمالي الإشعارات
                            </div>
                        </div>

                        <div class="stat-card-icon">
                            <i class="fa fa-bell"></i>
                        </div>

                    </div>

                </div>
            </div>

        </div>



        {{-- =========================
      Today's Overview
  ========================== --}}
        {{-- =========================
       Today's Overview
   ========================== --}}
        <div class="card today-overview-card mb-5">

            <div class="card-body p-4">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h4 class="today-overview-title mb-1">
                            ملخص اليوم
                        </h4>

                        <p class="today-overview-subtitle mb-0">
                            نظرة سريعة على نشاط المنصة اليوم
                        </p>
                    </div>

                    <div class="today-overview-date">
                        <i class="fa fa-calendar"></i>
                        {{ now()->format('d/m/Y') }}
                    </div>

                </div>


                {{-- Statistics --}}
                <div class="row g-0 today-statistics">


                    {{-- جلسات الغسيل --}}
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="today-item">

                            <div class="today-item-icon today-blue">
                                <i class="fa fa-calendar"></i>
                            </div>

                            <div class="today-item-info">

                                <div class="today-item-number">
                                    {{ number_format($todayDialysisSessions) }}
                                </div>

                                <div class="today-item-label">
                                    جلسات الغسيل
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- الجرعات المجدولة --}}
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="today-item">

                            <div class="today-item-icon today-cyan">
                                <i class="fa fa-medkit"></i>
                            </div>

                            <div class="today-item-info">

                                <div class="today-item-number">
                                    {{ number_format($todayScheduledMedications) }}
                                </div>

                                <div class="today-item-label">
                                    جرعات مجدولة
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- الجرعات المأخوذة --}}
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="today-item">

                            <div class="today-item-icon today-green">
                                <i class="fa fa-check"></i>
                            </div>

                            <div class="today-item-info">

                                <div class="today-item-number">
                                    {{ number_format($todayMedicationTaken) }}
                                </div>

                                <div class="today-item-label">
                                    جرعات مأخوذة
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- الجرعات الفائتة --}}
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="today-item">

                            <div class="today-item-icon today-red">
                                <i class="fa fa-times"></i>
                            </div>

                            <div class="today-item-info">

                                <div class="today-item-number">
                                    {{ number_format($todayMedicationMissed) }}
                                </div>

                                <div class="today-item-label">
                                    جرعات فائتة
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- تنبيهات السوائل --}}
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="today-item">

                            <div class="today-item-icon today-orange">
                                <i class="fa fa-tint"></i>
                            </div>

                            <div class="today-item-info">

                                <div class="today-item-number">
                                    {{ number_format($todayFluidAlerts) }}
                                </div>

                                <div class="today-item-label">
                                    تنبيهات السوائل
                                </div>

                            </div>

                        </div>
                    </div>


                    {{-- الأعراض --}}
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="today-item">

                            <div class="today-item-icon today-purple">
                                <i class="fa fa-heartbeat"></i>
                            </div>

                            <div class="today-item-info">

                                <div class="today-item-number">
                                    {{ number_format($todaySymptoms) }}
                                </div>

                                <div class="today-item-label">
                                    أعراض مسجلة
                                </div>

                            </div>

                        </div>
                    </div>


                </div>

            </div>

        </div>


        {{-- =========================
            Charts
        ========================== --}}
        <div class="row g-4 mb-5">
            {{-- =========================
                Charts Row 1
            ========================== --}}
            <div class="row g-4 mb-4">

                {{-- Patient Adherence --}}
                <div class="col-xl-6">

                    <div class="dashboard-chart-card h-100">

                        <div class="dashboard-chart-header">

                            <div>
                                <h4 class="dashboard-chart-title">
                                    التزام المرضى
                                </h4>

                                <p class="dashboard-chart-subtitle">
                                    متوسط مستوى الالتزام خلال آخر 7 أيام
                                </p>
                            </div>

                            <div class="dashboard-chart-badge badge-blue">
                                <i class="fa fa-line-chart"></i>
                                آخر 7 أيام
                            </div>

                        </div>


                        <div class="dashboard-chart-body">

                            <div class="chart-container">
                                <canvas id="adherenceChart"></canvas>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- Patient Status --}}
                <div class="col-xl-6">

                    <div class="dashboard-chart-card h-100">

                        <div class="dashboard-chart-header">

                            <div>
                                <h4 class="dashboard-chart-title">
                                    حالة المرضى
                                </h4>

                                <p class="dashboard-chart-subtitle">
                                    توزيع المرضى حسب حالة الحساب
                                </p>
                            </div>

                            <div class="dashboard-chart-badge badge-green">
                                <i class="fa fa-users"></i>
                                المرضى
                            </div>

                        </div>


                        <div class="dashboard-chart-body">

                            <div class="chart-container chart-doughnut-container">
                                <canvas id="patientStatusChart"></canvas>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
            {{-- Dialysis Sessions --}}
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h4 class="fw-bold mb-1">
                            جلسات الغسيل
                        </h4>

                        <p class="text-muted mb-0">
                            عدد جلسات الغسيل خلال آخر 7 أيام
                        </p>
                    </div>

                    <div class="card-body">
                        <div style="height: 320px;">
                            <canvas id="dialysisChart"></canvas>
                        </div>
                    </div>

                </div>
            </div>


            {{-- Medication --}}
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h4 class="fw-bold mb-1">
                            الالتزام بالأدوية
                        </h4>

                        <p class="text-muted mb-0">
                            حالة جرعات الأدوية
                        </p>
                    </div>

                    <div class="card-body">
                        <div style="height: 320px;">
                            <canvas id="medicationChart"></canvas>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        {{-- =========================
            Patients Needing Follow Up
        ========================== --}}
        <div class="card border-0 shadow-sm mb-5">

            <div class="card-header bg-white border-0 pt-4 px-4">

                <div>
                    <h4 class="fw-bold mb-1">
                        مرضى يحتاجون إلى متابعة
                    </h4>

                    <p class="text-muted mb-0">
                        المرضى الذين لديهم مؤشرات تستدعي المتابعة
                    </p>
                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="bg-light">
                        <tr>
                            <th class="px-4">المريض</th>
                            <th>الطبيب</th>
                            <th>المركز</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse($patientsNeedingFollowUp as $patient)

                            <tr>

                                <td class="px-4">

                                    <div class="d-flex align-items-center">

                                        <div class="avatar bg-primary-subtle text-primary">
                                            <i class="fa fa-user"></i>
                                        </div>

                                        <div class="ms-3">

                                            <div class="fw-bold">
                                                {{ $patient->user->name ?? 'غير معروف' }}
                                            </div>

                                            <div class="text-muted fs-7">
                                                {{ $patient->user->mobile ?? '-' }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                <td>
                                    @if($patient->doctors->first())
                                        {{ $patient->doctors->first()->user->name ?? 'غير محدد' }}
                                    @else
                                        <span class="text-muted">
                                            غير محدد
                                        </span>
                                    @endif
                                </td>


                                <td>
                                    @if($patient->centers->first())
                                        {{ $patient->centers->first()->name }}
                                    @else
                                        <span class="text-muted">
                                            غير محدد
                                        </span>
                                    @endif
                                </td>


                                <td>

                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                        يحتاج متابعة
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa fa-check-circle fa-2x mb-3 d-block text-success"></i>
                                    لا يوجد مرضى يحتاجون إلى متابعة حالياً
                                </td>
                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>




    {{-- =========================
        Chart.js
    ========================== --}}
    @push('js')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                if (typeof Chart === 'undefined') {
                    console.error('Chart.js لم يتم تحميله');
                    return;
                }


                // ==========================
                // Patient Adherence
                // ==========================

                const adherenceCanvas =
                    document.getElementById('adherenceChart');

                if (adherenceCanvas) {

                    new Chart(adherenceCanvas, {

                        type: 'line',

                        data: {
                            labels: @json($adherenceLabels),

                            datasets: [{
                                label: 'متوسط الالتزام',

                                data: @json($adherenceData),

                                borderWidth: 3,

                                tension: .4,

                                fill: true,

                                pointRadius: 4,

                                pointHoverRadius: 6
                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    display: false
                                }
                            },

                            scales: {

                                y: {
                                    beginAtZero: true,
                                    max: 100,

                                    ticks: {
                                        callback: function (value) {
                                            return value + '%';
                                        }
                                    }
                                }

                            }
                        }

                    });

                }


                // ==========================
                // Patient Status
                // ==========================

                const patientStatusCanvas =
                    document.getElementById('patientStatusChart');

                if (patientStatusCanvas) {

                    new Chart(patientStatusCanvas, {

                        type: 'doughnut',

                        data: {

                            labels: [
                                'نشط',
                                'غير نشط'
                            ],

                            datasets: [{

                                data: [
                                    {{ $patientStatus['active'] }},
                                    {{ $patientStatus['inactive'] }}
                                ],

                                borderWidth: 0
                            }]
                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            plugins: {

                                legend: {
                                    position: 'bottom'
                                }

                            }

                        }

                    });

                }


                // ==========================
                // Dialysis Sessions
                // ==========================

                const dialysisCanvas =
                    document.getElementById('dialysisChart');

                if (dialysisCanvas) {

                    new Chart(dialysisCanvas, {

                        type: 'bar',

                        data: {

                            labels: @json($dialysisLabels),

                            datasets: [{

                                label: 'جلسات الغسيل',

                                data: @json($dialysisData),

                                borderRadius: 6

                            }]

                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            plugins: {

                                legend: {
                                    display: false
                                }

                            },

                            scales: {

                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }

                            }

                        }

                    });

                }


                // ==========================
                // Medication
                // ==========================

                const medicationCanvas =
                    document.getElementById('medicationChart');

                if (medicationCanvas) {

                    new Chart(medicationCanvas, {

                        type: 'bar',

                        data: {

                            labels: [
                                'تم أخذها',
                                'فائتة',
                                'قادمة'
                            ],

                            datasets: [{

                                label: 'الجرعات',

                                data: [
                                    {{ $medicationTaken }},
                                    {{ $medicationMissed }},
                                    {{ $medicationUpcoming }}
                                ],

                                borderRadius: 6

                            }]

                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            plugins: {

                                legend: {
                                    display: false
                                }

                            },

                            scales: {

                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }

                            }

                        }

                    });

                }

            });

        </script>

    @endpush

@endsection
