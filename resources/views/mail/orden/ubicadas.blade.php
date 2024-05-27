<x-mail::message>
# Orden ubicada correctamente

Gracias por su orden. El id de orden es {{$orden -> id}}

<x-mail::button :url="$url">
Ver Orden
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
