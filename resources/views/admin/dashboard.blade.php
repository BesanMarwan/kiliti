@extends('layouts.admin')
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')"/>
@endsection
@section('content')
    <div class="row g-5 g-xl-8">

            <x-dashboard.chart1
                class="col-md-8"
                :title="lng('dashboard.general.orders_chart','توزيع الطلبات') "
                :description="lng('dashboard.general.orders_chart_desc','توزيع الطلبات اخر 6 اشهر') "
                :valuesname="lng('dashboard.general.orders_chart_valuesname','الطلبات حسب الشهر') "
                :formatter="lng('dashboard.general.orders_chart_formatter','طلب') "
                :values="array_values(['month1'=>20,'month2'=>30,'month3'=>10,'month4'=>50,'month5'=>34])"
                :axis="array_keys(['month1'=>20,'month2'=>30,'month3'=>10,'month4'=>50,'month5'=>34])"
            />



        <div class="col-xl-4">
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"> @lng('dashboard.general.users_chart','توزيع العملاء')
                        </span>
                        <span class="text-muted fw-bold fs-7">
                            @lng('dashboard.general.users_chart_desc','احصائية لعدد مستخدمين IOS و Android')

                        </span>
                    </h3>

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div id="chart" data-chart="{{json_encode($users_chart)}}">
                </div>
            </div>
        </div>

    </div>
    <div class="row g-5 g-xl-8">
        <div class="col-xl-4">
            <!--begin::Statistics Widget 1-->
            <div class="card bgi-no-repeat card-xl-stretch mb-xl-8" style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-4.svg)">
                <!--begin::Body-->
                <div class="card-body">
                    <a href="#" class="card-title fw-bolder text-muted text-hover-primary fs-4">Meeting Schedule</a>
                    <div class="fw-bolder text-primary my-6">3:30PM - 4:20PM</div>
                    <p class="text-dark-75 fw-bold fs-5 m-0">Create a headline that is informative
                        <br />and will capture readers</p>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Statistics Widget 1-->
        </div>
        <div class="col-xl-4">
            <!--begin::Statistics Widget 1-->
            <div class="card bgi-no-repeat card-xl-stretch mb-xl-8" style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-2.svg)">
                <!--begin::Body-->
                <div class="card-body">
                    <a href="#" class="card-title fw-bolder text-muted text-hover-primary fs-4">Meeting Schedule</a>
                    <div class="fw-bolder text-primary my-6">03 May 2020</div>
                    <p class="text-dark-75 fw-bold fs-5 m-0">Great blog posts don’t just happen Even the best bloggers need it</p>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Statistics Widget 1-->
        </div>
        <div class="col-xl-4">
            <!--begin::Statistics Widget 1-->
            <div class="card bgi-no-repeat card-xl-stretch mb-5 mb-xl-8" style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-1.svg)">
                <!--begin::Body-->
                <div class="card-body">
                    <a href="#" class="card-title fw-bolder text-muted text-hover-primary fs-4">UI Conference</a>
                    <div class="fw-bolder text-primary my-6">10AM Jan, 2021</div>
                    <p class="text-dark-75 fw-bold fs-5 m-0">AirWays - A Front-end solution for airlines build with ReactJS</p>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Statistics Widget 1-->
        </div>
    </div>
@endsection

@push('js')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        $(document).ready(function() {
            var data = $('#chart').data('chart');
            console.log(data);

            var options = {
                series: data.series,
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: '22px',
                            },
                            value: {
                                fontSize: '16px',
                            },
                            total: {
                                show: true,
                                label: "@lng('dashboard.general.all_users','اجمالي العملاء')",
                                formatter: function (w) {
                                    // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                    return data.total
                                }
                            }
                        }
                    }
                },
                labels: data.labels,
            };


            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>

@endpush



{{--    <!DOCTYPE html>--}}
{{--<html lang="ar" dir="rtl">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8" />--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0" />--}}
{{--    <title>لوحة التحكم</title>--}}

{{--    <style>--}}
{{--        * {--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            box-sizing: border-box;--}}
{{--            font-family: 'Cairo', sans-serif;--}}
{{--        }--}}

