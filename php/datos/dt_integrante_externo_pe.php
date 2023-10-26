<?php
//require 'dt_unidad.php';
class dt_integrante_externo_pe extends extension_datos_tabla {

    function get_listado($id_p = null) {
        $sql = "select "
                . "id_pext,"
                . "trim(apellido)||', '||trim(nombre) as nombre,"
                . "t_p.tipo_docum,"
                . "t_p.nro_docum,"
                . "fec_nacim,"
                . "tipo_sexo,"
                . "pais_nacim,"
                . "f_e.descripcion as funcion_p,"
                . "carga_horaria,"
                . "desde,hasta,"
                . "rescd,"
                . "t_fe.descripcion as tipo,"
                . "t_p.telefono,"
                . "t_p.mail,"
                . "ad_honorem,"
                . "cv "
                . "FROM integrante_externo_pe as t_e "
                . "LEFT OUTER JOIN funcion_extension as f_e ON (t_e.funcion_p = f_e.id_extension) "
                . "LEFT OUTER JOIN funcion_extension as t_fe ON (t_e.tipo = t_fe.id_extension) "
                . "LEFT OUTER JOIN persona t_p ON (t_e.tipo_docum=t_p.tipo_docum and t_e.nro_docum=t_p.nro_docum)"
                . " where id_pext=" . $id_p
                . " order by nombre,desde"
        ;
        return toba::db('extension')->consultar($sql);
    }

    function get_vigentes($filtro = null, $id_pext = null) {

        $vigente = "hasta = 'Vigentes'";
        if (str_word_count($filtro) == 2) {
            $where = " WHERE t_e.hasta >= '" . date('Y-m-d') . "' AND  id_pext = $id_pext  ";
        } else {
            $vigente = "hasta = 'No Vigentes'";
            if (str_word_count($filtro) == 3) {
                $where = " WHERE t_e.hasta < '" . date('Y-m-d') . "' AND  id_pext = $id_pext  ";
            } else {
                $where = "WHERE id_pext = $id_pext ";
            }
        }


        $sql = "select "
                . "id_pext,"
                . "trim(apellido)||', '||trim(nombre) as nombre,"
                . "t_p.tipo_docum,"
                . "t_p.nro_docum,"
                . "fec_nacim,"
                . "tipo_sexo,"
                . "pais_nacim,"
                . "f_e.descripcion as funcion_p,"
                . "carga_horaria,"
                . "desde,hasta,"
                . "rescd,"
                . "t_fe.descripcion as tipo,"
                . "t_p.telefono,"
                . "t_p.mail,"
                . "ad_honorem,"
                . "cv "
                . "FROM integrante_externo_pe as t_e "
                . "LEFT OUTER JOIN funcion_extension as f_e ON (t_e.funcion_p = f_e.id_extension) "
                . "LEFT OUTER JOIN funcion_extension as t_fe ON (t_e.tipo = t_fe.id_extension) "
                . "LEFT OUTER JOIN persona t_p ON (t_e.tipo_docum=t_p.tipo_docum and t_e.nro_docum=t_p.nro_docum)"
                . $where
                . " order by nombre,desde";
        return toba::db('extension')->consultar($sql);
    }

    function get_descripciones() {
        $sql = "select t_e.*,trim(apellido)||', '||trim(nombre) as nombre "
                . "FROM integrante_externo_pe as t_e "
                . "LEFT OUTER JOIN persona t_p ON (t_e.tipo_docum=t_p.tipo_docum and t_e.nro_docum=t_p.nro_docum) "
                . "WHERE t_e.funcion_p = 'I' OR t_e.funcion_p = 'B' "
                . "ORDER BY nombre";
        return toba::db('extension')->consultar($sql);
    }

    function get_integrante($nro_docum = null, $id_pext = null) {
        $sql = "select t_e.*,trim(apellido)||', '||trim(nombre) as nombre "
                . "FROM integrante_externo_pe as t_e "
                . "LEFT OUTER JOIN persona t_p ON (t_e.tipo_docum=t_p.tipo_docum and t_e.nro_docum=t_p.nro_docum) "
                . "WHERE t_e.nro_docum = $nro_docum AND t_e.id_pext = $id_pext ";
        return toba::db('extension')->consultar($sql);
    }
    
