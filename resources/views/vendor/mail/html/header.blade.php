@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('img/logo-azul.svg') }}" class="logo" alt="Logo PINAI (Plataforma Interativa de Núcleos de Acessibilidade e Inclusão" style="width: 1000px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
