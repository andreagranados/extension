<?php

class dt_bases_convocatoria extends extension_datos_tabla {

    function get_listado($where = null) {
        $sql = "SELECT
			t_bc.id_bases,
			t_bc.convocatoria,
			t_bc.objetivo,
			t_bc.eje_tematico,
			t_bc.destinatarios,
			t_bc.integrantes,
			t_bc.monto,
                        t_bc.monto_max,
			t_bc.duracion,
			t_bc.fecha,
                        t_bc.fecha_desde,
                        t_bc.fecha_hasta,
                        t_bc.fecha_lim_modif,
			t_bc.evaluacion,
			t_bc.adjudicacion,
			t_bc.consulta,
			t_bc.bases_titulo,
			t_bc.ordenanza,
			t_c.descripcion,
                        t_bc.tiene_monto
		FROM
			bases_convocatoria as t_bc
                        LEFT OUTER JOIN tipo_convocatoria as t_c ON (t_c.id_conv = t_bc.tipo_convocatoria)";
        if (!is_null($where)) {
            $sql .= "
			WHERE
				$where";
        }
        $sql .= "
		ORDER BY fecha_desde desc";

        return toba::db('extension')->consultar($sql);
    }

    function get_titulo() {
        $sql = "SELECT id_bases, bases_titulo "
                . "FROM bases_convocatoria as b_c "
                . " ORDER BY convocatoria";
        return toba::db('extension')->consultar($sql);
    }
    
//    function get_convocatorias_vigentes($id_estado =null,$where = null) {
//
//        if(is_null($id_estado) || $id_estado=='FORM'){
//            $where =$where ." AND fecha_desde <= current_date AND fecha_hasta >= current_date ";
//        }
//
//        $sql = "SELECT id_bases, bases_titulo "
//                . "FROM bases_convocatoria as b_c "
//                .  $where
//                . "ORDER BY convocatoria";
//        return toba::db('extension')->consultar($sql);
//    }
     function get_convocatorias_vigentes() {
        $sql = "SELECT id_bases, bases_titulo "
                . " FROM bases_convocatoria as b_c "
                . " WHERE fecha_desde <= current_date AND fecha_hasta >= current_date "
                . " ORDER BY convocatoria";
        return toba::db('extension')->consultar($sql);
    }
     function get_convocatorias_vigentes_para_modf() {
            $sql = "SELECT id_bases, bases_titulo "
                    . " FROM bases_convocatoria as b_c "
                    . " WHERE fecha_desde <= current_date AND fecha_lim_modif >= current_date "
                    . " ORDER BY convocatoria";
            return toba::db('extension')->consultar($sql);
        }
    function get_duracion($id_bases = null) {

        if (!is_null($id_bases)) {
            $sql = "SELECT duracion_convocatoria ,id_bases FROM bases_convocatoria as b_c "
                    . "Where b_c.id_bases= " . $id_bases;
          
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }

        return $res;
    }
    
    function get_monto($id_base = null){
        $sql = "SELECT monto_max FROM bases_convocatoria WHERE id_bases = $id_base";
        return toba::db('extension')->consultar($sql);
        
    }

    function get_datos($id_bases = null) {
        $sql = "SELECT
			t_bc.id_bases,
			t_bc.convocatoria,
			t_bc.objetivo,
			t_bc.eje_tematico,
			t_bc.destinatarios,
			t_bc.integrantes,
			t_bc.monto,
                        t_bc.monto_max,
			t_bc.duracion,
			t_bc.fecha,
                        t_bc.fecha_desde,
                        t_bc.fecha_hasta,
                        t_bc.fecha_lim_modif,
			t_bc.evaluacion,
			t_bc.adjudicacion,
			t_bc.consulta,
			t_bc.bases_titulo,
			t_bc.ordenanza,
			t_c.descripcion,
                        t_bc.tiene_monto
		FROM
			bases_convocatoria as t_bc
                        LEFT OUTER JOIN tipo_convocatoria as t_c ON (t_c.id_conv = t_bc.tipo_convocatoria)";
        if (!is_null($id_bases)) {
            $sql .= "
			WHERE t_bc.id_bases=
				$id_bases";
        }
        return toba::db('extension')->consultar($sql);
    }

}

?>