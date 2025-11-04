<x-mail::message>
# Bienvenu à {{ $owner->shortname }} !

Cher {{ $owner->users[0]->firstname }},

Nous vous remercions pour votre inscription sur **{{ config('app.name')  }}**.

Vous trouverez ci-dessous, le lien vous permettant d'accéder à la plateforme:

**http://{{$owner->shortname}}.{{parse_url(config('app.url'), PHP_URL_HOST)}}**

ou cliquez sur le boutton ci-dessous pour directement y accéder

<x-mail::button :url="'https://' . $owner->shortname . '.' . parse_url(config('app.url'), PHP_URL_HOST)">
    {{ $owner->shortname }}
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
