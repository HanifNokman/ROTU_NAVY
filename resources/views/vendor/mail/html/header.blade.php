@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets\logo\PSS-LOGO.png') }}" class="logo" alt="ROTU NAVY Logo" style="height: 75px; width: auto;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
