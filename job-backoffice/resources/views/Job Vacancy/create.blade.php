<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' Add Job Vacancy ') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-x m-3">
        <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-mid">
            <form action="{{ route('job-vacancies.store') }}" method="post">
                @csrf


                <!-- JobVacancy details -->
                <div class="mb-4 p-6 bg-gray-50  border border-gray-100  rounded-lg shadow-md">
                    <h3 class="text-lg font-bold">Job Vacancy Details</h3>
                    <p class="text-sm mb-4">Enter Job vacancy details</p>


                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-black">Title</label>
                        <input type="text" name="title" id="title"
                            class="{{ $errors->has('title') ? 'outline-red-500' : '' }}mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm ">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-black">Location</label>
                        <input type="text" name="location" id="location"
                            class="{{ $errors->has('location') ? 'outline-red-500' : '' }}mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm ">
                        @error('location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block text-sm font-medium text-black">Expected Salary (USD)</label>
                        <input type="number" name="salary" id="salary"
                            class="{{ $errors->has('salary') ? 'outline-red-500' : '' }}mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm ">
                        @error('salary')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-black">Type</label>
                        <select name="type" id="type"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="Full-Time" {{ old('type') == 'Full-Time' ? 'selected' : ''}}>Full-Time</option>
                            <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Remote" {{ old('type') == 'Remote' ? 'selected' : ''}}>Remote</option>
                            <option value="Hybrid" {{ old('type') == 'Hybrid' ? 'selected' : ''}}>Hybrid</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- Company select Drobdown -->
                    <div class="mb-4">
                        <label for="companyID" class="block text-sm font-medium text-black">Company</label>
                        <select name="companyID" id="companyID"
                            class="{{ $errors->has('companyID') ? 'outline-red-500' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"> {{ $company->name }} </option>
                            @endforeach
                        </select>
                        @error('companyID')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- JobVacancy select Drobdown -->
                    <div class="mb-4">
                        <label for="categoryID" class="block text-sm font-medium text-black">Job Category</label>
                        <select name="categoryID" id="categoryID"
                            class="{{ $errors->has('categoryID') ? 'outline-red-500' : '' }} mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @foreach ($jobCategories as $jobCategory)
                                <option value="{{ $jobCategory->id }}"> {{ $jobCategory->name }} </option>
                            @endforeach
                        </select>
                        @error('categoryID')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                
                    <!-- JobVacancy Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-md font-large text-black">Description</label>
                        <textarea rows="4" name="description" id="description"
                            class="{{ $errors->has('description') ? 'outline-red-500' : '' }}
                        mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm ">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                </div>



                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-vacancies.index') }}"
                        class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focue:ring-2">
                        Add Job Vacancies</button>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>