    function getIntegranteVigente($nro_docum = null, $id_pext = null) {
        $sql = "select t_e.*,trim(apellido)||', '||trim(nombre) as nombre "
                . "FROM integrante_externo_pe as t_e "
                . "LEFT OUTER JOIN persona t_p ON (t_e.tipo_docum=t_p.tipo_docum and t_e.nro_docum=t_p.nro_docum) "
                . "WHERE t_e.nro_docum = $nro_docum AND t_e.id_pext = $id_pext AND t_e.hasta >= '" . date('Y-m-d')."'";
        return toba::db('extension')->consultar($sql);
    }

    function get_datos($nro_docum = null, $id_pext = null) {
        $sql = "SELECT * FROM integrante_externo_pe WHERE nro_docum = $nro_docum AND id_pext = $id_pext";
        return toba::db('extension')->consultar($sql);
    }

//    function get_plantilla($id_p, $filtro = array()) {
//        
//        // Filtro claustro no activo / ni funcional 
//        $where = array();
//        if (isset($filtro['tipo'])) {
//            $where[] = "tipo = " . quote($filtro[tipo][valor]);
//        }
//
//        $sql = "(select "
//                . "t_i.tipo,"
//                . "upper(t_do.apellido||', '||t_do.nombre) as nombre,"
//                . "t_do.tipo_docum,"
//                . "t_do.nro_docum,"
//                . "t_do.tipo_sexo,"
//                . "t_d.cat_estat||'-'||t_d.dedic as categoria,"
//                . "t_d.carac,"
//                . "t_i.ua,"
//                . "t_i.carga_horaria,"
//                . "t_f.descripcion as funcion_p,"
//                . "t_do.correo_institucional as mail,"
//                . "t_do.telefono_celular as telefono,"
//                . "ad_honorem "
//                . "FROM  integrante_interno_pe t_i "
//                . "LEFT OUTER JOIN ( SELECT d.* FROM dblink('" . $this->dblink_designa() . "', "
//                . "'SELECT d.id_designacion,d.id_docente, d.carac,d.cat_estat,d.dedic FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER, carac CHARACTER(1),cat_estat CHARACTER(6), dedic INTEGER )) as t_d ON (t_i.id_designacion=t_d.id_designacion) "
//                . "LEFT OUTER JOIN (SELECT dc.* FROM dblink('" . $this->dblink_designa() . "',
//                    'SELECT dc.id_docente,dc.nombre, dc.apellido, dc.tipo_docum,dc.nro_docum, dc.fec_nacim,dc.tipo_sexo,dc.pais_nacim , dc.correo_institucional,dc.telefono_celular 
//                    FROM docente as dc ') as dc 
//                    ( id_docente INTEGER,nombre CHARACTER VARYING,apellido CHARACTER VARYING,tipo_docum CHARACTER(4) ,nro_docum INTEGER,fec_nacim DATE,tipo_sexo CHARACTER(1),pais_nacim CHARACTER(2),correo_institucional CHARACTER(60),telefono_celular CHARACTER(30) ) ) as t_do ON (t_d.id_docente=t_do.id_docente) "
//                . "LEFT OUTER JOIN funcion_extension t_f ON (t_i.funcion_p=t_f.id_extension) "
//                . "LEFT OUTER JOIN pextension p ON (t_i.id_pext=p.id_pext) ";
//        if (count($where) > 0) {
//            $sql = sql_concatenar_where($sql, $where)
//                    . "AND t_i.id_pext=" . $id_p;
//                    //. " AND t_i.hasta >= '" . date('Y-m-d') . "')";
//        } else {
//            $sql .= "where t_i.id_pext = " . $id_p . ")";// AND t_i.hasta >= '" . date('Y-m-d') . "')";
//        }
//
//        $sql .= " UNION" //union con los integrantes externos
//                . " (select "
//                . "t_fe.descripcion as tipo, "
//                . "upper(t_p.apellido||', '||t_p.nombre) as nombre, "
//                . "t_e.tipo_docum, "
//                . "t_e.nro_docum, "
//                . "t_p.tipo_sexo, "
//                . "'' as carac, "
//                . "'' as categoria, "
//                . "'' as ua, "
//                . "t_e.carga_horaria, "
//                . "t_f.descripcion as funcion_p,"
//                . "t_p.mail,"
//                . "t_p.telefono,"
//                . "ad_honorem "
//                . "FROM integrante_externo_pe t_e"
//                . " LEFT OUTER JOIN persona t_p ON (t_e.tipo_docum = t_p.tipo_docum and t_e.nro_docum = t_p.nro_docum) "
//                . " LEFT OUTER JOIN funcion_extension t_f ON (t_e.funcion_p = t_f.id_extension) "
//                . "LEFT OUTER JOIN funcion_extension as t_fe ON (t_e.tipo = t_fe.id_extension) "
//                . " LEFT OUTER JOIN pextension p ON (t_e.id_pext = p.id_pext) ";
//        if (count($where) > 0) {
//            $sql = sql_concatenar_where($sql, $where)
//                    . "AND t_e.id_pext=" . $id_p;
//                    //. " AND t_e.hasta >= '" . date('Y-m-d') . "')";
//        } else {
//            $sql .= " where t_e.id_pext = " . $id_p . ")";// AND t_e.hasta >= '" . date('Y-m-d') . "')";
//        }
//
//        return toba::db('extension')->consultar($sql);
//    }
    //Lucas
    function get_plantilla($id_p, $filtro = array()) {
        # Crea la tabla temporal
        $query = "CREATE TEMPORARY TABLE pg_temp.tabla_temporal_integrante (
            id serial NOT NULL PRIMARY KEY,
            integrante json
            )"; # Consulta Final
        toba::db('extension')->consultar($query);
          
