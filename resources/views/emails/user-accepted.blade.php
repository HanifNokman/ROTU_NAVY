<x-mail::message>
# Congratulations! Your Account Has Been Accepted

Dear {{ $user->name }},

We are pleased to inform you that your {{ $role }} account has been accepted and is now active.

**Account Details:**
- **Name:** {{ $user->name }}
- **Email:** {{ $user->email }}
- **Role:** {{ $role }}

You can now log in to your account and access all the features available to {{ strtolower($role) }}s.

<x-mail::button :url="route('login')" color="primary">
Login to Your Account
</x-mail::button>

If you have any questions or need assistance, please don't hesitate to contact our support team.

Best regards,
{{ config('app.name') }} Team

<x-mail::subcopy>
If you're having trouble clicking the "Login to Your Account" button, copy and paste the URL below into your web browser:
[{{ route('login') }}]({{ route('login') }})
</x-mail::subcopy>
</x-mail::message>
