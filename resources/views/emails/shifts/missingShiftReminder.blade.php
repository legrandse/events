<x-mail::message>
# Cher membre du groupe "{{ $event->attendee[0] }}", 

Tu reçois ce mail car un ou plusieurs poste(s) est/sont toujours vacant(s) concernant l'évènement : **{{ $event->name }}** du **{{ date('d-m',strtotime($event->start)) }}**. <br>

| Tâche(s)                    | Horaire               |
|:-------------------------------|:----------------------------|
@foreach($shifts as $shift)
|{{ $shift->task->name  }}|{{ date('H:i',strtotime($shift->start)) }}-{{ date('H:i',strtotime($shift->end))  }}
@endforeach
<br>


Clique ci-dessous afin de parcourir le détail de l'évènement.

<x-mail::button :url="$url">
Détail évènement
</x-mail::button>

Il serait temps de finaliser ce/ces point(s) afin de ne pas être pris au dépourvu le jour de l'évènement.<br>


A vous de jouer !<br>

L'app "MyEventz",<br>

</x-mail::message>
