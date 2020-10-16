<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\SeguimientoSolicitudes;
use Illuminate\Queue\SerializesModels;

class AutoRespuesta extends Mailable
{
    use Queueable, SerializesModels;

    public $seguimiento;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SeguimientoSolicitudes $seguimiento)
    {
        $this->seguimiento = $seguimiento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Sistema de Gestion de Tickets RRFF - Auto Respuesta')->view('mails.AutoRespuesta');
    }
}
