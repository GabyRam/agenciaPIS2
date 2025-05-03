<?php
namespace app\modelo\Usuario;

use app\modelo\Auto\Catalogo;

class Gerente {
    private $nombre;
    private $email;

    public function __construct($nombre, $email) {
        $this->nombre = $nombre;
        $this->email = $email;
    }

    public function consultarCatalogo(Catalogo $catalogo): string {
        $tipos = ['hibrido', 'camioneta', 'deportivo', 'electrico'];
    
        $tarjetasHTML = '';
        foreach ($tipos as $tipo) {
            $autoHTML = $catalogo->mostrarAuto($tipo);
    
            // Asume que tienes imágenes con nombres img/hibrido.png, img/camioneta.png, etc.
            $imagen = "img/{$tipo}.png";
    
            $tarjetasHTML .= "
                <div class='card'>
                    <img src='{$imagen}' alt='Auto {$tipo}'>
                    <div class='info'>
                        {$autoHTML}
                    </div>
                </div>
            ";
        }
    
        return $tarjetasHTML;
    }
    

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getEmail(): string {
        return $this->email;
    }
}