{{--        body {--}}
{{--            background: linear-gradient(to bottom left, #f8fbff, #eef5ff);--}}
{{--            display: flex;--}}
{{--            min-height: 100vh;--}}
{{--            color: #1e293b;--}}
{{--        }--}}

{{--        /* Sidebar */--}}
{{--        .sidebar {--}}
{{--            width: 280px;--}}
{{--            background: #fff;--}}
{{--            border-left: 1px solid #e2e8f0;--}}
{{--            display: flex;--}}
{{--            flex-direction: column;--}}
{{--            justify-content: space-between;--}}
{{--            box-shadow: 0 0 20px rgba(0,0,0,0.03);--}}
{{--        }--}}

{{--        .logo {--}}
{{--            padding: 25px;--}}
{{--            border-bottom: 1px solid #f1f5f9;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            gap: 15px;--}}
{{--        }--}}

{{--        .logo-icon {--}}
{{--            width: 55px;--}}
{{--            height: 55px;--}}
{{--            background: #dbeafe;--}}
{{--            color: #2563eb;--}}
{{--            border-radius: 18px;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            font-size: 24px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .logo h2 {--}}
{{--            font-size: 22px;--}}
{{--        }--}}

{{--        .menu {--}}
{{--            padding: 20px;--}}
{{--        }--}}

{{--        .menu-item {--}}
{{--            width: 100%;--}}
{{--            border: none;--}}
{{--            background: transparent;--}}
{{--            padding: 16px 18px;--}}
{{--            margin-bottom: 10px;--}}
{{--            border-radius: 18px;--}}
{{--            cursor: pointer;--}}
{{--            display: flex;--}}
{{--            justify-content: space-between;--}}
{{--            align-items: center;--}}
{{--            font-size: 16px;--}}
{{--            transition: 0.3s;--}}
{{--            color: #475569;--}}
{{--        }--}}

{{--        .menu-item:hover {--}}
{{--            background: #f1f5f9;--}}
{{--        }--}}

{{--        .menu-item.active {--}}
{{--            background: #eff6ff;--}}
{{--            color: #2563eb;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .sidebar-footer {--}}
{{--            padding: 20px;--}}
{{--            text-align: center;--}}
{{--            color: #94a3b8;--}}
{{--            font-size: 14px;--}}
{{--        }--}}

{{--        /* Main */--}}
{{--        .main {--}}
{{--            flex: 1;--}}
{{--            padding: 30px;--}}
{{--        }--}}

{{--        .hero {--}}
{{--            background: white;--}}
{{--            border-radius: 30px;--}}
{{--            padding: 40px;--}}
{{--            display: flex;--}}
{{--            justify-content: space-between;--}}
{{--            align-items: center;--}}
{{--            box-shadow: 0 10px 30px rgba(0,0,0,0.03);--}}
{{--            margin-bottom: 30px;--}}
{{--        }--}}

{{--        .hero h1 {--}}
{{--            font-size: 42px;--}}
{{--            margin-bottom: 10px;--}}
{{--        }--}}

{{--        .hero p {--}}
{{--            color: #64748b;--}}
{{--            font-size: 18px;--}}
{{--            margin-bottom: 25px;--}}
{{--        }--}}

{{--        .hero-boxes {--}}
{{--            display: flex;--}}
{{--            gap: 15px;--}}
{{--            flex-wrap: wrap;--}}
{{--        }--}}

{{--        .hero-card {--}}
{{--            background: #f8fafc;--}}
{{--            padding: 18px 22px;--}}
{{--            border-radius: 20px;--}}
{{--            min-width: 180px;--}}
{{--        }--}}

{{--        .hero-card small {--}}
{{--            color: #94a3b8;--}}
{{--        }--}}

{{--        .hero-card h3 {--}}
{{--            margin-top: 5px;--}}
{{--            color: #2563eb;--}}
{{--        }--}}

{{--        .hero-logo {--}}
{{--            width: 180px;--}}
{{--            height: 180px;--}}
{{--            border-radius: 50%;--}}
{{--            border: 10px solid #dbeafe;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            font-size: 60px;--}}
{{--            font-weight: bold;--}}
{{--            color: #2563eb;--}}
{{--            background: white;--}}
{{--        }--}}

{{--        /* Stats */--}}
{{--        .stats {--}}
{{--            display: grid;--}}
{{--            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));--}}
{{--            gap: 20px;--}}
{{--            margin-bottom: 40px;--}}
{{--        }--}}

{{--        .stat-card {--}}
{{--            background: white;--}}
{{--            border-radius: 25px;--}}
{{--            padding: 25px;--}}
{{--            box-shadow: 0 5px 20px rgba(0,0,0,0.03);--}}
{{--            transition: 0.3s;--}}
{{--        }--}}

{{--        .stat-card:hover {--}}
{{--            transform: translateY(-5px);--}}
{{--        }--}}

{{--        .stat-top {--}}
{{--            display: flex;--}}
{{--            justify-content: space-between;--}}
{{--            align-items: center;--}}
{{--            margin-bottom: 20px;--}}
{{--        }--}}

{{--        .stat-icon {--}}
{{--            width: 50px;--}}
{{--            height: 50px;--}}
{{--            border-radius: 18px;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            font-size: 22px;--}}
{{--        }--}}

{{--        .blue {--}}
{{--            background: #dbeafe;--}}
{{--            color: #2563eb;--}}
{{--        }--}}

{{--        .green {--}}
{{--            background: #dcfce7;--}}
{{--            color: #16a34a;--}}
{{--        }--}}

{{--        .yellow {--}}
{{--            background: #fef3c7;--}}
{{--            color: #d97706;--}}
{{--        }--}}

{{--        .purple {--}}
{{--            background: #f3e8ff;--}}
{{--            color: #9333ea;--}}
{{--        }--}}

{{--        .stat-value {--}}
{{--            font-size: 35px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        /* Cards */--}}
{{--        .section-title {--}}
{{--            font-size: 28px;--}}
{{--            margin-bottom: 25px;--}}
{{--        }--}}

{{--        .cards {--}}
{{--            display: grid;--}}
{{--            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));--}}
{{--            gap: 25px;--}}
{{--        }--}}

{{--        .card {--}}
{{--            background: white;--}}
{{--            border-radius: 30px;--}}
{{--            padding: 35px;--}}
{{--            text-align: center;--}}
{{--            box-shadow: 0 10px 25px rgba(0,0,0,0.03);--}}
{{--            transition: 0.3s;--}}
{{--        }--}}

{{--        .card:hover {--}}
{{--            transform: translateY(-8px);--}}
{{--            box-shadow: 0 20px 35px rgba(0,0,0,0.08);--}}
{{--        }--}}

{{--        .card-icon {--}}
{{--            width: 90px;--}}
{{--            height: 90px;--}}
{{--            margin: auto;--}}
{{--            border-radius: 50%;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            font-size: 38px;--}}
{{--            margin-bottom: 25px;--}}
{{--        }--}}

{{--        .card h2 {--}}
{{--            margin-bottom: 10px;--}}
{{--        }--}}

{{--        .card p {--}}
{{--            color: #64748b;--}}
{{--            margin-bottom: 25px;--}}
{{--        }--}}

{{--        .btn {--}}
{{--            border: none;--}}
{{--            padding: 14px 25px;--}}
{{--            border-radius: 18px;--}}
{{--            font-size: 16px;--}}
{{--            cursor: pointer;--}}
{{--            transition: 0.3s;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .btn-blue {--}}
{{--            background: #eff6ff;--}}
{{--            color: #2563eb;--}}
{{--        }--}}

{{--        .btn-blue:hover {--}}
{{--            background: #dbeafe;--}}
{{--        }--}}

{{--        .btn-green {--}}
{{--            background: #dcfce7;--}}
{{--            color: #16a34a;--}}
{{--        }--}}

{{--        .btn-green:hover {--}}
{{--            background: #bbf7d0;--}}
{{--        }--}}

{{--        .btn-purple {--}}
{{--            background: #f3e8ff;--}}
{{--            color: #9333ea;--}}
{{--        }--}}

{{--        .btn-purple:hover {--}}
{{--            background: #e9d5ff;--}}
{{--        }--}}

{{--        @media(max-width: 1000px) {--}}
{{--            body {--}}
{{--                flex-direction: column;--}}
{{--            }--}}

{{--            .sidebar {--}}
{{--                width: 100%;--}}
{{--            }--}}

{{--            .hero {--}}
{{--                flex-direction: column;--}}
{{--                text-align: center;--}}
{{--                gap: 30px;--}}
{{--            }--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<aside class="sidebar">--}}
{{--    <div>--}}
{{--        <div class="logo">--}}
{{--            <div class="logo-icon">--}}
{{--                <img src="{{asset('assets/media/logos/logo.png')}}" alt="" class="align-self-end" height="50px" width="50px" />--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                <h2>{{auth('admin')->user()->name}}</h2>--}}
{{--                <span>لوحة التحكم</span>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="menu">--}}
{{--            <button class="menu-item active">--}}
{{--                لوحة التحكم--}}
{{--                <span>⌂</span>--}}
{{--            </button>--}}

{{--            <button class="menu-item">--}}
{{--                العملاء--}}
{{--                <span>👥</span>--}}
{{--            </button>--}}

{{--            <button class="menu-item">--}}
{{--                خصائص التطبيق--}}
{{--                <span>⚙</span>--}}
{{--            </button>--}}

{{--            <button class="menu-item">--}}
{{--                الإشعارات--}}
{{--                <span>🔔</span>--}}
{{--            </button>--}}

{{--            <button class="menu-item">--}}
{{--                الدعم الفني--}}
{{--                <span>💬</span>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="sidebar-footer">--}}
{{--        © 2026 جميع الحقوق محفوظة--}}
{{--    </div>--}}
{{--</aside>--}}

{{--<main class="main">--}}

{{--    <section class="hero">--}}
{{--        <div>--}}
{{--            <h1>👋 مرحباً بك</h1>--}}
{{--            <p>يمكنك إدارة التطبيق والإعدادات بكل سهولة</p>--}}

{{--            <div class="hero-boxes">--}}
{{--                <div class="hero-card">--}}
{{--                    <small>صلاحية الدخول</small>--}}
{{--                    <h3>{{auth('admin')->user()->getRoleNames()->implode(',')}}</h3>--}}
{{--                </div>--}}

{{--                <div class="hero-card">--}}
{{--                    <small>آخر تسجيل دخول</small>--}}
{{--                    <h3> {{auth('admin')->user()->updated_at->format('H:I a')}}</h3>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="hero-logo">--}}
{{--            <img src="{{auth('admin')->user()->image_url}}" class="img-fluid" alt="">--}}
{{--        </div>--}}
{{--    </section>--}}

{{--    <section class="stats">--}}

{{--        <div class="stat-card">--}}
{{--            <div class="stat-top">--}}
{{--                <h3>الصفحات</h3>--}}
{{--                <div class="stat-icon blue">📄</div>--}}
{{--            </div>--}}
{{--            <div class="stat-value">3</div>--}}
{{--        </div>--}}

{{--        <div class="stat-card">--}}
{{--            <div class="stat-top">--}}
{{--                <h3>المستخدمين</h3>--}}
{{--                <div class="stat-icon green">👤</div>--}}
{{--            </div>--}}
{{--            <div class="stat-value">12</div>--}}
{{--        </div>--}}

{{--        <div class="stat-card">--}}
{{--            <div class="stat-top">--}}
{{--                <h3>الإشعارات</h3>--}}
{{--                <div class="stat-icon yellow">🔔</div>--}}
{{--            </div>--}}
{{--            <div class="stat-value">8</div>--}}
{{--        </div>--}}

{{--        <div class="stat-card">--}}
{{--            <div class="stat-top">--}}
{{--                <h3>آخر تحديث</h3>--}}
{{--                <div class="stat-icon purple">📅</div>--}}
{{--            </div>--}}
{{--            <div class="stat-value">2026</div>--}}
{{--        </div>--}}

{{--    </section>--}}

{{--    <h2 class="section-title">الوصول السريع</h2>--}}

{{--    <section class="cards">--}}

{{--        <div class="card">--}}
{{--            <div class="card-icon blue">ℹ️</div>--}}
{{--            <h2>عن التطبيق</h2>--}}
{{--            <p>معلومات عامة عن التطبيق</p>--}}
{{--            <button class="btn btn-blue">عرض الصفحة</button>--}}
{{--        </div>--}}

{{--        <div class="card">--}}
{{--            <div class="card-icon green">🔒</div>--}}
{{--            <h2>الخصوصية والسياسات</h2>--}}
{{--            <p>إدارة سياسة الخصوصية</p>--}}
{{--            <button class="btn btn-green">عرض الصفحة</button>--}}
{{--        </div>--}}

{{--        <div class="card">--}}
{{--            <div class="card-icon purple">📄</div>--}}
{{--            <h2>الشروط والأحكام</h2>--}}
{{--            <p>إدارة شروط الاستخدام</p>--}}
{{--            <button class="btn btn-purple">عرض الصفحة</button>--}}
{{--        </div>--}}

{{--    </section>--}}

{{--</main>--}}

{{--<script>--}}
{{--    const menuItems = document.querySelectorAll('.menu-item');--}}

{{--    menuItems.forEach(item => {--}}
{{--        item.addEventListener('click', () => {--}}
{{--            menuItems.forEach(btn => btn.classList.remove('active'));--}}
{{--            item.classList.add('active');--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

{{--</body>--}}
{{--</html>--}}
