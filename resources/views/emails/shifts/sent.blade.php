<x-mail::message>
# Bonjour {{ $username }}, 


Le comité de La Fraternité a besoin de toi pour l'organisation de son prochain événement : **{{ $event }}** qui aura lieu le **{{ $date  }}**.<br>
Ton aide est essentielle pour en assurer son succès.<br>
Clique ci-dessous dès maintenant pour en savoir plus sur les tâches disponibles.



<x-mail::button :url="$url">
Tâches bénévoles
</x-mail::button>

Merci d'avance pour votre aide !<br>
Pour La Fraternité,<br>
Le comité
</x-mail::message>
