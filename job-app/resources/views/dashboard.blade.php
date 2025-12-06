<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">

            <h3 class="text-white text-2xl font-bold mb-6">
                Welcome back, {{ Auth::user()->name }}
            </h3>

            {{-- Search + Filters --}}
            <div class="flex items-center justify-between">

                {{-- Search --}}
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center w-1/3 space-x-2">

                    <div class="flex w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full p-2 rounded-l-lg bg-gray-800 text-white focus:outline-none"
                            placeholder="Search for a job">

                        @if(request('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif

                        <button type="submit" class="bg-indigo-500 text-white px-4 rounded-r-lg hover:bg-indigo-600">
                            Search
                        </button>
                    </div>

                    @if(request('search'))
                        <a href="{{ route('dashboard', ['filter' => request('filter')]) }}"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                            Clear
                        </a>
                    @endif

                </form>


                {{-- Filters --}}
                <div class="flex space-x-2">

                    @php
                        $active = "bg-indigo-700";
                        $inactive = "bg-indigo-500";
                    @endphp

                    <a href="{{ route('dashboard', ['filter' => 'Full-Time', 'search' => request('search')]) }}"
                        class="px-4 py-2 rounded-lg text-white {{ request('filter') == 'Full-Time' ? $active : $inactive }}">
                        Full-Time
                    </a>

                    <a href="{{ route('dashboard', ['filter' => 'Remote', 'search' => request('search')]) }}"
                        class="px-4 py-2 rounded-lg text-white {{ request('filter') == 'Remote' ? $active : $inactive }}">
                        Remote
                    </a>

                    <a href="{{ route('dashboard', ['filter' => 'Hybrid', 'search' => request('search')]) }}"
                        class="px-4 py-2 rounded-lg text-white {{ request('filter') == 'Hybrid' ? $active : $inactive }}">
                        Hybrid
                    </a>

                    <a href="{{ route('dashboard', ['filter' => 'Contract', 'search' => request('search')]) }}"
                        class="px-4 py-2 rounded-lg text-white {{ request('filter') == 'Contract' ? $active : $inactive }}">
                        Contract
                    </a>

                    @if(request('filter'))
                        <a href="{{ route('dashboard', ['search' => request('search')]) }}"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                            Clear
                        </a>
                    @endif
                </div>
            </div>

            {{-- Jobs List --}}
            <div class="space-y-4 mt-6">
                @forelse ($jobs as $job)
                    <div class="border-b border-white/10 pb-4 flex justify-between items-center">
                        <div>
                            <a href="{{ route('job-vacancy.show' , $job->id) }}"
                             class="text-lg font-semibold text-blue-400 hover:underline">
                                {{ $job->title }}</a>

                            <p class="text-sm text-gray-300">
                                {{ $job->company->name }} - {{ $job->location }}
                            </p>

                            <p class="text-sm text-gray-300">
                                ${{ number_format($job->salary) }} / Year
                            </p>
                        </div>

                        <span class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                            {{ $job->type }}
                        </span>
                    </div>
                @empty
                    <p class="text-white text-2xl font-bold text-center">
                        No jobs found!
                    </p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $jobs->links() }}
            </div>

        </div>
    </div>
</x-app-layout>