<?php
namespace app\modelo;

class Catalogo {
    private $nombre;
    private $listaAutos;
    
    public function __construct($nombre) {
        $this->nombre = $nombre;
        $this->listaAutos = [];
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function agregarAuto($auto) {
        $this->listaAutos[] = $auto;
        return true;
    }
    
    public function eliminarAuto($indice) {
        if (isset($this->listaAutos[$indice])) {
            unset($this->listaAutos[$indice]);
            $this->listaAutos = array_values($this->listaAutos); // Reindexar el array
            return true;
        }
        return false;
    }
    
    public function mostrarAuto($indice) {
        if (isset($this->listaAutos[$indice])) {
            return $this->listaAutos[$indice]->mostrar();
        }
        return "Auto no encontrado";
    }
    
    public function listarAutos() {
        $resultado = "Catálogo: {$this->nombre}\n";
        if (empty($this->listaAutos)) {
            $resultado .= "No hay autos en el catálogo";
        } else {
            foreach ($this->listaAutos as $indice => $auto) {
                $resultado .= ($indice + 1) . ". " . $auto->mostrar() . "\n";
            }
        }
        return $resultado;
    }
    
    public function getAuto($tipo) {
        foreach ($this->listaAutos as $auto) {
            if (get_class($auto) === $tipo) {
                return $auto;
            }
        }
        return null;
    }
}
?>