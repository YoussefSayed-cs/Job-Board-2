<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-14 px-7 flex flex-col gap-6">
        <div class="grid grid-cols-3 gap-6">
            <!-- Overview cards -->
            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-800">Active Users</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['activeUsers'] }}</p>
                <p class="text-sm text-gray-500">Last 30 days</p>
            </div>

            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-800">Total Jobs</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalJob'] }}</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>

            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-800">Total Applications</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalapplications'] }}</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>
        </div>

        <!-- Most Applied Jobs -->
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Most Applied Jobs</h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 uppercase text-gray-500">Job Title</th>
                            @if (auth()->user()->role == 'admin')
                            <th class="py-2 uppercase text-gray-500">Company</th>
                            @endif
                            <th class="py-2 uppercase text-gray-500">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($analytics['mostAppliedJobs'] as $job)
                        <tr>
                            <td class="py-4">{{ $job->title }}</td>
                            @if (auth()->user()->role == 'admin')
                            <td class="py-4">{{ $job->company->name ?? '—' }}</td>
                            @endif
                            <td class="py-4 text-center">{{ $job->totalCount }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        
        
    </div>
</x-app-layout>