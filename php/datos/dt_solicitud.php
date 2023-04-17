<?php

class dt_solicitud extends extension_datos_tabla {

    function get_solicitud($claves = null) {
        $sql = "SELECT  * "
                . "FROM solicitud "
                . "WHERE id_pext= $claves[id_pext] "
                . " AND fecha_solicitud ='". $claves[fecha_solicitud]."'"
                . " AND tipo_solicitud = '".$claves[tipo_solicitud]."' "
                . " AND tipo_cambio = '".$claves[tipo_cambio]."'" 
                . " ORDER BY tipo_solicitud";
        return toba::db('extension')->consultar($sql);
    }
    
    function get_solicitud_proyecto($claves = null) {
        $sql = "SELECT  * "
                . "FROM solicitud "
                . "WHERE id_pext= $claves[id_pext] "
                . " AND fecha_solicitud ='". $claves[fecha_solicitud]."'"
                . " AND tipo_solicitud = '".$claves[tipo_solicitud]."' "
                . " ORDER BY tipo_solicitud";
        return toba::db('extension')->consultar($sql);
    }
    
    function get_solicitud_vigente($claves = null) {
        
        // Falta control de fechas
        $sql = "SELECT  * "
                . "FROM solicitud "
                . "WHERE estado_solicitud='$claves[estado_solicitud]' "
                . "AND id_pext= $claves[id_pext] "
                . "AND cambio_integrante ='". $claves[cambio_integrante]."' "
                . "AND tipo_solicitud = '".$claves[tipo_solicitud]."' ";
       

        return toba::db('extension')->consultar($sql);
    }

     function get_listado($id_pext = null , $where = null) {
        $sql = "SELECT s.id_pext,s.tipo_solicitud,t.descripcion as tipo_solicitud_desc,fecha_solicitud ,estado_solicitud, s.tipo_cambio,c.descripcion as tipo_cambio_desc "
                . "FROM solicitud s, tipo_solicitud t, tipo_cambio c"
                . " WHERE id_pext = $id_pext "
                . " and s.tipo_solicitud=t.id_tipo"
                . " and s.tipo_cambio=c.id_tipo_cambio";
        if (!is_null($where)) {
            $sql .= " AND $where ";
        }

        $sql .= " ORDER BY tipo_solicitud";
        return toba::db('extension')->consultar($sql);
    }

}

?>
