<?php
require_once("modelo/modelo_pextension.php");

use SIUToba\rest\rest;
use SIUToba\rest\lib\rest_validador;
use SIUToba\rest\lib\rest_filtro_sql;
use SIUToba\rest\lib\rest_hidratador;


/**
 * Operaciones sobre Proyectos
 */
class recurso_proyectos implements SIUToba\rest\lib\modelable # Esta interface es documentativa, puede no estar
{

    static function _get_modelos()
    {
        $proyecto_editar = array(
            'id_pext' => array(
                'type' => 'integer',
                '_validar' => array(
                    rest_validador::OBLIGATORIO,
                    rest_validador::TIPO_INT
                )
            ),
            'codigo' => array('type' => 'sting'),
            'denominacion' => array('type' => 'string'),
            'nro_resol' => array('type' => 'string'),
            'fecha_resol' => array('type' => 'date'),
            'uni_acad' => array('type' => 'string'),
            'fec_desde' => array('type' => 'date'),
            'fec_hasta' => array('type' => 'date'),
            'nro_ord_cs' => array('type' => 'string'),
            'res_rect' => array('type' => 'string'),
            'expediente' => array('type' => 'string'),
            'duracion' => array('type' => 'integer'),
            'palabras_clave' => array('type' => 'string'),
            'objetivo' => array('type' => 'string'),
            'id_estado' => array('type' => 'string'),
            'financiacion' => array('type' => 'boolean'),
            'monto' => array('type' => 'numerico'),
            'fecha_rendicion' => array('type' => 'date'),
            'rendicion_monto' => array('type' => 'float'),
            'estado_informe_a' => array('type' => 'string'),
            'estado_informe_f' => array('type' => 'string'),
            'id_bases' => array('type' => 'string'),
            'bases_titulo' => array('type' => 'string'),
            'tipo_convocatoria' => array('type' => 'string')
        );

        $proyecto = array_merge(
            array('id_pext' => array(
                'type' => 'integer',
                '_validar' => array(rest_validador::TIPO_INT)
            )),
            $proyecto_editar
        );

        return $models = array(
            'Proyecto' => $proyecto,
            'ProyectoEditar' => $proyecto_editar
        );
    }

    protected function get_spec_proyecto($m = null, $tipo = 'Proyecto')
    {
        $m = $this->_get_modelos();
        return $m[$tipo];
    }

    /**
     * Se consume en GET /proyectos/{id}
     *  
     * @param_query $idproyecto integer
     * 
     * @summary Retorna datos de una proyecto
     * 
     * @responses 200 {"$ref": "Proyecto"} Proyecto
     * @responses 400 No existe el proyecto
     */
    function get($idproyecto)
    {
        # Obtengo los datos del modelo
        $modelo = new modelo_pextension($idproyecto);
        $fila = $modelo->get_datos();
        if ($fila) {
            # La fila contiene exactamente los campos de la especificación
            $fila = rest_hidratador::hidratar_fila($this->get_spec_proyecto(), $fila);
        }
        # Se escribe la respuesta
        rest::response()->get($fila);
    }

    /**
     * Se consume en GET /proyectos/
     *
     * @param_query $nombre string Se define como 'condicion;valor' donde 'condicion' puede ser contiene|no_contiene|comienza_con|termina_con|es_igual_a|es_distinto_de
     * @param_query $fecha_nac string Se define como 'condicion;valor' donde 'condicion' puede ser es_menor_que|es_menor_igual_que|es_igual_a|es_distinto_de|es_mayor_igual_que|es_mayor_que|entre
     * @param_query $limit integer Limitar a esta cantidad de registros
     * @param_query $page integer Limitar desde esta pagina
     * @param_query $order string +/-campo,...
     * 
     * @notes Retorna un header 'Total-Registros' con la cantidad total de registros a paginar
     * 
     * @responses 200 array {"$ref":"Proyecto"}
     */
    function get_list()
    {
        # Se recopilan parametros del usuario con ayuda de un helper - rest_filtro que genera sql
        $filtro = $this->get_filtro_get_list();
        $where = $filtro->get_sql_where();
        $limit = $filtro->get_sql_limit();
        $order_by = $filtro->get_sql_order_by();

        # Se recuperan datos desde el modelo
        $proyectos = modelo_pextension::get_proyectos($where, $order_by, $limit);


        # Transformción al formato de la vista de la API
        # Como buen ciudadano, se agrega un header para facilitar el paginado al cliente
        $proyectos = rest_hidratador::hidratar($this->get_spec_proyecto(false), $proyectos);
        $cantidad = modelo_pextension::get_cant_proyectos($where);
        rest::response()->add_headers(array('Cantidad-Registros' => $cantidad));

        # Se escribe la respuesta
        rest::response()->get_list($proyectos);
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
        $filtro->agregar_campo("id", "pextension.id_pext");
        $filtro->agregar_campo("denominacion", "pextension.denominacion");
        $filtro->agregar_campo("unidad", "pextension.uni_acad");
        $filtro->agregar_campo("estado", "pextension.id_estado");
        $filtro->agregar_campo("bases", "pextension.id_bases");
        $filtro->agregar_campo("tipo_conv", "bases_convocatoria.tipo_convocatoria");

        $filtro->agregar_campo_ordenable("id_pext", "pextension.id_pext");
        return $filtro;
    }
}