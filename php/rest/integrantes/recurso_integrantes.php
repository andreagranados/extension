<?php
require_once("modelo/modelo_integrantes.php");

use SIUToba\rest\rest;
use SIUToba\rest\lib\rest_validador;
use SIUToba\rest\lib\rest_filtro_sql;
use SIUToba\rest\lib\rest_hidratador;


class recurso_integrantes implements SIUToba\rest\lib\modelable
{

    static function _get_modelos()
    {
        $Integrantes_editar = array(
            'id_designacion' => array('type' => 'integer')
        );

        $Integrante = array_merge(
            array('id_designacion' => array(
                'type' => 'integer',
                '_validar' => array(rest_validador::TIPO_INT)
            )),
            $Integrantes_editar
        );

        return $models = array(
            'Integrante' => $Integrante,
            'IntegranteEditar' => $Integrantes_editar
        );
    }

    protected function get_spec_integrante($m = null, $tipo = 'Integrante')
    {
        $m = $this->_get_modelos();
        return $m[$tipo];
    }


    function get($idIntegrante)
    {
        # Obtengo los datos del modelo
        $modelo = new modelo_integrantes($idIntegrante);
        $fila = $modelo->get_datos();
        if ($fila) {
            # La fila contiene exactamente los campos de la especificación
            $fila = rest_hidratador::hidratar_fila($this->get_spec_integrante(), $fila);
        }
        # Se escribe la respuesta
        rest::response()->get($fila);
    }

    
    function get_list()
    {
        # Se recopilan parametros del usuario con ayuda de un helper - rest_filtro que genera sql
        $filtro = $this->get_filtro_get_list();
        $where = $filtro->get_sql_where();
        $limit = $filtro->get_sql_limit();
        $order_by = $filtro->get_sql_order_by();

        # Se recuperan datos desde el modelo
        $Integrantes = modelo_integrantes::get_integrantes($where, $order_by, $limit);


        # Transformción al formato de la vista de la API
        # Como buen ciudadano, se agrega un header para facilitar el paginado al cliente
        $Integrantes = rest_hidratador::hidratar($this->get_spec_integrante(false), $Integrantes);
        $cantidad = modelo_integrantes::get_cant_integrantes($where);
        rest::response()->add_headers(array('Cantidad-Registros' => $cantidad));

        # Se escribe la respuesta
        rest::response()->get_list($Integrantes);
    }

    /**
     * Se definen los filtros con los que va a funcionar el servicios en caso de querer traer respuestas mas especificas
     * 
     * @return rest_filtro_sql
     */
    protected function get_filtro_get_list()
    {
        $filtro = new rest_filtro_sql();
        #$filtro->agregar_campo("nombre de filtro", "tabla.columna");
        $filtro->agregar_campo("id", "id_designacion");

        $filtro->agregar_campo_ordenable("id_designacion", "id_designacion");
        return $filtro;
    }
}