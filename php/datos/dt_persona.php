<?php
class dt_persona extends extension_datos_tabla {

    function minimo_docum() {
        $sql = "select min(nro_docum) as num from persona";
        $resul = toba::db('extension')->consultar($sql);
        return $resul[0]['num'];
    }

    function existe($tipo, $nro) {
        $sql = "select * from persona"
                . " where tipo_docum='" . $tipo . "'"
                . " and nro_docum=" . $nro;
        $resul = toba::db('extension')->consultar($sql);
        if (count($resul) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_cuil($sexo, $doc) {
        switch ($sexo) {
            case 'F': $xy = 27;
                break;

            case 'M': $xy = 20;
                break;
        }
        $arreglo = array(
            1 => 5,
            2 => 4,
            3 => 3,
            4 => 2,
            5 => 7,
            6 => 6,
            7 => 5,
            8 => 4,
            9 => 3,
            10 => 2,
        );
        $suma = 0;
        $cadena = $xy . $doc;
        $long = strlen($cadena);
        $i = 1;
        while ($i <= $long) {
            $suma = $suma + (substr($cadena, $i, 1) * $arreglo[$i]);
            $i++;
        }
    }

    function get_descripciones() {
        $sql = "SELECT p.*,trim(apellido)||', '||trim(nombre) as descripcion FROM persona p ORDER BY apellido,nombre";
        return toba::db('extension')->consultar($sql);
    }

    //devuelve un listado de todos los docentes y personas (unifica ambas tablas)
    //si esta en la tabla docente y tambien en la tabla persona aparece solo una vez
    function get_descripciones_p($where = null) {
        if (!is_null($where)) {
            $where = ' WHERE ' . $where;
        } else {
            $where = '';
        }

        $sql = "select cuil,max(agente) as agente 
                    from (select case when p.nro_docum>0 then calculo_cuil(p.tipo_sexo,p.nro_docum) else docum_extran end as cuil, apellido,nombre,nro_docum,trim(p.apellido)||', '||trim(p.nombre) as agente
                          from persona p 
                          $where
                          UNION
                          select nro_cuil1||'-'||nro_cuil||'-'||nro_cuil2 as cuil,apellido,nombre,nro_docum,trim(apellido)||', '||trim(nombre) as agente
                          from docente d 
                          $where
                       )sub
                    group by cuil
                    order by agente";
        return toba::db('extension')->consultar($sql);
    }

    
//    function get_listado($filtro = null){
//            if(!is_null($filtro)){
//                $where = "WHERE $filtro";
//            }else{
//                $where = "";
//            }
//		$sql = "SELECT
//			t_p.apellido,
//			t_p.nombre,
//			t_p.nro_tabla,
//			t_p.tipo_docum,
//			t_p.nro_docum,
//			t_p.tipo_sexo,
//			t_p1.nombre as pais_nacim_nombre,
//			t_p2.descripcion_pcia as pcia_nacim_nombre,
//			t_p.fec_nacim,
//			t_p.docum_extran,
//                        t_p.telefono,
//                        t_p.mail
//		FROM
//			persona as t_p	
//                        LEFT OUTER JOIN (SELECT t_p1.nombre, t_p1.codigo_pais FROM dblink('".$this->dblink_designa()."','SELECT nombre,codigo_pais FROM pais') as t_p1 (nombre CHARACTER VARYING(40), codigo_pais CHARACTER(2))) as t_p1"
//                        . " ON (t_p.pais_nacim = t_p1.codigo_pais)"
//                        . " LEFT OUTER JOIN (SELECT t_p2.codigo_pcia,t_p2.descripcion_pcia FROM dblink('".$this->dblink_designa()."', 'SELECT codigo_pcia, descripcion_pcia FROM provincia') as t_p2 (codigo_pcia INTEGER,descripcion_pcia CHARACTER(40))) as t_p2"
//                        . " ON (t_p.pcia_nacim = t_p2.codigo_pcia) "
//                 .$where
//                        
//		." ORDER BY nombre";
//                /*
//		if (count($where)>0) {
//			$sql = sql_concatenar_where($sql, $where);
//		}*/
//		return toba::db('extension')->consultar($sql);
//	}

    function get_listado($filtro = null){
            if(!is_null($filtro)){
                $where = "WHERE $filtro";
            }else{
                $where = "";
            }
            
	    $sql = "SELECT
			t_p.apellido,
			t_p.nombre,
			t_p.nro_tabla,
			t_p.tipo_docum,
			t_p.nro_docum,
			t_p.tipo_sexo,
			t_p.fec_nacim,
			t_p.docum_extran,
                        t_p.telefono,
                        t_p.mail
		FROM
			persona as t_p	"
                        
                 .$where
                        
		." ORDER BY nombre";
               
	    return toba::db('extension')->consultar($sql);
	}


    
//    function get_listado_comienzan_a() {
//        $sql = "SELECT
//                                        t_p.apellido,
//                                        t_p.nombre,
//                                        t_p.nro_tabla,
//                                        t_p.tipo_docum,
//                                        t_p.nro_docum,
//                                        case when t_p.tipo_docum='EXTR' then t_p.docum_extran else cast (t_p.nro_docum as text) end as nro_documento,
//                                        t_p.tipo_sexo,
//                                        t_p1.nombre as pais_nacim_nombre,
//                                        t_p2.descripcion_pcia as pcia_nacim_nombre,
//                                        t_p.fec_nacim
//                                    
//                                    FROM persona as t_p"
//                                        ." LEFT OUTER JOIN (SELECT t_p1.nombre, t_p1.codigo_pais FROM dblink('".$this->dblink_designa()."','SELECT nombre,codigo_pais FROM pais') as t_p1 (nombre CHARACTER VARYING(40), codigo_pais CHARACTER(2))) as t_p1"
//                                        . " ON (t_p.pais_nacim = t_p1.codigo_pais)"
//                                        . "LEFT OUTER JOIN (SELECT t_p2.codigo_pcia,t_p2.descripcion_pcia FROM dblink('".$this->dblink_designa()."', 'SELECT codigo_pcia, descripcion_pcia FROM provincia') as t_p2 (codigo_pcia INTEGER,descripcion_pcia CHARACTER(40))) as t_p2"
//                                        . " ON (t_p.pcia_nacim = t_p2.codigo_pcia)"
//                                        . "where t_p.apellido like 'A%' "
//                                    . "ORDER BY apellido,nombre;";
//        return toba::db('extension')->consultar($sql);
//    }
    //solo trae las personas cuyo apellido comienza con A
    function get_listado_comienzan_a() {
        $sql = "SELECT
                                        t_p.apellido,
                                        t_p.nombre,
                                        t_p.nro_tabla,
                                        t_p.tipo_docum,
                                        t_p.nro_docum,
                                        case when t_p.tipo_docum='EXTR' then t_p.docum_extran else cast (t_p.nro_docum as text) end as nro_documento,
                                        t_p.tipo_sexo,
                                        t_p.fec_nacim
                                    
                                    FROM persona as t_p"
                                        . "where t_p.apellido like 'A%' "
                                    . "ORDER BY apellido,nombre;";
        return toba::db('extension')->consultar($sql);
    }

    function get_datos($tipo, $nro) {
        
        $sql = "select trim(apellido)||', '||trim(nombre) as nombre from persona"
                . " where tipo_docum='" . $tipo . "'" . " and nro_docum=" . $nro;
        return toba::db('extension')->consultar($sql);
    }

}
?>