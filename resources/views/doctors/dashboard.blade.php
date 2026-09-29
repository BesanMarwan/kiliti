@extends('doctors.layouts.doctor')
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')"/>
@endsection
@section('content')
    <h1>hi , {{auth('web')->user()->name}}</h1>
@endsection

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الطبيب - كليتي</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-slate-900 text-white flex flex-col">
        <div class="p-5 text-xl font-bold border-b border-slate-800">منصة كليتي - الطبيب</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="#" class="block px-4 py-2 rounded bg-blue-600 text-white">الرئيسية</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-slate-800 text-slate-300">المرضى</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-slate-800 text-slate-300">المواعيد</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-slate-800 text-slate-300">التقارير</a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <form action="#" method="POST">
                @csrf
                <button type="submit" class="w-full text-right text-red-400 hover:text-red-300">تسجيل الخروج</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">مرحباً بك، دكتور</h1>
            <div class="flex items-center space-x-3 space-x-reverse">
                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                <span class="text-sm text-gray-600">متصل الآن</span>
            </div>
        </header>

        <main class="p-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-blue-500">
                    <p class="text-gray-500 text-sm">مرضى اليوم</p>
                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $stats['today_count'] }}</h3>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-emerald-500">
                    <p class="text-gray-500 text-sm">إجمالي المرضى</p>
                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $stats['total_patients'] }}</h3>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-amber-500">
                    <p class="text-gray-500 text-sm">تقارير معلقة</p>
                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $stats['pending_reports'] }}</h3>
                </div>
            </div>

            <!-- Today's Appointments Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-800">مواعيد اليوم</h2>
                    <span class="text-sm text-blue-600 bg-blue-50 px-3 py-1 rounded-full">جدول الحجوزات</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="py-3 px-6">اسم المريض</th>
                            <th class="py-3 px-6">وقت الموعد</th>
                            <th class="py-3 px-6">الحالة</th>
                            <th class="py-3 px-6">الإجراءات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse($todayAppointments as $appointment)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-4 px-6 font-medium">{{ $appointment->patient->name }}</td>
                                <td class="py-4 px-6">{{ $appointment->appointment_date->format('H:i') }}</td>
                                <td class="py-4 px-6">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $appointment->status == 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                {{ $appointment->status }}
                                            </span>
                                </td>
                                <td class="py-4 px-6">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">بدء الكشف</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-400">لا توجد مواعيد مجدولة لهذا اليوم.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>

