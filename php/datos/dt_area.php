<?php
class dt_area extends extension_datos_tabla
{
	function get_descripciones($id_nro_dpto=null)
	{
            $where="";
            if(isset($id_nro_dpto)){
                $where=" where iddepto=$id_nro_dpto";
            }
            $sql= "SELECT a.idarea,a.descripcion "
                    . "FROM dblink('". $this->dblink_designa() ."',"
                    . "'SELECT idarea, descripcion FROM area $where') as a (idarea INTEGER, descripcion CHARACTER VARYING)"
                    . " ORDER BY descripcion";

            return toba::db('extension')->consultar($sql);
           
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