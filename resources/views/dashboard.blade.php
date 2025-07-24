@php
    $role = auth()->user()->role ?? 'cadet';
    $route = match ($role) {
        'cadet' => 'cadet.dashboard',
        'instructor' => 'instructor.dashboard',
        'admin' => 'admin.dashboard',
        default => 'cadet.dashboard'
    };
@endphp
<meta http-equiv="refresh" content="0; url={{ route($route) }}">
