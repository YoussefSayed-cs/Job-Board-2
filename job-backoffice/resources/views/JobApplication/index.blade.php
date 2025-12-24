<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Applications {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast-notification />

        <!-- Toggle Archived / Active -->
        <div class="flex justify-end items-center space-x-4 mb-4">
            @if (request()->input('archived') == 'true')
                <a href="{{ route('job-applications.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Active Job Applications
                </a>
            @else
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                   class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Archived Job Applications
                </a>
            @endif
        </div>

        <!-- Applications Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow bg-white">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-700">Applicant Name</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-700">Position (Job Vacancy)</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="px-6 py-3 text-left text-md font-semibold text-gray-700">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($job_applications as $application)
                    <tr>
                        <!-- Applicant -->
                        <td class="px-6 py-4 text-gray-800">
                            <a class="text-blue-500 hover:text-blue-700 underline"
                               href="{{ route('job-applications.show', $application->id) }}">
                               {{ $application->Owner?->name ?? 'Unknown User' }}
                            </a>
                        </td>

                        <!-- Job Vacancy -->
                        <td class="px-6 py-4 text-gray-800">
                            {{ $application->JobVacancy?->title ?? 'N/A' }}
                        </td>

                        <!-- Company (admin only) -->
                        @if(auth()->user()->role === 'admin')
                            <td class="px-6 py-4 text-gray-800">
                                {{ $application->JobVacancy?->company?->name ?? 'N/A' }}
                            </td>
                        @endif

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span class="font-semibold
                                @if($application->status === 'accepted') text-green-500
                                @elseif($application->status === 'rejected') text-red-500
                                @else text-yellow-500
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                @if(request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-applications.restore', $application->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">
                                            Restore
                                        </button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-applications.edit', $application->id) }}"
                                       class="text-blue-500 hover:text-blue-700">Edit</a>

                                    <!-- Archive Button -->
                                    <form action="{{ route('job-applications.destroy', $application->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-orange-500 hover:text-orange-700">
                                            Archive
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="px-6 py-4 text-center text-gray-500">
                            No Applications found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $job_applications->links() }}
        </div>

    </div>
</x-app-layout>
