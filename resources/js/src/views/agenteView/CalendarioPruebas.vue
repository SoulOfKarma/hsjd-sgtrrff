<script>
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import resourceTimelinePlugin from "@fullcalendar/resource-timeline";

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarOptions: {
                plugins: [
                    //dayGridPlugin,
                    //interactionPlugin,
                    resourceTimelinePlugin
                ],
                headerToolbar: {
                    left: "today prev,next",
                    center: "title",
                    right:
                        "resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth"
                },
                selectable: true,
                resourceAreaHeaderContent: "Rooms",
                resources:
                    "https://fullcalendar.io/demo-resources.json?with-nesting&with-colors",
                events:
                    "https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline",
                initialView: "resourceTimelineDay",
                schedulerLicenseKey:
                    "CC-Attribution-NonCommercial-NoDerivatives"
            }
        };
    }
};
</script>
<template>
    <div class="vx-row">
        <vx-card>
            <div class="vx-col w-full">
                <FullCalendar :options="calendarOptions" />
            </div>
        </vx-card>
    </div>
</template>
