@extends('layouts.header')

@section('content')
<div class="container">
    <h1>Kalender Kegiatan</h1>
    <div id="calendar"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route('kegiatan.api') }}',
            eventClick: function(info) {
                alert(
                    'Nama Kegiatan: ' + info.event.title +
                    '\nMulai: ' + info.event.start.toLocaleString() +
                    '\nSelesai: ' + (info.event.end ? info.event.end.toLocaleString() : 'Tidak ditentukan')
                );
            }
        });

        calendar.render();
    });
</script>
@endsection
