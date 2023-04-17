<?php
class dt_tipo_solicitud extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_tipo, descripcion FROM tipo_solicitud ORDER BY descripcion";
		return toba::db('extension')->consultar($sql);
	}

}
?>