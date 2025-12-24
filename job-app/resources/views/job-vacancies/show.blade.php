<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $job_vacancy->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">

            <a href="{{ route('dashboard') }}" class="text-blue-400 hover:underline mb-6 inline-block">
                Back to Jobs
            </a>

            <div class="border-b border-white/10 pb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $job_vacancy->title }}</h1>
                        <p class="text-md text-gray-400">{{ $job_vacancy->company->name }}</p>

                        <div class="flex items-center gap-2">
                            <p class="text-sm text-gray-400">{{ $job_vacancy->location }}</p>
                            <p class="text-sm text-gray-400">.</p>
                            <p class="text-sm text-gray-400">{{ '$' . number_format($job_vacancy->salary) }}</p>
                            <p class="text-sm bg-indigo-500 text-white p-2 rounded-lg">{{ $job_vacancy->type }}</p>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('job-vacancy.apply', $job_vacancy->id) }}"
                            class="w-full justify-center bg-gradient-to-r from-indigo-500 to-rose-500 text-white rounded-lg px-4 py-2 transition hover:from-indigo-600 hover:to-rose-600">
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="grid grid-cols-3 gap-4 mt-6">

                {{-- LEFT SIDE — DESCRIPTION --}}
                <div class="col-span-2">
                    <h2 class="text-lg font-bold text-white">Job Description</h2>
                    <p class="text-gray-400 mt-2">{{ $job_vacancy->description }}</p>
                </div>

                {{-- RIGHT SIDE — OVERVIEW --}}
                <div class="col-span-1">
                    <h2 class="text-lg font-bold text-white">Job Overview</h2>

                    <div class="bg-gray-900 rounded-lg p-6 space-y-4 mt-2">

                        <div>
                            <p class="text-gray-400">Published Date</p>
                            <p class="text-white">{{ $job_vacancy->created_at->format('M D , Y') }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400">Company</p>
                            <p class="text-white">{{ $job_vacancy->company->name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400">Location</p>
                            <p class="text-white">{{ $job_vacancy->location }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400">Salary</p>
                            <p class="text-white">{{ '$ ' . number_format($job_vacancy->salary) }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400">Type</p>
                            <p class="text-white">{{ $job_vacancy->type }}</p>
                        </div>

                        <div>
                            <p class="text-gray-400">Category</p>
                            <p class="text-white">{{ $job_vacancy->job_category->name }}</p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>