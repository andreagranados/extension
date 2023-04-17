<?php
class dt_tipo_cambio extends toba_datos_tabla
{
	function get_tipo_cambio($id_tipo_sol = null)
	{
            if(isset($id_tipo_sol)){
                $where=" AND id_tipo='".$id_tipo_sol."'";
            }else{
                $where="";
            }
            
            $sql = "SELECT t.id_tipo_cambio, t.descripcion "
                    . " FROM  solicitud_cambio s,tipo_cambio t"
                    . " WHERE s.id_tipo_cambio=t.id_tipo_cambio "
                    . $where
                    . " ORDER BY descripcion";
            return toba::db('extension')->consultar($sql);
	}
        function get_descripciones()
        {
            $sql = "SELECT id_tipo_cambio, descripcion "
                    . " FROM tipo_cambio "
                    . " ORDER BY descripcion";
            return toba::db('extension')->consultar($sql);
        }

}
?>