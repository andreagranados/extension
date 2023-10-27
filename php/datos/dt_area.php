<?php
class dt_area extends extension_datos_tabla
{
	function get_descripciones($id_nro_dpto=null)
	{

        # Crea la tabla temporal
        $query = "CREATE TEMPORARY TABLE pg_temp.tabla_temporal_descripciones (
            id serial NOT NULL PRIMARY KEY,
            area json
            )"; # Consulta Final
        toba::db('extension')->consultar($query);
    
        if(isset($id_nro_dpto)){
            $res = dt_unidad::get_areas($id_nro_dpto);
        }

        foreach ($res as $datos) {
            $datos_json = json_encode($datos);
            $datos_json = pg_escape_string($datos_json);
            // Consulta SQL para insertar los datos en la tabla
            $query = "INSERT INTO pg_temp.tabla_temporal_descripciones (area) VALUES ('$datos_json')"; # Consulta Final
            toba::db('extension')->consultar($query);
        }

            $sql = "SELECT 
                (area->>'idarea')::int AS idarea, 
                area->>'descripcion' AS descripcion 
                FROM pg_temp.tabla_temporal_descripciones";
         
            return toba::db('extension')->consultar($sql);
            // $where="";
            // if(isset($id_nro_dpto)){
            //     $where=" where iddepto=$id_nro_dpto";
            // }
            // $sql= "SELECT a.idarea,a.descripcion "
            //         . "FROM dblink('". $this->dblink_designa() ."',"
            //         . "'SELECT idarea, descripcion FROM area $where') as a (idarea INTEGER, descripcion CHARACTER VARYING)"
            //         . "ORDER BY descripcion";

            // return toba::db('extension')->consultar($sql);
	}
   
	function get_listado()
	{
		$sql = "SELECT
			t_a.idarea,
			t_d.descripcion as iddepto_nombre,
			t_a.descripcion
		FROM
			area as t_a,
			departamento as t_d
		WHERE
				t_a.iddepto = t_d.iddepto
		ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}
        function tiene_orientaciones($idarea){
            $sql = "select * from orientacion where idarea=".$idarea;  
            $res = toba::db('designa')->consultar($sql);
            if(count($res)>0){
                return true;
            }else{
                return false;
            }
        }





}
?>