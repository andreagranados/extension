<?php
class modelo_pextension
{
    protected $id;

    static function get_proyectos($where = "", $order_by = "", $limit = "")
    {
        if ($order_by == "") {
            $order_by = "ORDER BY id_pext ASC";
        }
        $sql = "SELECT 
                    pextension.id_pext,
                    seguimiento_central.codigo,
                    pextension.denominacion,
                    seguimiento_ua.nro_resol,
                    seguimiento_ua.fecha_resol,
                    pextension.uni_acad,
                    pextension.fec_desde,
                    pextension.fec_hasta,
                    seguimiento_central.nro_ord_cs,
                    seguimiento_central.res_rect,
                    pextension.expediente,
                    pextension.duracion,
                    pextension.palabras_clave,
                    pextension.objetivo,
                    pextension.id_estado,
                    pextension.financiacion,
                    pextension.monto,
                    seguimiento_central.fecha_rendicion,
                    seguimiento_central.rendicion_monto,
                    seguimiento_central.estado_informe_a,
                    seguimiento_central.estado_informe_f,
                    pextension.id_bases,
                    bases_convocatoria.bases_titulo,
                    bases_convocatoria.tipo_convocatoria
				FROM 
					pextension
                INNER JOIN 
                    seguimiento_ua ON pextension.id_pext = seguimiento_ua.id_pext
                INNER JOIN
                    seguimiento_central ON pextension.id_pext = seguimiento_central.id_pext
                INNER JOIN
                    bases_convocatoria ON pextension.id_bases = bases_convocatoria.id_bases
				WHERE  $where $order_by $limit";

        $datos = toba::db()->consultar($sql);
        return $datos;
    }

    static function get_cant_proyectos($where = "")
    {
        $sql = "SELECT 
					count(*) as cantidad
				FROM 
					pextension
				WHERE $where";
        $datos = toba::db()->consultar_fila($sql);
        return $datos['cantidad'];
    }

    function __construct($id)
    {
        $this->id = (int)$id;
    }


    function get_datos()
    {
        $sql = "SELECT 
                    pextension.id_pext,
                    seguimiento_central.codigo,
                    pextension.denominacion,
                    seguimiento_ua.nro_resol,
                    seguimiento_ua.fecha_resol,
                    pextension.uni_acad,
                    pextension.fec_desde,
                    pextension.fec_hasta,
                    seguimiento_central.nro_ord_cs,
                    seguimiento_central.res_rect,
                    pextension.expediente,
                    pextension.duracion,
                    pextension.palabras_clave,
                    pextension.objetivo,
                    pextension.id_estado,
                    pextension.financiacion,
                    pextension.monto,
                    seguimiento_central.fecha_rendicion,
                    seguimiento_central.rendicion_monto,
                    seguimiento_central.estado_informe_a,
                    seguimiento_central.estado_informe_f,
                    pextension.id_bases,
                    bases_convocatoria.bases_titulo,
                    bases_convocatoria.tipo_convocatoria
                FROM 
                    pextension
                INNER JOIN 
                    seguimiento_ua ON pextension.id_pext = seguimiento_ua.id_pext
                INNER JOIN
                    seguimiento_central ON pextension.id_pext = seguimiento_central.id_pext
                INNER JOIN
                    bases_convocatoria ON pextension.id_bases = bases_convocatoria.id_bases
                WHERE pextension.id_pext = " . quote($this->id);

        $fila = toba::db()->consultar_fila($sql);

        return $fila;
    }
    static function get_ordenados($limit = ""){
        $sql = "SELECT 
                    pextension.id_pext,
                    seguimiento_central.codigo,
                    pextension.denominacion,
                    seguimiento_ua.nro_resol,
                    seguimiento_ua.fecha_resol,
                    pextension.uni_acad,
                    pextension.fec_desde,
                    pextension.fec_hasta,
                    seguimiento_central.nro_ord_cs,
                    seguimiento_central.res_rect,
                    pextension.expediente,
                    pextension.duracion,
                    pextension.palabras_clave,
                    pextension.objetivo,
                    pextension.id_estado,
                    pextension.financiacion,
                    pextension.monto,
                    seguimiento_central.fecha_rendicion,
                    seguimiento_central.rendicion_monto,
                    seguimiento_central.estado_informe_a,
                    seguimiento_central.estado_informe_f,
                    pextension.id_bases,
                    bases_convocatoria.bases_titulo,
                    bases_convocatoria.tipo_convocatoria
                FROM 
                    pextension
                INNER JOIN 
                    seguimiento_ua ON pextension.id_pext = seguimiento_ua.id_pext
                INNER JOIN
                    seguimiento_central ON pextension.id_pext = seguimiento_central.id_pext
                INNER JOIN
                    bases_convocatoria ON pextension.id_bases = bases_convocatoria.id_bases
                WHERE  pextension.id_estado = 'APRB' AND bases_convocatoria.tipo_convocatoria ='O'
                ORDER BY pextension.id_pext ASC $limit";

        $datos = toba::db()->consultar($sql);
        return $datos;
    }
    static function get_cant_odenados($where = "")
    {
        $sql = "SELECT 
					count(*) as cantidad
				FROM 
					pextension
				WHERE $where";
        $datos = toba::db()->consultar_fila($sql);
        return $datos['cantidad'];
    }
}
