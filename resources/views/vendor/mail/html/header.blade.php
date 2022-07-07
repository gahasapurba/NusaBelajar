<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'NusaBelajar')
<img src="https://i.ibb.co/GJyymL2/NB2.png" style="object-fit: cover;" width="300" height="100" alt="NusaBelajar">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
