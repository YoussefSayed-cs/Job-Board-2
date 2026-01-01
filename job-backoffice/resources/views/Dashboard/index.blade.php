<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">

            {{-- Page Title --}}
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>

            {{-- Notification Bell --}}
            <div class="relative">
                <button id="notifBtn" class="relative text-2xl focus:outline-none">
                    🔔
                    @if($unreadCount > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>

              
                {{-- Notifications Dropdown --}}
                <div id="notifMenu"
                    class="hidden absolute right-0 mt-3 w-80 bg-white shadow-lg rounded-lg z-50 overflow-hidden">

                    <div class="p-3 border-b font-semibold text-gray-700">
                        Notifications
                    </div>

                    @forelse($notifications as $notification)
                              <div class="flex justify-between items-start px-4 py-3 text-sm hover:bg-gray-100
        {{ $notification->read_at ? 'text-gray-500' : 'font-semibold text-gray-800' }}">

        {{-- Notification Content --}}
        <a href="{{ route('job-applications.show', $notification->data['application_id']) }}"
           class="flex-1 pr-2">
            <span class="block">
                {{ $notification->data['job_seeker_name'] }} applied for
            </span>
            <span class="text-indigo-600">
                {{ $notification->data['job_title'] }}
            </span>
        </a>

        {{-- Delete Button --}}
        <form method="POST"
              action="{{ route('notifications.delete', $notification->id) }}">
            @csrf
            @method('DELETE')
            <button
                class="text-red-500 text-xs hover:text-red-700"
                title="Delete notification">
                ✕
            </button>
        </form>

    </div>
                    @empty
                        <p class="p-4 text-sm text-gray-500 text-center">
                            No notifications
                        </p>
                    @endforelse
                </div>

            </div>
        </div>
    </x-slot>

    {{-- ================= CONTENT ================= --}}

    <div class="py-14 px-7 flex flex-col gap-6">

        {{-- Overview Cards --}}
        <div class="grid grid-cols-3 gap-6">
            <div class="p-6 bg-white shadow-sm rounded-lg">
                <h3 class="text-sm text-gray-500">Active Users</h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['activeUsers'] }}
                </p>
                <p class="text-xs text-gray-400">Last 30 days</p>
            </div>

            <div class="p-6 bg-white shadow-sm rounded-lg">
                <h3 class="text-sm text-gray-500">Total Jobs</h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['totalJob'] }}
                </p>
                <p class="text-xs text-gray-400">All time</p>
            </div>

            <div class="p-6 bg-white shadow-sm rounded-lg">
                <h3 class="text-sm text-gray-500">Total Applications</h3>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ $analytics['totalapplications'] }}
                </p>
                <p class="text-xs text-gray-400">All time</p>
            </div>
        </div>

        {{-- Overview Chart --}}
        <div class="p-6 bg-white shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                System Overview Chart
            </h3>
            <div class="h-64">
                <canvas id="overviewChart"></canvas>
            </div>
        </div>

        {{-- Most Applied Jobs --}}
        <div class="p-6 bg-white shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                Most Applied Jobs
            </h3>

            <table class="w-full text-sm">
                <thead class="text-gray-500 border-b">
                    <tr>
                        <th class="py-2 text-left">Job Title</th>
                        <th class="py-2 text-left">Company</th>
                        <th class="py-2 text-right">Applications</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($analytics['mostAppliedJobs'] as $job)
                        <tr class="border-b">
                            <td class="py-3">{{ $job->title }}</td>
                            <td class="py-3">{{ $job->company->name ?? '—' }}</td>
                            <td class="py-3 text-right font-semibold">
                                {{ $job->totalCount }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">
                                No data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Notification toggle
        const btn = document.getElementById('notifBtn');
        const menu = document.getElementById('notifMenu');

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            menu.classList.add('hidden');
        });
        

        // Chart
        new Chart(document.getElementById('overviewChart'), {
            type: 'bar',
            data: {
                labels: ['Active Users', 'Total Jobs', 'Applications'],
                datasets: [{
                    data: [
                        {{ $analytics['activeUsers'] }},
                        {{ $analytics['totalJob'] }},
                        {{ $analytics['totalapplications'] }}
                    ],
                    backgroundColor: ['#6366F1', '#22C55E', '#F59E0B'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    </script>
</x-app-layout>