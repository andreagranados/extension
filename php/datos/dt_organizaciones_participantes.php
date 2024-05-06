<?php

class dt_organizaciones_participantes extends extension_datos_tabla {
    function cargarTablasTemporales(){
        # Crea la tabla temporal
        $query = "CREATE TEMPORARY TABLE pg_temp.tabla_temporal_pais (
            id serial NOT NULL PRIMARY KEY,
            pais json
            )";
        toba::db('extension')->consultar($query);
        $res[0] = dt_unidad::get_paises_todos();

        # Crea la tabla temporal
        $query = "CREATE TEMPORARY TABLE pg_temp.tabla_temporal_provincia (
            id serial NOT NULL PRIMARY KEY,
            provincia json
            )";
        toba::db('extension')->consultar($query);
        $res[1] = dt_unidad::get_provincias('AR');

        # Crea la tabla temporal
        $query = "CREATE TEMPORARY TABLE pg_temp.tabla_temporal_localidad (
            id serial NOT NULL PRIMARY KEY,
            localidad json
            )";
        toba::db('extension')->consultar($query);
        $res[2] = dt_unidad::get_localidades(null);

        for ($i=0; $i < 3 ; $i++) { 
            foreach ($res[$i] as $datos) {
                $datos_json = json_encode($datos);
                //$datos_json = pg_escape_string($datos_json);
                // Consulta SQL para insertar los datos en la tabla
                if ($i == 0){
                    $query = "INSERT INTO pg_temp.tabla_temporal_pais (pais) VALUES (".quote($datos_json).")"; 
                }
                if ($i == 1){
                    $query = "INSERT INTO pg_temp.tabla_temporal_provincia (provincia) VALUES (".quote($datos_json).")"; 
                }
                if ($i == 2){
                    $query = "INSERT INTO pg_temp.tabla_temporal_localidad (localidad) VALUES (".quote($datos_json).")"; 
                }
                toba::db('extension')->consultar($query);
            }
        }
    }
    //no se llama desde ningun lado
//    function get_listado_filtro($id, $filtro = array()) {
//
//        $where = array();
//        if (isset($filtro)) {
//            $where[] = $filtro;
//        }
//        $sql = "SELECT
//                    o_p.id_organizacion ,
//                    o_p.id_tipo_organizacion ,
//                    o_p.id_pext ,
//                    o_p.nombre ,
//                    o_p.id_localidad ,
//                    o_p.telefono ,
//                    o_p.email ,
//                    o_p.referencia_vinculacion_inst,
//                    o_p.id_pais,
//                    o_p.id_provincia,
//                    o_p.domicilio,
//                    o_p.aval
//                    
//                FROM
//                   organizaciones_participantes as o_p INNER JOIN pextension as p_e ON (o_p.id_pext = p_e.id_pext)"
//                . "LEFT OUTER JOIN (SELECT l.id,l.localidad FROM dblink('" . $this->dblink_designa() . "','SELECT id,localidad  FROM localidad') as l (id INTEGER, localidad CHARACTER VARYING(255) )) as l"
//                . " ON (o_p.id_localidad = l.id AND o_p.localidad = l.localidad)
//                   LEFT OUTER JOIN tipo_organizacion as t_o ON (o_p.id_tipo_organizacion = t_o.id_tipo_organizacion)
//                    where o_p.localidad = l.localidad"
//
//        ;
//        if (count($where) > 0) {
//            $sql = sql_concatenar_where($sql, $where)
//                    . "AND o_p.id_pext=" . $id;
//        }
//        return toba::db('extension')->consultar($sql);
//    }

