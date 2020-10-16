<?php

namespace App\Observers;

use App\SolicitudTickets;
use App\SeguimientoSolicitudes;
use Uuid;

class SolicitudObserver
{
    //
    public function creating(SolicitudTickets $SolicitudTickets)
    {

        // $SolicitudTickets->uuid = Uuid::generate()->string;
    }
}
