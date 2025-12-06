<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <!-- Company Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                <div>
                    <h3 class="text-2xl font-semibold mb-2">{{ $company->name }}</h3>
                    <p class="text-sm text-gray-500 mb-1"><strong>Owner:</strong> {{ $company->owner->name ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Address:</strong> {{ $company->address ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Industry:</strong> {{ $company->industry ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Description:</strong> {{ $company->description ?? '—' }}</p>
                    <p class="text-sm text-gray-500"><strong>Website:</strong>
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $company->website }}
                            </a>
                        @else
                            —
                        @endif
                    </p>
                </div>

                <div class="flex justify-end space-x-4 mb-6">

                    @if (auth()->user()->role == 'company-owner')
                     <a href="{{ route('my-company.edit') }}" 
                     class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                    @else
                     <a href="{{ route('companies.edit', ['company' => $company->id,'redirectToList' => 'false']) }}" 
                     class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                    @endif
                    
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Archive this company?');">
                        @csrf
                        @method('DELETE')
                        @if (auth()->user()->role == 'admin')
                        <a href="{{ route('companies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Back</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Archive</button>
                        @endif  

                    </form>
                </div>
            </div>
        </div> 

         @if(auth()->user()->role == 'admin')
        <!-- Tabs -->

        <div class="mb-6">
            <ul class="flex border-b">
                <li class="-mb-px mr-1">
                    <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                       class="bg-white inline-block py-2 px-4 {{ request('tab') == 'applications' ? 'text-gray-600' : 'text-blue-600 border-b-2 border-blue-600' }}">
                        Jobs
                    </a>
                </li>
                <li class="-mb-px mr-1">
                    <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applications']) }}"
                       class="bg-white inline-block py-2 px-4 {{ request('tab') == 'applications' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600' }}">
                        Applications
                    </a>
                </li>
            </ul>
        </div>

       
    
        <!-- Tab Content -->
        <div>
            <!-- Jobs tab -->
            <div id="jobs" class="{{ request('tab') == 'applications' ? 'hidden' : 'block' }}">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold">Jobs Content</h3>
                    <span class="text-sm text-gray-600">
                        {{ ($company->JobVacancies ?? collect())->count() }} job(s)
                    </span>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Job Title</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Location</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($company->JobVacancies ?? [] as $job)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <a href="{{ route('job-vacancies.show', $job->id) }}" class="hover:underline text-blue-600">{{ $job->title }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $job->type ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $job->location ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-500 hover:underline mr-3">View</a>
                                        <a href="{{ route('job-vacancies.edit', $job->id) }}" class="text-green-500 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        No job vacancies found for this company.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Applications tab -->
            <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold">Applications</h3>
                    <span class="text-sm text-gray-600">{{ ($company->applications ?? collect())->count() }} application(s)</span>
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
                            @forelse ($company->applications ?? [] as $app)
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
            @endif
        </div> <!-- end tab content wrapper -->

    </div> <!-- end container -->

</x-app-layout>