//    function get_listado($id = null) {
//        $sql = "SELECT
//                    o_p.id_organizacion ,
//                    o_p.id_tipo_organizacion ,
//                    t_o.descripcion,
//                    t_o.otra_descripcion,
//                    o_p.id_pext ,
//                    o_p.nombre ,
//                    trim(localidad) as localidad  ,
//                    o_p.telefono ,
//                    o_p.email ,
//                    o_p.referencia_vinculacion_inst,
//                    trim(codigo_pais) as pais ,
//                    trim(descripcion_pcia) as provincia ,
//                    o_p.domicilio,
//                    o_p.aval
//                    
//                FROM "
//                . " organizaciones_participantes as o_p INNER JOIN pextension as p_e ON (o_p.id_pext = p_e.id_pext)"
//                . " LEFT OUTER JOIN (SELECT l.id,l.localidad FROM dblink('" . $this->dblink_designa() . "','SELECT id, localidad  FROM localidad') as l (id INTEGER , localidad CHARACTER VARYING(255))) as l"
//                . " ON (o_p.id_localidad = l.id)"
//                . " LEFT OUTER JOIN tipo_organizacion as t_o ON (o_p.id_tipo_organizacion = t_o.id_tipo_organizacion)
//                    LEFT OUTER JOIN (SELECT p.codigo_pais,p.nombre FROM dblink('" . $this->dblink_designa() . "','SELECT codigo_pais, nombre  FROM pais') as p (codigo_pais CHARACTER(2) , nombre CHARACTER VARYING(40))) as p"
//                . " ON (o_p.id_pais = p.codigo_pais)
//                    LEFT OUTER JOIN (SELECT pcia.codigo_pcia,pcia.descripcion_pcia FROM dblink('" . $this->dblink_designa() . "','SELECT codigo_pcia, descripcion_pcia  FROM provincia') as pcia (codigo_pcia INTEGER , descripcion_pcia CHARACTER (40))) as pcia"
//                . " ON (o_p.id_provincia = pcia.codigo_pcia)
//                   
//                WHERE o_p.id_pext = " . $id;
//
//        return toba::db('extension')->consultar($sql);
//    }
    //Lucas
    function get_listado($id = null) {
        $this->cargarTablasTemporales();
        $sql = "SELECT
                    o_p.id_organizacion ,
                    o_p.id_tipo_organizacion ,
                    t_o.descripcion,
                    t_o.otra_descripcion,
                    o_p.id_pext ,
                    o_p.nombre ,
                    trim(temp_local.localidad) as localidad  ,
                    o_p.telefono ,
                    o_p.email ,
                    o_p.referencia_vinculacion_inst,
                    trim(temp_pais.codigo_pais) as pais ,
                    trim(temp_prov.descripcion_pcia) as provincia ,
                    o_p.domicilio,
                    o_p.aval 
                FROM 
                    organizaciones_participantes AS o_p
                INNER JOIN 
                    pextension AS p_e 
                    ON (o_p.id_pext = p_e.id_pext)
                LEFT OUTER JOIN 
                    (SELECT 
                        (localidad->>'id')::int AS id, 
                        localidad->>'localidad' AS localidad 
                    FROM pg_temp.tabla_temporal_localidad) AS temp_local
                    ON (o_p.id_localidad = temp_local.id) 
                LEFT OUTER JOIN 
                    tipo_organizacion AS t_o 
                    ON (o_p.id_tipo_organizacion = t_o.id_tipo_organizacion)
                LEFT OUTER JOIN 
                    (SELECT 
                        pais->>'codigo_pais' AS codigo_pais, 
                        pais->>'nombre' AS nombre 
                    FROM pg_temp.tabla_temporal_pais) AS temp_pais
                    ON (o_p.id_pais = temp_pais.codigo_pais)
                LEFT OUTER JOIN 
                    (SELECT 
                        (provincia->>'codigo_pcia')::int AS codigo_pcia, 
                        provincia->>'descripcion_pcia' AS descripcion_pcia 
                    FROM pg_temp.tabla_temporal_provincia) AS temp_prov
                    ON (o_p.id_provincia = temp_prov.codigo_pcia)
                WHERE o_p.id_pext = $id";

        return toba::db('extension')->consultar($sql);
    }
    function get_organizacion($id_organizacion = null) {
        $sql = "SELECT
                    o_p.*
                FROM "
                . " organizaciones_participantes as o_p "
                . " WHERE o_p.id_organizacion = " . $id_organizacion;
        return toba::db('extension')->consultar($sql);
    }
    
    function tiene_aval($id_organizacion = null){
        $sql="select case when aval is not null then 1 else 0 end as tiene from organizaciones_participantes where id_organizacion=$id_organizacion";
        $res=toba::db('extension')->consultar($sql); 
        return $res[0]['tiene'];
    }

}