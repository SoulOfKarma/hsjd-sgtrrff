import mock from "@/fake-db/mock.js";

// Contact
const data = {
    events: [],
    labels: [
        {
            text: "Vacaciones",
            value: "vacaciones",
            color: "success"
        },
        {
            text: "Dia Administrativo",
            value: "dadministrativo",
            color: "warning"
        },
        {
            text: "Turno Extra",
            value: "turnoextra",
            color: "danger"
        },
        {
            text: "Reemplazo",
            value: "reemplazo",
            color: "dark"
        },
        {
            text: "Turno Noche",
            value: "tnoche",
            color: "primary"
        }
    ]
};

// GET : Calendar Events
mock.onGet("/api/apps/calendar/events").reply(() => {
    return [200, data.events];
});

// POST : Add new events
mock.onPost("/api/apps/calendar/events/").reply(request => {
    // Get event from post data
    const event = JSON.parse(request.data).event;

    const length = data.events.length;
    let lastIndex = 0;
    if (length) {
        lastIndex = data.events[length - 1].id;
    }
    event.id = lastIndex + 1;

    data.events.push(event);

    return [201, { id: event.id }];
});

// GET: Fetch Calendar Labels
mock.onGet("api/apps/calendar/labels").reply(() => {
    return [200, data.labels];
});

// POST: Update Event
mock.onPost(/\/api\/apps\/calendar\/event\/\d+/).reply(request => {
    const e = JSON.parse(request.data).event;
    e.startDate = new Date(e.startDate);
    e.endDate = new Date(e.endDate);

    const eventId = request.url.substring(request.url.lastIndexOf("/") + 1);

    const event = data.events.find(event => event.id == eventId);
    Object.assign(event, e);

    return [200, event];
});

// DELETE: Remove Event
mock.onDelete(/\/api\/apps\/calendar\/event\/\d+/).reply(request => {
    const eventId = request.url.substring(request.url.lastIndexOf("/") + 1);

    const eventIndex = data.events.findIndex(event => event.id == eventId);
    data.events.splice(eventIndex, 1);
    return [200];
});

// POST: Update Dragged Event
mock.onPost(/\/api\/apps\/calendar\/event\/dragged\/\d+/).reply(request => {
    const eventId = request.url.substring(request.url.lastIndexOf("/") + 1);
    const event = data.events.find(event => event.id == eventId);
    const payload = JSON.parse(request.data).payload;

    const draggedDateStart = new Date(payload.date);

    const eventStartDate = new Date(event.startDate).getTime();
    const eventEndDate = new Date(event.endDate).getTime();

    const diff = draggedDateStart - eventStartDate;
    const newEndDate = new Date(eventEndDate + diff);
    event.startDate = draggedDateStart;
    event.endDate = newEndDate;

    return [200, event];
});
