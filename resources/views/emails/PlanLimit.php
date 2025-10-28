<x-mail::message>
# Cher(e) {{ $owner->shortname }},

Vous recevez ce message pour signaler que votre plan {{ $owner->product->name}} a atteint ses limites.<br>
Nous vous invitons à passer à une autre offre afin de continuer à bénéficier des meilleurs services.<br>

Vous avez la possibilité de souscrire un plan adapté ci-dessous.

<x-mail::button :url="$url">
Plan
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
