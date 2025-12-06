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
                <h3 class="text-lg font-medium text-gray-800">{{ $analytics['activeUsers'] }}</h3>
                <p class="text-3xl font-bold text-indigo-600">100</p>
                <p class="text-sm text-gray-500">Last 30 days</p>
            </div>

            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-800">{{ $analytics['totalJob'] }}</h3>
                <p class="text-3xl font-bold text-indigo-600">100</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>

            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-800">{{ $analytics['totalapplications'] }}</h3>
                <p class="text-3xl font-bold text-indigo-600">100</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>

        </div>

        <!-- Most Applied Jobs -->

        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Most Applied Jobs</h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class=" py-2 uppercase text-gray-500">Job Title</th>
                            @if (auth()->user()->role == 'admin')
                            <th class=" py-2 uppercase text-gray-500">Company</th>
                            @endif
                            
                            <th class=" py-2 uppercase text-gray-500">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['mostAppliedJobs'] as $job )
                        <tr>
                                <td class="py-4">{{ $job->title }}</td>
                                @if (auth()->user()->role == 'admin')
                               <td class="py-4">{{ $job->company->name }}</td>
                                @endif
                                <td class="py-4 px-10">{{ $job->totalCount }}</td>
                            </tr>
                        
                        @endforeach
                            
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Top Converting Job Posts -->

        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Top Converting Job Posts</h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class=" py-2 uppercase text-gray-500">JOB TITLE</th>
                            <th class=" py-2 uppercase text-gray-500">VIEWS</th>
                            <th class=" py-2 uppercase text-gray-500">APPLICATIONS</th>
                            <th class=" py-2 uppercase text-gray-500">CONVERSION RATE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ( $analytics['conversionRates'] as $Rate )
                        <tr>
                            <td class="py-4">{{ $Rate->title }}</td>
                            <td class="py-4">{{ $Rate->views_Count }}</td>
                            <td class="py-4 px-10">{{ $Rate->totalCount }}</td>
                            <td class="py-4 px-10">{{ $Rate->conversionRates }}%</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>





    </div>

</x-app-layout>