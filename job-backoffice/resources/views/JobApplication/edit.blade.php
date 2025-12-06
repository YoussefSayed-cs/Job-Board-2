<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('  Update Applicant Status') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-x">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-mid">
            <form
                action="{{ route('job-applications.update', ['job_application' => $job_application->id, 'redirectToList' => request()->query('redirectToList')]) }}"
                method="post">
                @csrf
                @method('PUT')


                <!-- Job Application details -->
                <div class="mb-4 p-6 bg-gray-50  border border-gray-100  rounded-lg shadow-md">
                    <h3 class="text-lg font-bold">Job Applications Details</h3>
                    <p class="text-sm mb-4">Enter Job application details</p>

 
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Applicant Name:</label>
                        <span>{{ $job_application->Owner->name ?? '—' }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Job Vacancy:</label>
                        <span class="text-black">{{ $job_application->jobVacancy->title ?? '—' }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Company:</label>
                        <span class="text-black">{{ $job_application->jobVacancy->company->name ?? '—' }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">AI Genrated Score:</label>
                        <span class="text-black">{{ $job_application->aiGeneratedScore ?? '—' }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">AI Generated
                            Feedback:</label>
                        <span class="text-black y--2">{{ $job_application->aiGeneratedFeedback ?? '—' }}</span>
                    </div>


                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-black">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm {{ $errors->has('status') ? 'outline-red-500' : 'outline-green-500' }}">
                            <option value="pending" {{ old('status', $job_application->status) == 'pending' ? 'selected' : ''}}>Pending - Under Review</option>
                            <option value="Accepted" {{ old('status', $job_application->status) == 'Accepted' ? 'selected' : '' }}>Accepted - Qualified</option>
                            <option value="Rejected" {{ old('status', $job_application->status) == 'Rejected' ? 'selected' : ''}}>Rejected - Disqualified</option>

                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </select>
                    </div>


                    <div class="flex justify-end space-x-4">

                        <a href="{{ route('job-applications.index') }}"
                            class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                            Cancel
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focue:ring-2">
                            Update Applicant Status
                        </button>
                    </div>
            </form>
        </div>
    </div>


</x-app-layout>