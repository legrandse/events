<x-mail::message>
# Bonjour {{ $shift->user->firstname }}, 

La Fraternité te remercie pour ton aide et ton implication dans l'organisation de l'évènement: **{{ $shift->event->name }}**.<br>
Voici le détail de la tâche prévue:



| Date            | Evènement                 | Tâche                    | Horaire               |
|:-----------------------|:----------------------------------|:-------------------------------|:----------------------------|
|{{ date('d-m',strtotime($shift->event->start)) }}|{{ $shift->event->name }}|{{ $shift->task->name }}|{{ date('H:i',strtotime($shift->start)) }}-{{ date('H:i',strtotime($shift->end)) }}





<br>
Pour La Fraternité,<br>
Le Comité
</x-mail::message>
