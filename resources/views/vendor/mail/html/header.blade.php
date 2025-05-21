@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'La Fraternité')
 <img src="{{ asset('img/logo.png') }}" width="25%" class="logo" alt="La Fraternité Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
