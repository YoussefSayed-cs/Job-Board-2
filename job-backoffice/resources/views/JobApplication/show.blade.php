<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $job_application->Owner->name ?? '—' }}'s Application for {{ $job_application->jobVacancy->title ?? '—' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <!-- Company Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                <div>
                    <h3 class="text-2xl font-semibold mb-2">Applications Details</h3>
                    <p class="text-sm text-gray-500 mb-1"><strong>Applicant:</strong> {{ $job_application->Owner->name ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Job Vacancy:</strong> {{ $job_application->jobVacancy->title ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Company:</strong> {{ $job_application->jobVacancy->company->name ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mb-1"><strong>Status:</strong> <span class="@if($job_application->status == 'accepted') text-green-500 @elseif($job_application->status == 'rejected') text-red-500  @else text-yellow-500 @endif">{{ $job_application->status ?? '—' }}</span></p>
                    <p class="text-sm text-gray-500"><strong>Resume:</strong>
                        @if($job_application->resume->fileUri)
                            <a href="{{ $job_application->resume->fileUri }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $job_application->resume->fileUri }}
                            </a>
                        @else
                            —
                        @endif
                    </p>
                </div>


                   <!-- Edit and Archive Buttons-->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('job-applications.edit', ['job_application' => $job_application->id,'redirectToList' => 'true']) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                    
                    <form action="{{ route('job-applications.destroy', $job_application->id) }}" method="POST" onsubmit="return confirm('Archive this job application?');">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('job-applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Back</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Archive</button>
                    </form>
                </div>
            </div>
        </div>                  

        <!-- Tabs Navigation -->
        <div class="mb-6">
            <ul class="flex border-b">
                <li class="-mb-px mr-1">
                    <a href="{{ route('job-applications.show', ['job_application' => $job_application->id, 'tab' => 'resume']) }}"
                       class="bg-white inline-block py-2 px-4 {{ request('tab') == 'resume' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600' }}">
                        Resume
                    </a>
                </li>
                <li class="-mb-px mr-1">
                    <a href="{{ route('job-applications.show', ['job_application' => $job_application->id, 'tab' => 'AIFeedback']) }}"
                       class="bg-white inline-block py-2 px-4 {{ request('tab') == 'AIFeedback' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600' }}">
                        AIFeedback
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div>
            <!-- Resume tab -->
            <div id="resume" class="{{ request('tab') == 'resume' || request('tab') === null ? 'block' : 'hidden' }}">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold">resume Content</h3>
                
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Summary</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Skills</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Experience</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Education</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                                <tr>
                                    <td class="px-6 py-4 ">{{ $job_application->resume->summary ?? '—' }}</td>
                                    <td class="px-6 py-4">{{ $job_application->resume->skills ?? '—' }}</td>
                                    <td class="px-6 py-4 ">{{ $job_application->resume->experience ?? '—' }}</td>
                                    <td class="px-6 py-4">{{ $job_application->resume->education ?? '—' }}</td>
                                </tr>
        
                        </tbody>
                    </table>
                </div>
</div>
            <!-- AI Feedback tab -->
            <div id="AIFeedback" class="{{ request('tab') == 'AIFeedback' ? 'block' : 'hidden' }}">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold">AI Feedback</h3>
          
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 ">AI score</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 ">Feedback</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                           
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $job_application->aiGeneratedScore ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $job_application->aiGeneratedFeedback ?? '—' }}</td>
                                </tr>
                                
                                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end tab content wrapper -->

    </div> <!-- end container -->

</x-app-layout>