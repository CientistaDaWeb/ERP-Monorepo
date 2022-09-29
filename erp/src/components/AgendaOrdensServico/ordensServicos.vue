<template>
  <div>
    <FullCalendar
      ref="fullCalendar"
      default-view="dayGridMonth"
      :header="{
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      }"
      :plugins="calendarPlugins"
      :weekends="calendarWeekends"
      :events="calendarEvents"
      @dateClick="handleDateClick"
      locale="pt-br"
    />
  </div>
</template>
<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
  name: 'AgendaOrdensServicos',
  components: {
    FullCalendar
  },
  data: () => ({
    calendarPlugins: [
      dayGridPlugin,
      timeGridPlugin,
      interactionPlugin
    ],
    calendarWeekends: true,
    calendarEvents: [
      {
        title: 'Event Now', start: new Date()
      }
    ]
  }),
  methods: {
    handleDateClick (arg) {
      if (confirm('Would you like to add an event to ' + arg.dateStr + ' ?')) {
        this.calendarEvents.push({ // add new event data
          title: 'New Event',
          start: arg.date,
          allDay: arg.allDay
        })
      }
    }
  }
}

</script>

<style lang='stylus'>
  @import '~@fullcalendar/core/main.css';
  @import '~@fullcalendar/daygrid/main.css';
  @import '~@fullcalendar/timegrid/main.css';
</style>
