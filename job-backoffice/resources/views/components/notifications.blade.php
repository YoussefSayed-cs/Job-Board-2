
<div class="relative inline-block text-left">
    <details class="group select-none">
        <summary class="list-none cursor-pointer focus:outline-none flex items-center">
            <div class="relative p-2 rounded-full text-slate-500 hover:text-brand-600 hover:bg-brand-50 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                
                @if($unreadCount > 0)
                    <span class="absolute top-1.5 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                @endif
            </div>
        </summary>

        <!-- Dropdown Content -->
        <div class="absolute right-0 mt-3 w-80 bg-white shadow-2xl rounded-2xl border border-slate-100 z-[9999] overflow-hidden transform origin-top-right transition-all">
            <div class="px-5 py-4 border-b border-slate-100 bg-white flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-sm">Notifications</h3>
                <span class="px-2 py-0.5 bg-brand-50 text-brand-600 rounded-full text-[10px] font-bold">{{ $unreadCount }}</span>
            </div>

            <div class="max-h-[450px] overflow-y-auto custom-scrollbar">
                @forelse($notifications as $notification)
                    <div class="relative border-b border-slate-50 last:border-0 hover:bg-slate-50 transition-colors group">
                        <div onclick="globalHandleNotificationClick('{{ $notification->id }}', '{{ isset($notification->data['application_id']) ? route('job-applications.show', $notification->data['application_id']) : '' }}')"
                           class="flex px-4 py-4 cursor-pointer gap-3 items-start pr-10">
                           
                            <!-- Unread Dot Container -->
                            <div class="shrink-0 pt-1.5">
                                <div class="w-2 h-2 rounded-full {{ $notification->read_at ? 'bg-slate-300' : 'bg-brand-500 shadow-[0_0_8px_rgba(37,99,235,0.4)]' }}" id="notification-dot-{{ $notification->id }}"></div>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-1 min-w-0">
                                <div class="text-sm text-slate-600 leading-snug">
                                    <span class="font-bold text-slate-900">{{ $notification->data['job_seeker_name'] ?? 'Someone' }}</span>
                                    applied for
                                    <span class="text-brand-600 font-bold">{{ $notification->data['job_title'] ?? 'Job' }}</span>
                                </div>
                                <div class="text-[11px] text-slate-400 mt-1.5 flex items-center font-medium">
                                    <svg width="12" height="12" class="mr-1.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('notifications.delete', $notification->id) }}" class="absolute right-2 top-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-slate-400 hover:text-red-500 rounded transition-all">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="py-16 text-center flex flex-col items-center">
                        <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mb-4 text-slate-200">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-slate-400 font-semibold uppercase tracking-wider">Empty Inbox</p>
                        <p class="text-xs text-slate-300 mt-1">We'll notify you when someone applies.</p>
                    </div>
                @endforelse
                
                <div class="border-t border-slate-100">
                    <a href="{{ route('job-applications.index') }}" class="block py-4 text-center text-xs font-bold text-brand-600 bg-slate-50 hover:bg-brand-100 transition-colors">
                        View All Applications
                    </a>
                </div>
            </div>
        </div>
    </details>
</div>

<style>
    /* Hide the default marker for <details> across all browsers */
    details > summary {
        list-style: none;
    }
    details > summary::-webkit-details-marker {
        display: none;
    }
    details > summary::marker {
        display: none;
        content: "";
    }
</style>

<script>
    if (typeof globalHandleNotificationClick === 'undefined') {
        function globalHandleNotificationClick(notificationId, url) {
            // Mark as read visually immediately
            const dot = document.getElementById(`notification-dot-${notificationId}`);
            if (dot && !dot.classList.contains('bg-slate-300')) {
                dot.classList.remove('bg-brand-500');
                dot.classList.add('bg-slate-300');
            }

            // Send request to mark as read
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).catch(err => console.error('Error marking notification as read:', err));

            // Navigate to the application page if URL exists
            if (url && url !== '') {
                window.location.href = url;
            }
        }
    }
</script>
