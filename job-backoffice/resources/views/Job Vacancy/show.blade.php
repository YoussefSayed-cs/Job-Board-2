<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $vacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <!-- Company Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                <div>
                    <h3 class="text-2xl font-semibold mb-2">{{ $vacancy->company->name }}</h3>
                    <p class="text-sm text-gray-500 mb-1"><strong>Location:</strong> {{ $vacancy->location ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Type:</strong> {{ $vacancy->type ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Salary:</strong> {{ $vacancy->salary ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Description:</strong> {{ $vacancy->description ?? '—' }}</p>
                    <p class="text-sm text-gray-500"><strong>Website:</strong>
                        @if($vacancy->company->website)
                            <a href="{{ $vacancy->company->website }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $vacancy->company->website }}
                            </a>
                        @else
                            —
                        @endif
                    </p>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $vacancy->id,'redirectToList' => 'false']) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                       Edit
                    </a>
                    
                    <form action="{{ route('job-vacancies.destroy', $vacancy->id) }}" method="POST" onsubmit="return confirm('Archive this job vacancy?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                            Archive
                        </button>
                    </form>
                    
                    <a href="{{ route('job-vacancies.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                       Back
                    </a>
                </div>
            </div>
        </div>                  

        <!-- Tabs -->
        <div class="mb-6">
            <ul class="flex border-b">
                <li class="-mb-px mr-1">
                    <a href="{{ route('job-vacancies.show', ['job_vacancy' => $vacancy->id, 'tab' => 'applications']) }}"
                       class="bg-white inline-block py-2 px-4 {{ request('tab') == 'applications' || request('tab') == '' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600' }}">
                        Applications
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div>
            <!-- Applications tab -->
            <div id="applications" class="{{ request('tab') == 'applications' || request('tab') == '' ? 'block' : 'hidden' }}">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold">Applications</h3>
                    <span class="text-sm text-gray-600">{{ ($vacancy->applications ?? collect())->count() }} application(s)</span>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Applicant</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Job</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($vacancy->applications ?? [] as $app)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $app->user->name ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $app->job->title ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $app->status ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('applications.show', $app->id) }}" class="text-blue-500 hover:underline mr-3">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">No applications found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end tab content wrapper -->

    </div> <!-- end container -->

</x-app-layout>