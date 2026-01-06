<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                Dashboard
            </h2>
            <p class="text-sm text-slate-500 mt-1">Overview of your platform's performance</p>
        </div>
    </x-slot>

    {{-- ================= CONTENT ================= --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up">

        {{-- Stat Card 1 --}}
        <div class="dashboard-card group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-1 rounded-full">+12%</span>
            </div>
            <h3 class="text-slate-500 text-sm font-medium">Active Users</h3>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ $analytics['activeUsers'] }}</p>
        </div>

        {{-- Stat Card 2 --}}
        <div class="dashboard-card group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm font-medium">Total Jobs</h3>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ $analytics['totalJob'] }}</p>
        </div>

        {{-- Stat Card 3 --}}
        <div class="dashboard-card group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-xs font-semibold text-green-500 bg-green-50 px-2 py-1 rounded-full">+5%</span>
            </div>
            <h3 class="text-slate-500 text-sm font-medium">Applications</h3>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ $analytics['totalapplications'] }}</p>
        </div>

        {{-- Stat Card 4 (Placeholder for balance or other) --}}
        <div class="dashboard-card group bg-gradient-to-br from-brand-600 to-indigo-700 text-white border-none">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
            <h3 class="text-brand-100 text-sm font-medium">System Health</h3>
            <p class="text-3xl font-bold mt-1">98%</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up" style="animation-delay: 0.1s;">
        
        {{-- Overview Chart --}}
        <div class="dashboard-card min-h-[400px]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800">
                    System Overview
                </h3>
                <select class="text-sm border-gray-200 rounded-lg text-slate-500 focus:ring-brand-500 focus:border-brand-500">
                    <option>This Week</option>
                    <option>This Month</option>
                </select>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="overviewChart"></canvas>
            </div>
        </div>

        {{-- Most Applied Jobs --}}
        <div class="dashboard-card">
            <h3 class="text-lg font-bold text-slate-800 mb-6">
                Most Popular Jobs
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b border-gray-100">
                            <th class="pb-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Job Title</th>
                            <th class="pb-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Company</th>
                            <th class="pb-3 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Applicants</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($analytics['mostAppliedJobs'] as $job)
                            <tr class="group hover:bg-slate-50 transition-colors">
                                <td class="py-4 pr-4">
                                    <div class="font-medium text-slate-800 group-hover:text-brand-600 transition-colors">
                                        {{ $job->title }}
                                    </div>
                                    <div class="text-xs text-slate-400">{{ $job->type }}</div>
                                </td>
                                <td class="py-4 pr-4 text-slate-600">{{ $job->company->name ?? '—' }}</td>
                                <td class="py-4 text-right">
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-50 text-brand-700">
                                        {{ $job->totalCount }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400 italic">
                                    No data available yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('overviewChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Active Users', 'Vacancies', 'Applications'],
                datasets: [{
                    label: 'Total Count',
                    data: [
                        {{ $analytics['activeUsers'] }},
                        {{ $analytics['totalJob'] }},
                        {{ $analytics['totalapplications'] }}
                    ],
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)', // Indigo
                        'rgba(168, 85, 247, 0.8)', // Purple
                        'rgba(249, 115, 22, 0.8)', // Orange
                    ],
                    borderColor: [
                        'rgba(99, 102, 241, 1)',
                        'rgba(168, 85, 247, 1)',
                        'rgba(249, 115, 22, 1)',
                    ],
                    borderWidth: 1,
                    borderRadius: 8,
                    barThickness: 40,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: 'Inter', size: 13 },
                        bodyFont: { family: 'Inter', size: 13 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: { family: 'Inter' },
                            color: '#64748b'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Inter', weight: 500 },
                            color: '#64748b'
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });

    </script>
</x-app-layout>