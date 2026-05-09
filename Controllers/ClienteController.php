```php
<?php

require_once __DIR__ . '/../models/Cliente.php';

class ClienteController
{
    private $cliente;

    public function __construct()
    {
        $this->cliente = new Cliente();
    }

    public function registrar($nombre, $telefono, $licencia)
    {
        return $this->cliente->registrarCliente(
            $nombre,
            $telefono,
            $licencia
        );
    }

    public function listar()
    {
        return $this->cliente->listarClientes();
    }

    public function buscar($id)
    {
        return $this->cliente->buscarCliente($id);
    }
}
```
