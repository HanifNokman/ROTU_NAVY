@props(['notifications'])

<div class="relative" x-data="{ open: false }" @click.away="open = false">
    {{-- Notification Bell Button --}}
    <button
        @click="open = !open"
        class="relative p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors"
        title="Notifications">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>

        {{-- Unread Badge --}}
        @if($notifications->where('read_at', null)->count() > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                {{ $notifications->where('read_at', null)->count() }}
            </span>
        @endif
    </button>

    {{-- Dropdown Panel (Post-it Note Style) --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute left-0 mt-2 w-80 bg-yellow-50 border-2 border-yellow-300 rounded-lg shadow-xl z-50"
        style="display: none;">

        {{-- Header --}}
        <div class="bg-yellow-100 border-b-2 border-yellow-300 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <h3 class="font-bold text-yellow-900">Notifications</h3>
                @if($notifications->where('read_at', null)->count() > 0)
                    <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-semibold">
                        {{ $notifications->where('read_at', null)->count() }}
                    </span>
                @endif
            </div>

            @if($notifications->count() > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-yellow-800 hover:text-yellow-900 font-medium underline">
                        Clear all
                    </button>
                </form>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications->take(5) as $notification)
                <div class="border-b border-yellow-200 p-3 {{ $notification->read_at ? 'bg-yellow-50' : 'bg-white' }} hover:bg-yellow-100 transition-colors">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                {{-- Icon --}}
                                @php
                                    $iconClass = match($notification->data['icon'] ?? 'info') {
                                        'shield' => 'text-blue-600',
                                        'alert' => 'text-orange-600',
                                        'warning' => 'text-red-600',
                                        'calendar' => 'text-green-600',
                                        default => 'text-gray-600'
                                    };
                                @endphp

                                @if(($notification->data['icon'] ?? '') === 'shield')
                                    <svg class="w-4 h-4 flex-shrink-0 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                @elseif(($notification->data['icon'] ?? '') === 'alert')
                                    <svg class="w-4 h-4 flex-shrink-0 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                @elseif(($notification->data['icon'] ?? '') === 'warning')
                                    <svg class="w-4 h-4 flex-shrink-0 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif(($notification->data['icon'] ?? '') === 'calendar')
                                    <svg class="w-4 h-4 flex-shrink-0 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif

                                <h4 class="font-semibold text-sm text-gray-900 truncate">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h4>
                            </div>

                            <p class="text-xs text-gray-700 line-clamp-2 mb-1">
                                {{ $notification->data['message'] ?? 'No message available' }}
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>

                                @if(isset($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                        View →
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if(!$notification->read_at)
                            <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}" class="flex-shrink-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-gray-400 hover:text-gray-600 p-1" title="Mark as read">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <p class="font-medium text-sm">All clear!</p>
                    <p class="text-xs">No new notifications</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if($notifications->count() > 5)
            <div class="bg-yellow-100 border-t-2 border-yellow-300 px-4 py-2 text-center">
                <a href="#" class="text-xs text-yellow-800 hover:text-yellow-900 font-medium">
                    View all {{ $notifications->count() }} notifications
                </a>
            </div>
        @endif
    </div>
</div>