        $res = dt_unidad::get_integrantes($id_p);
        //$res = $this->get_SW();
        //$res = dt_get_sw::consumir($url);
        
       //print_r($res);
        foreach ($res as $datos) {
            $datos_json = json_encode($datos);
            //$datos_json = pg_escape_string($datos_json);
        
            // Consulta SQL para insertar los datos en la tabla
            $query = "INSERT INTO pg_temp.tabla_temporal_integrante (integrante) VALUES ('$datos_json')"; # Consulta Final
            toba::db('extension')->consultar($query);
        }
        
        // Filtro claustro no activo / ni funcional 
        $where = array();
        if (isset($filtro['tipo'])) {
            $where[] = "tipo = " . quote($filtro[tipo][valor]);
        }

        $sql = "SELECT DISTINCT
                    t_i.tipo,
                    upper(temp_i.apellido||', '||temp_i.nombre) as nombre,
                    temp_i.tipo_docum,
                    temp_i.nro_docum,
                    temp_i.tipo_sexo,
                    temp_i.cat_estat||'-'||temp_i.dedic as categoria,
                    temp_i.carac,
                    t_i.ua,
                    t_i.carga_horaria,
                    t_f.descripcion as funcion_p,
                    temp_i.correo_institucional as mail,
                    temp_i.telefono_celular as telefono,
                    ad_honorem 
                FROM  integrante_interno_pe AS t_i
                LEFT OUTER JOIN (SELECT 
                    (integrante->>'id_designacion')::int AS id_designacion,
                    integrante->>'carac' AS carac,
                    integrante->>'cat_estat' AS cat_estat,
                    (integrante->>'dedic')::int AS dedic,
                    (integrante->>'id_docente')::int AS id_docente,
                    integrante->>'nombre' AS nombre,
                    integrante->>'apellido' AS apellido,
                    integrante->>'tipo_docum' AS tipo_docum,
                    (integrante->>'nro_docum')::int AS nro_docum,
                    integrante->>'fec_nacim' AS fec_nacim,
                    integrante->>'tipo_sexo' AS tipo_sexo,
                    integrante->>'pais_nacim' AS pais_nacim,
                    integrante->>'correo_institucional' AS correo_institucional,
                    integrante->>'telefono_celular' AS telefono_celular
                    FROM pg_temp.tabla_temporal_integrante) AS temp_i ON (temp_i.id_designacion = t_i.id_designacion)
                LEFT OUTER JOIN funcion_extension AS t_f ON (t_f.id_extension = t_i.funcion_p)
                LEFT OUTER JOIN pextension AS p ON (p.id_pext = t_i.id_pext)";

        if (count($where) > 0) {
            $sql = sql_concatenar_where($sql, $where)
                    . " AND t_i.id_pext = " . $id_p;
        } else {
            $sql .= " WHERE t_i.id_pext = " . $id_p;
        }

