<x-mail::message>
# Cher(e) {{ $user->firstname }},

La Fraternité te remercie vivement pour ton inscription.<br>
Nous ferons appel à toi prochainement pour les futurs évènements du village.<br>

En attendant, tu peux toujours visualiser ceux-ci en cliquant ci-dessous.

<x-mail::button :url="$url">
Evènements
</x-mail::button>

Pour le comité,<br>
{{ config('app.name') }}
</x-mail::message>
