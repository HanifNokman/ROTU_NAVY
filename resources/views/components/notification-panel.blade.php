@props(['notifications'])

<div class="bg-white rounded-lg shadow-md p-6" id="notification-panel">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            Notifications
            @if($notifications->where('read_at', null)->count() > 0)
                <span id="unread-badge" class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $notifications->where('read_at', null)->count() }}
                </span>
            @endif
        </h3>

        @if($notifications->count() > 0)
            <button type="button" id="mark-all-read-btn" class="text-sm text-blue-600 hover:text-blue-800">
                Mark all as read
            </button>
        @endif
    </div>

    <div class="space-y-3 max-h-96 overflow-y-auto" id="notifications-list">
        @forelse($notifications as $notification)
            <div class="notification-item border-l-4 {{ $notification->read_at ? 'border-gray-300 bg-gray-50' : 'border-blue-500 bg-blue-50' }} p-4 rounded-r-lg transition-all hover:shadow-md" data-notification-id="{{ $notification->id }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-1">
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
                                <svg class="w-5 h-5 mr-2 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            @elseif(($notification->data['icon'] ?? '') === 'alert')
                                <svg class="w-5 h-5 mr-2 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            @elseif(($notification->data['icon'] ?? '') === 'warning')
                                <svg class="w-5 h-5 mr-2 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif(($notification->data['icon'] ?? '') === 'calendar')
                                <svg class="w-5 h-5 mr-2 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 mr-2 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif

                            <h4 class="font-semibold text-gray-900">
                                {{ $notification->data['title'] ?? 'Notification' }}
                            </h4>
                        </div>

                        <p class="text-sm text-gray-700 mb-2">
                            {{ $notification->data['message'] ?? 'No message available' }}
                        </p>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>

                            @if(isset($notification->data['url']))
                                <a href="{{ $notification->data['url'] }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    View Details →
                                </a>
                            @endif
                        </div>
                    </div>

                    @if(!$notification->read_at)
                        <button type="button" class="mark-as-read-btn ml-3 text-gray-400 hover:text-gray-600" title="Mark as read" data-notification-id="{{ $notification->id }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p class="text-lg font-medium">No notifications</p>
                <p class="text-sm">You're all caught up!</p>
            </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Only run if notification panel exists on the page
    const notificationPanel = document.getElementById('notification-panel');
    if (!notificationPanel) return;

    // Get CSRF token from meta tag
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenMeta) return;

    const csrfToken = csrfTokenMeta.getAttribute('content');

    // Mark single notification as read
    document.addEventListener('click', function(e) {
        if (e.target.closest('.mark-as-read-btn')) {
            const button = e.target.closest('.mark-as-read-btn');
            const notificationId = button.getAttribute('data-notification-id');

            fetch(`/notifications/${notificationId}/read`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the notification item visually
                    const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (notificationItem) {
                        notificationItem.classList.remove('border-blue-500', 'bg-blue-50');
                        notificationItem.classList.add('border-gray-300', 'bg-gray-50');
                        button.remove();
                    }

                    // Update unread badge
                    updateUnreadBadge();
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }
    });

    // Mark all notifications as read
    const markAllReadBtn = document.getElementById('mark-all-read-btn');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update all notification items visually
                    const unreadItems = document.querySelectorAll('.notification-item.border-blue-500');
                    unreadItems.forEach(item => {
                        item.classList.remove('border-blue-500', 'bg-blue-50');
                        item.classList.add('border-gray-300', 'bg-gray-50');
                        const button = item.querySelector('.mark-as-read-btn');
                        if (button) button.remove();
                    });

                    // Update unread badge
                    updateUnreadBadge();

                    // Hide the "Mark all as read" button
                    markAllReadBtn.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
            });
        });
    }

    // Function to update unread badge count
    function updateUnreadBadge() {
        const unreadCount = document.querySelectorAll('.notification-item.border-blue-500').length;
        const badge = document.getElementById('unread-badge');

        if (unreadCount === 0 && badge) {
            badge.remove();
        } else if (badge) {
            badge.textContent = unreadCount;
        }
    }
});
</script>
