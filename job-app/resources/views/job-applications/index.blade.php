<x-app-layout>
    <div class="py-12">

        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto space-y-4">

            @forelse ($jobApplications as $jobApplication)

                <div class="bg-gray-900 p-4 rounded-lg">

                    <h3 class="text-white text-lg font-bold">
                        {{ $jobApplication->JobVacancy->title }}
                    </h3>

                    <p class="text-sm">
                        {{ $jobApplication->jobvacancy->Company->name }}
                    </p>

                    <p class="text-xs">
                        {{ $jobApplication->JobVacancy->location }}
                    </p>

                    <div class="flex items-center justify-between mt-2">

                        <p class="text-sm">
                            {{ $jobApplication->created_at->format('d M Y') }}
                        </p>

                        <p class="px-3 py-1 bg-blue-600 text-white rounded-md">
                            {{ $jobApplication->JobVacancy->type }}
                        </p>

                    </div>

                    <div class="mt-4">
                        <span class="text-sm">
                            Applied With: {{ $jobApplication->resume->filename }}
                        </span>

                        <a 
                            href="{{ asset('storage/' . $jobApplication->resume->fileUri) }}"
                            target="_blank"
                            class="text-indigo-500 hover:text-indigo-600 ml-2"
                        >
                            View Resume
                        </a>
                    </div>

                    <div class="flex flex-col gap-2 mt-4">

                        @php
                            $statusClass = match ($jobApplication->status) {
                                'pending' => 'bg-yellow-500',
                                'accepted' => 'bg-green-500',
                                'rejected' => 'bg-red-500',
                                default => 'bg-gray-500',
                            };
                        @endphp

                        <div class="flex items-center gap-2">

                            <p class="text-sm {{ $statusClass }} text-white p-2 rounded-md w-fit">
                                Status: {{ ucfirst($jobApplication->status) }}
                            </p>

                            <p class="text-sm bg-indigo-600 text-white p-2 rounded-md w-fit">
                                Score: {{ $jobApplication->aiGeneratedScore }}
                            </p>

                        </div>

                        <div class="mt-2">
                            <h4 class="text-md font-bold text-white">
                                AI Feedback:
                            </h4>

                            <p class="text-sm text-gray-300 mt-1">
                                {{ $jobApplication->aiGeneratedFeedback }}
                            </p>
                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-gray-800 p-4 rounded-lg">
                    <p class="text-white">No job applications found.</p>
                </div>

            @endforelse

        </div>

        <div class="mt-4">
            {{ $jobApplications->links() }}
        </div>

    </div>
</x-app-layout>
