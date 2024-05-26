<x-mail::message>
# Orden ubicada correctamente

Gracias por su orden. Enviaremos un correo de verificacion cuando su orden sea enviada. Su id de orden es {{$orden -> id}}

<x-mail::button :url="$url">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
