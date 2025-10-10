<x-mail::message>
# Bonjour {{ $user['firstname'] }}, 

Tu reçois ce mail pour te rappeler la/les tâche(s) au(x)quelle(s) tu participes concernant l'évènement : **{{ $event->name }}**. <br>

| Date            | Evènement                 | Tâche                    | Horaire               |
|:-----------------------|:----------------------------------|:-------------------------------|:----------------------------|
@foreach($shifts as $shift)
|{{ date('d-m',strtotime($shift->task->event->start)) }}|{{ $shift->task->event->name }}|{{ $shift->task->name }}|{{ date('H:i',strtotime($shift->start)) }}-{{ date('H:i',strtotime($shift->end)) }}
@endforeach
<br>


Clique ci-dessous afin de parcourir le détail de l'évènement.

<x-mail::button :url="$url">
Détail évènement
</x-mail::button>

Merci encore pour ton aide !<br>
Pour La Fraternité,<br>
Le comité
</x-mail::message>
