<?php

namespace app\controllers;

use app\models\mainModel;

class searchController extends mainModel
{

    # Controlador de los módulos de búsqueda #

    public function modulosBusquedaControlador($modulo)
    {

        $listaModulos = ['userSearch'];

        if (in_array($modulo, $listaModulos)) {
            return false;
        } else {
            return true;
        }
    }


    # Controlador para iniciar la busqueda #
    public function iniciarBuscadorControlador()
    {
        $url = $this->limpiarCadena($_POST['modulo_url']);
        $texto = $this->limpiarCadena($_POST['txt_buscador']);

        if ($this->modulosBusquedaControlador($url)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se pudo procesar la peticion",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($texto == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "Introduce un termino de busqueda valido",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando termino de busqueda
        if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}", $texto)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "El termino de busqueda no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $_SESSION['userSearch'] = $texto;

        $alerta = [
            "tipo" => "redireccionar",
            "url" => APP_URL . $url . "/"
        ];
        return json_encode($alerta);
    }

    # Controlador para eliminar la busqueda #
    public function eliminarBuscadorControlador()
    {

        $url = $this->limpiarCadena($_POST['modulo_url']);

        if ($this->modulosBusquedaControlador($url)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrio un error inesperado",
                "texto" => "No se pudo procesar la peticion",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        unset($_SESSION[$url]);

        $alerta = [
            "tipo" => "redireccionar",
            "url" => APP_URL . $url . "/"
        ];
        return json_encode($alerta);
    }
}
