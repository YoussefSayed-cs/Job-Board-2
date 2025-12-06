<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Applications {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-x-auto p-30">

        <x-toast-notification />

        <div class="flex justify-end items-center space-x-4">
            @if (request()->has('archived') && request()->input('archived') == 'true')

                <!-- Active -->
                <a href="{{ route('job-applications.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Active Job Applications
                </a>

            @else

                <!-- Archived-->
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Archived Job Applications
                </a>

            @endif
        </div>
        
        <!-- JobApplications table-->
        <table class="min-w-full divide-y  divide-gray-200 rounded-lg shadow mt-4 bg-white ">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black-700">Applicant Name</th>
                    <th class="px-20 py-3 text-left text-md font-semibold text-black">Position (Job Vacancy)</th>

                    @if (auth()->user()->role == 'company-owner')
                      <th class="px-20 py-3 text-left text-md font-semibold text-black">Company</th>
                    @endif
                    
                    <th class="px-6 py-3  text-left text-md font-semibold text-black">Status</th>
                    <th class="px-6 py-3 text-left text-md font-semibold text-black">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($job_applications as $application)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800 "> <a class="text-blue-500 hover:text-blue-700 underline"
                                href="{{ route('job-applications.show', $application->id) }}">{{ $application->Owner?->name ?? 'Unknown User' }} </a> </td>
                         <td class="px-6 py-4 text-gray-800 "> {{ $application->JobVacancy?->title ?? 'N/A' }} </td>

                         @if (auth()->user()->role == 'admin')
                         <td class="px-6 py-4 text-gray-800 "> {{ $application->JobVacancy?->company?->name ?? 'N/A' }} </td>    
                         @endif
                         
                         <td class="px-6 py-4 @if($application->status == 'accepted') text-green-500 @elseif($application->status == 'rejected') text-red-500  @else text-yellow-500 @endif text-gray-800 "> {{ $application->status }} </td>
                        <td>
                            <div class="flex space-x-4">
                                @if (request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-applications.restore', $application->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700"> Restore </button>
                                    </form>


                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-applications.edit', $application->id)}}"
                                        class="text-blue-500 hover:text-blue-700">✍️Edit</a>

                                    <!-- Archive button-->
                                    <form action="{{ route('job-applications.destroy', $application->id) }}" method="post"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-orange-500 hover:text-orange-700">🗃️Archive</button>
                                    </form>
                                @endif


                            </div>


                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-800">No Applications found</td>
                    </tr>

                @endforelse
            </tbody>
        </table>


        <div class="mt-4">{{ $job_applications->links() }}</div>
    </div>
</x-app-layout>