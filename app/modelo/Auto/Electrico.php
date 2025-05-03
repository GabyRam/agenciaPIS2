<?php
namespace app\modelo\Auto;

class Electrico {
    private $marca;
    private $modelo;
    private $precio;
    
    public function __construct($marca, $modelo, $precio) {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->precio = $precio;
    }
    
    public function getMarca() {
        return $this->marca;
    }
    
    public function getModelo() {
        return $this->modelo;
    }
    
    public function getPrecio() {
        return $this->precio;
    }
    
    public function mostrar() {
        return "Auto Eléctrico - Marca: {$this->marca}, Modelo: {$this->modelo}, Precio: \${$this->precio}";
    }
}
?>