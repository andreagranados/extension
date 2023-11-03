<?php

class dt_destinatarios extends extension_datos_tabla {

    function get_descripciones($id_dest = null) {

        if (!is_null($id_dest)) {
            $sql = "SELECT "
                    . "d.id_destinatario, "
                    . "d.descripcion "
                    . "FROM destinatarios as d "
                    . "WHERE d.id_destinatario IN $id_dest ";
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }
        return $res;
    }

//    function get_listado($id_pext = null) {
//
//        if (!is_null($id_pext)) {
//            $sql = "SELECT "
//                    . "d.id_destinatario, "
//                    . "d.id_pext, "
//                    . "d.domicilio, "
//                    . "d.telefono, "
//                    . "d.email, "
//                    . "d.contacto,"
//                    . "d.cantidad, "
//                    . "d.descripcion, "
//                    . "l.localidad as localidad "
//                    . "FROM destinatarios as d "
//                    . "LEFT OUTER JOIN (SELECT l.id,l.localidad FROM dblink('" . $this->dblink_designa() . "','SELECT id,localidad  FROM localidad') as l (id INTEGER, localidad CHARACTER VARYING(255) )) as l ON (d.id_localidad = l.id)"
//
//                    . "WHERE d.id_pext = $id_pext ";
//            $res = toba::db('extension')->consultar($sql);
//        } else {
//            $res = array();
//        }
//        return $res;
//    }
    //lucas
        function get_listado($id_pext = null) {

        if (!is_null($id_pext)) {
            
            # Crea la tabla temporal
            $query = "CREATE TEMPORARY TABLE pg_temp.tabla_temporal_localidades (
                id serial NOT NULL PRIMARY KEY,
                localidad json
                )"; # Consulta Final
            toba::db('extension')->consultar($query);
        
            $res = dt_unidad::get_localidades(null);

            foreach ($res as $datos) {
                $datos_json = json_encode($datos);
                //$datos_json = pg_escape_string($datos_json);
                // Consulta SQL para insertar los datos en la tabla
                $query = "INSERT INTO pg_temp.tabla_temporal_localidades (localidad) VALUES (".quote($datos_json).")"; # Consulta Final
                toba::db('extension')->consultar($query);
            }

            $sql = "SELECT
                    d.id_destinatario,
                    d.id_pext,
                    d.domicilio,
                    d.telefono,
                    d.email,
                    d.contacto,
                    d.cantidad,
                    d.descripcion,
                    temp_local.localidad as localidad
                    FROM destinatarios as d
                    LEFT OUTER JOIN 
                    (SELECT 
                    (localidad->>'id')::int AS id, 
                    localidad->>'localidad' AS localidad 
                    FROM pg_temp.tabla_temporal_localidades) AS temp_local ON
                    temp_local.id = d.id_localidad
                    WHERE d.id_pext = $id_pext";
      
            $res = toba::db('extension')->consultar($sql);
        } else {
            $res = array();
        }
        return $res;
    }
    function tiene_aval($id_destinatario = null){
        $sql="select case when aval is not null then 1 else 0 end as tiene from destinatarios where id_destinatario=$id_destinatario";
        $res=toba::db('extension')->consultar($sql); 
        return $res[0]['tiene'];
    }


}

?>