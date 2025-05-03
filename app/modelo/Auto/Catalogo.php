<?php
namespace app\modelo\Auto;

require_once 'Hibrido.php';
require_once 'Camioneta.php';
require_once 'Deportivo.php';
require_once 'Electrico.php';

class Catalogo {
    private $hibrido;
    private $camioneta;
    private $deportivo;
    private $electrico;

    public function __construct($hibrido, $camioneta, $deportivo, $electrico) {
        $this->hibrido = $hibrido;
        $this->camioneta = $camioneta;
        $this->deportivo = $deportivo;
        $this->electrico = $electrico;
    }

    public function mostrarAuto($tipo) {
        switch ($tipo) {
            case 'hibrido': return $this->hibrido->mostrar();
            case 'camioneta': return $this->camioneta->mostrar();
            case 'deportivo': return $this->deportivo->mostrar();
            case 'electrico': return $this->electrico->mostrar();
            default: return "Tipo no válido";
        }
    }

    public function listarAutos() {
        return $this->hibrido->mostrar() . "<br>" .
               $this->camioneta->mostrar() . "<br>" .
               $this->deportivo->mostrar() . "<br>" .
               $this->electrico->mostrar();
    }
}
?>