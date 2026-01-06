<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        @forelse ($jobApplications as $jobApplication)
            <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:bg-white/5 group relative overflow-hidden">
                
                {{-- Decorative Glow --}}
                <div class="absolute -right-20 -top-20 w-40 h-40 bg-brand-500/10 rounded-full blur-3xl group-hover:bg-brand-500/20 transition-all duration-500"></div>

                <div class="relative z-10 flex flex-col md:flex-row gap-6 justify-between items-start">
                    
                    {{-- Left Column: Job Details --}}
                    <div class="flex-1 space-y-3">
                        <div class="flex items-center gap-3">
                            <h3 class="text-xl font-bold text-white group-hover:text-brand-300 transition-colors">
                                {{ $jobApplication->JobVacancy?->title ?? 'Deleted Job' }}
                            </h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full border border-white/10 bg-white/5 text-white/70">
                                {{ $jobApplication->JobVacancy?->type ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4 text-sm text-white/60">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                {{ $jobApplication->JobVacancy?->Company?->name ?? 'Unknown Company' }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $jobApplication->JobVacancy?->location ?? 'Unknown Location' }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Applied on {{ $jobApplication->created_at->format('d M, Y') }}
                            </div>
                        </div>

                        {{-- Resume --}}
                        <div class="flex items-center gap-2 pt-2">
                            <span class="text-sm text-white/40">Resume:</span>
                            <a href="{{ asset('storage/' . $jobApplication->resume->fileUri) }}" target="_blank" class="text-sm text-brand-400 hover:text-brand-300 hover:underline flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                {{ $jobApplication->resume->filename }}
                            </a>
                        </div>
                    </div>

                    {{-- Right Column: Status & AI Score --}}
                    <div class="flex flex-col items-end gap-3 min-w-[200px]">
                        @php
                            $statusColors = match ($jobApplication->status) {
                                'pending' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                'accepted' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                'rejected' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                default => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
                            };
                        @endphp
                        
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border {{ $statusColors }}">
                                {{ $jobApplication->status }}
                            </span>
                            
                            {{-- AI Score Badge --}}
                            <div class="flex items-center gap-1 px-3 py-1 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-300 text-xs font-bold" title="AI Match Score">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                {{ $jobApplication->aiGeneratedScore }}% Match
                            </div>
                        </div>

                        {{-- AI Feedback --}}
                        @if($jobApplication->aiGeneratedFeedback)
                        <div class="mt-2 p-3 rounded-xl bg-white/5 border border-white/10 w-full text-right group/feedback relative">
                            <p class="text-xs text-white/50 italic line-clamp-2 group-hover/feedback:line-clamp-none transition-all">
                                "{{ $jobApplication->aiGeneratedFeedback }}"
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white/5 rounded-2xl border border-white/10 border-dashed">
                <div class="bg-white/5 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-white">No applications yet</h3>
                <p class="text-white/40 mt-1">Start applying for jobs to see them listed here.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $jobApplications->links() }}
    </div>
</x-app-layout>
