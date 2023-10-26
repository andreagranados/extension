<?php
require_once("modelo/modelo_directores.php");

use SIUToba\rest\rest;
use SIUToba\rest\lib\rest_validador;
use SIUToba\rest\lib\rest_filtro_sql;
use SIUToba\rest\lib\rest_hidratador;


/**
 * Operaciones sobre codirectores
 */
class recurso_codirectores implements SIUToba\rest\lib\modelable # Esta interface es documentativa, puede no estar
{

    static function _get_modelos()
    {
        $codirector_editar = array(
            'id_designacion' => array('type' => 'integer')
        );

        $codirector = array_merge(
            array('id_designacion' => array(
                'type' => 'integer',
                '_validar' => array(rest_validador::TIPO_INT)
            )),
            $codirector_editar
        );

        return $models = array(
            'Codirector' => $codirector,
            'CodirectorEditar' => $codirector_editar
        );
    }

    protected function get_spec_codirector($m = null, $tipo = 'Codirector')
    {
        $m = $this->_get_modelos();
        return $m[$tipo];
    }

    function get_list()
    {
        # Se recopilan parametros del usuario con ayuda de un helper - rest_filtro que genera sql
        $filtro = $this->get_filtro_get_list();
        $where = $filtro->get_sql_where();
        $limit = $filtro->get_sql_limit();
        $order_by = $filtro->get_sql_order_by();

        # Se recuperan datos desde el modelo
        $codirectores = modelo_directores::get_codirectores($where,$order_by,$limit);
        
        # Transformción al formato de la vista de la API
        # Como buen ciudadano, se agrega un header para facilitar el paginado al cliente
        $codirectores = rest_hidratador::hidratar($this->get_spec_codirector(false), $codirectores);
        $cantidad = modelo_directores::get_cant_codirectores($where);
        rest::response()->add_headers(array('Cantidad-Registros' => $cantidad));
        
        # Se escribe la respuesta
        rest::response()->get_list($codirectores);
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

    function get($idPext)
    {
        # Obtengo los datos del modelo
        $modelo = new modelo_directores($idPext);
        $fila = $modelo->get_codirector();
        if ($fila) {
            # La fila contiene exactamente los campos de la especificación
            $fila = rest_hidratador::hidratar_fila($this->get_spec_codirector(), $fila);
        }
        # Se escribe la respuesta
        rest::response()->get($fila);
    }

}