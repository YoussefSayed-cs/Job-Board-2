<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $job_vacancy->title }} - Apply
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">

            <a href="{{ route('job-vacancy.show', $job_vacancy->id) }}"
                class="text-blue-400 hover:underline mb-6 inline-block">
                ← Back to Job Details
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
                </div>

                <form action="{{ route('job-vacancy.processApplications', $job_vacancy->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Resume Selection -->
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-4">Choose Your Resume</h3>

                        <div class="mb-6">
                            <x-input-label for="resume" value="Select from your existing resumes:" />
                        </div>

                    </div>

                    <!-- Upload New Resume -->
                    <div x-data="{ fileName: '', hasError: {{ $errors->has('resume_file') ? 'true' : 'false' }} }">

                        <x-input-label for="resume" value="Or upload a new resume:" />

                        <div class="flex items-center">
                            <div class="flex-1">

                                <label for="new_resume_file" class="block text-white cursor-pointer">
                                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-4 transition hover:border-blue-500"
                                        :class="{ 'border-blue-500': fileName,'border-red-500': hasError  }">
                                        <input @change="fileName = $event.target.files[0].name" type="file"
                                            name="resume_file" id="new_resume_file" class="sr-only" accept=".pdf" />

                                        <div class="text-center">

                                             
                                            <template x-if="!fileName">
                                                <p class="text-gray-400">
                                                    Click to upload PDF (Max 5MB)
                                                </p>
                                            </template>

                                            <template x-if="fileName">
                                                <div>
                                                    <p x-text="fileName" class="mt-2 text-blue-400"></p>
                                                    <p class="text-gray-400 text-sm mt-1">Click to change file</p>
                                                </div>
                                            </template>

                                        </div>

                                    </div>
                                </label>

                            </div>
                        </div>

                        @error('resume_file')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-primary-button class="w-full">
                            Apply Now
                        </x-primary-button>
                    </div>


                </form>

            </div>

        </div>
    </div>

</x-app-layout>