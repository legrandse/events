<x-mail::message>
# Bonjour {{ $owner->shortname }}

Vous recevez ce message pour signaler que votre plan **{{ $owner->product->name}}** a atteint ses limites.<br><br>
Nous vous invitons à passer à une autre offre afin de continuer à bénéficier des meilleurs services de {{config('app.name')}}.<br><br>
Vous avez la possibilité de souscrire un plan adapté ci-dessous.

<x-mail::button :url="config('app.url')">
Upgrade your Plan
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
