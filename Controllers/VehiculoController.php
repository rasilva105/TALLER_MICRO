```php
<?php

require_once __DIR__ . '/../models/Vehiculo.php';

class VehiculoController
{
    private $vehiculo;

    public function __construct()
    {
        $this->vehiculo = new Vehiculo();
    }

    public function registrar($marca, $modelo, $anio, $categoria, $estado)
    {
        return $this->vehiculo->registrarVehiculo(
            $marca,
            $modelo,
            $anio,
            $categoria,
            $estado
        );
    }

    public function listar()
    {
        return $this->vehiculo->listarVehiculos();
    }

    public function disponibles()
    {
        return $this->vehiculo->vehiculosDisponibles();
    }

    public function actualizarEstado($id, $estado)
    {
        return $this->vehiculo->actualizarEstado($id, $estado);
    }
}
```