        //union con los integrantes externos
        $sql.= " \nUNION
                    (select 
                    t_fe.descripcion as tipo, 
                    upper(t_p.apellido||', '||t_p.nombre) as nombre, 
                    t_e.tipo_docum, 
                    t_e.nro_docum, 
                    t_p.tipo_sexo, 
                    '' as carac, 
                    '' as categoria, 
                    '' as ua, 
                    t_e.carga_horaria, 
                    t_f.descripcion as funcion_p,
                    t_p.mail,
                    t_p.telefono,
                    ad_honorem 
                FROM integrante_externo_pe AS t_e
                LEFT OUTER JOIN persona AS t_p ON (t_e.tipo_docum = t_p.tipo_docum and t_e.nro_docum = t_p.nro_docum) 
                LEFT OUTER JOIN funcion_extension AS t_f ON (t_e.funcion_p = t_f.id_extension) 
                LEFT OUTER JOIN funcion_extension AS t_fe ON (t_e.tipo = t_fe.id_extension) 
                LEFT OUTER JOIN pextension AS p ON (t_e.id_pext = p.id_pext) ";

        if (count($where) > 0) {
            $sql = sql_concatenar_where($sql, $where)
                    . "AND t_e.id_pext=" . $id_p;
                    //. " AND t_e.hasta >= '" . date('Y-m-d') . "')";
        } else {
            $sql .= " WHERE t_e.id_pext = " . $id_p . ")";// AND t_e.hasta >= '" . date('Y-m-d') . "')";
        }

        return toba::db('extension')->consultar($sql);
    }
    function get_co_director($id_p = null) {
        $sql = "select "
                . "id_pext,"
                . "trim(apellido)||', '||trim(nombre) as nombre,"
                . "t_p.tipo_docum,"
                . "t_p.nro_docum,"
                . "fec_nacim,"
                . "tipo_sexo,"
                . "pais_nacim,"
                . "f_e.descripcion as funcion_p,"
                . "carga_horaria,"
                . "desde,hasta,"
                . "rescd,"
                . "t_fe.descripcion as tipo,"
                . "t_p.telefono,"
                . "t_p.mail,"
                . "ad_honorem "
                . "FROM integrante_externo_pe as t_e "
                . "LEFT OUTER JOIN funcion_extension as f_e ON (t_e.funcion_p = f_e.id_extension) "
                . "LEFT OUTER JOIN funcion_extension as t_fe ON (t_e.tipo = t_fe.id_extension) "
                . "LEFT OUTER JOIN persona t_p ON (t_e.tipo_docum=t_p.tipo_docum and t_e.nro_docum=t_p.nro_docum)"
                . " where id_pext=" . $id_p . " AND funcion_p='CD-Co' "
                . " order by nombre,desde";
        return toba::db('extension')->consultar($sql);
    }

    function getCodirectorVigente($id_p = null) {
        $sql = "select "
                . "id_pext,"
                . "trim(apellido)||', '||trim(nombre) as nombre,"
                . "t_p.tipo_docum,"
                . "t_p.nro_docum,"
                . "fec_nacim,"
                . "tipo_sexo,"
                . "pais_nacim,"
                . "f_e.descripcion as funcion_p,"
                . "carga_horaria,"
                . "desde,hasta,"
                . "rescd,"
                . "t_fe.descripcion as tipo,"
                . "t_p.telefono,"
                . "t_p.mail,"
                . "ad_honorem "
                . "FROM integrante_externo_pe as t_e "
                . "LEFT OUTER JOIN funcion_extension as f_e ON (t_e.funcion_p = f_e.id_extension) "
                . "LEFT OUTER JOIN funcion_extension as t_fe ON (t_e.tipo = t_fe.id_extension) "
                . "LEFT OUTER JOIN persona t_p ON (t_e.tipo_docum=t_p.tipo_docum and t_e.nro_docum=t_p.nro_docum)"
                . " where id_pext=" . $id_p ." AND t_e.hasta >= '" . date('Y-m-d') . "' AND funcion_p='CD-Co' "
                . " order by nombre,desde";
        return toba::db('extension')->consultar($sql);
    }

    function tiene_cv($datos = array()) {
        $sql = "select case when cv is not null then 1 else 0 end as tiene from integrante_externo_pe where id_pext =" . $datos['id_pext'] . " AND desde='" . $datos['desde'] . "'  AND tipo_docum='" . $datos['tipo_docum'] . "' AND nro_docum='" . $datos['nro_docum'] . "'";
        $res = toba::db('extension')->consultar($sql);
        return $res[0]['tiene'];
    }
    function modif_fecha($id_pext,$fecha_prorroga,$fecha_fin){
        $sql="update integrante_externo_pe set hasta='".$fecha_prorroga."' "
                . " where id_pext=".$id_pext." and hasta='".$fecha_fin."'";
        toba::db('extension')->consultar($sql);
    }
    function eliminar_integrantes($id_pext){
        $sql="delete from integrante_externo_pe "
                . " where id_pext=".$id_pext;
        toba::db('extension')->consultar($sql);
    }
}

?>