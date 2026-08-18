<?php

use App\tblPermisoUsuarios;
use App\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Crea un usuario administrador funcional para poder iniciar sesion apenas
 * se levanta el proyecto por primera vez.
 *
 * RUN:      11111111-1
 * Password: Admin123!
 *
 * El sistema no usa un campo "rol" explicito: el nivel de acceso lo define
 * el valor de permiso_usuario en tbl_permiso_usuarios (ver LoginController y
 * resources/js/src/views/pages/Login.vue). permiso_usuario = 2 es el que
 * lleva a las vistas de /adminView.
 */
class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $run = '11111111-1';

        if (Users::where('run', $run)->exists()) {
            $this->command->info("Admin ya existe. RUN: {$run} / Password: Admin123!");
            return;
        }

        // Users.id_edificio / id_servicio / id_unidadEspecifica son NOT NULL
        // pero no tienen llave foranea real hacia estas tablas (salvo
        // servicios -> edificios), asi que primero se aseguran registros
        // minimos para no dejar esos campos apuntando a nada. firstOrCreate
        // evita duplicarlos si el seeder se corre mas de una vez.
        $edificioId = DB::table('edificios')
            ->where('descripcionEdificio', 'Edificio Central')
            ->value('id');
        if (!$edificioId) {
            $edificioId = DB::table('edificios')->insertGetId([
                'descripcionEdificio' => 'Edificio Central',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $servicioId = DB::table('servicios')
            ->where('descripcionServicio', 'Administracion')
            ->value('id');
        if (!$servicioId) {
            $servicioId = DB::table('servicios')->insertGetId([
                'descripcionServicio' => 'Administracion',
                'id_edificio' => $edificioId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $unidadEspId = DB::table('unidad_esps')
            ->where('descripcionUnidadEsp', 'General')
            ->value('id');
        if (!$unidadEspId) {
            $unidadEspId = DB::table('unidad_esps')->insertGetId([
                'descripcionUnidadEsp' => 'General',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $cargoId = DB::table('cargo_usuarios')
            ->where('descripcionCargo', 'Administrador')
            ->value('id');
        if (!$cargoId) {
            $cargoId = DB::table('cargo_usuarios')->insertGetId([
                'descripcionCargo' => 'Administrador',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $admin = Users::firstOrCreate(
            ['run' => $run],
            [
                'email' => 'admin@example.com',
                'nombre' => 'Admin',
                'apellido' => 'Sistema',
                'anexo' => 0,
                'id_cargo' => $cargoId,
                'id_cargo_asociado' => $cargoId,
                'id_edificio' => $edificioId,
                'id_servicio' => $servicioId,
                'id_unidadEspecifica' => $unidadEspId,
                'password' => Hash::make('Admin123!'),
            ]
        );

        tblPermisoUsuarios::updateOrCreate(
            ['run_usuario' => $run],
            [
                'permiso_usuario' => 2,
                'estado_login' => 1,
            ]
        );

        $this->command->info("Admin creado. RUN: {$run} / Password: Admin123!");
    }
}
