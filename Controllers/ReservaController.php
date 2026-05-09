```php
<?php

require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../models/Vehiculo.php';

class ReservaController
{
    private $reserva;
    private $vehiculo;

    public function __construct()
    {
        $this->reserva = new Reserva();
        $this->vehiculo = new Vehiculo();
    }

    public function crearReserva($clienteId, $vehiculoId, $fechaInicio, $fechaFin)
    {
        $resultado = $this->reserva->registrarReserva(
            $clienteId,
            $vehiculoId,
            $fechaInicio,
            $fechaFin
        );

        if ($resultado) {
            $this->vehiculo->actualizarEstado($vehiculoId, "Alquilado");
        }

        return $resultado;
    }

    public function devolverVehiculo($vehiculoId)
    {
        return $this->vehiculo->actualizarEstado($vehiculoId, "Disponible");
    }

    public function historial()
    {
        return $this->reserva->listarReservas();
    }
}
```