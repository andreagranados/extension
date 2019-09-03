<?php
class dt_pextension extends extension_datos_tabla
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['uni_acad'])) {
			$where[] = "uni_acad = ".quote($filtro['uni_acad']);
		}
		$sql = "SELECT
			t_p.id_pext,
			t_p.codigo,
			t_p.denominacion,
			t_p.nro_resol,
			t_p.fecha_resol,
			t_ua.descripcion as uni_acad_nombre,
			t_p.fec_desde,
			t_p.fec_hasta,
			t_p.nro_ord_cs,
			t_p.res_rect,
			t_p.expediente,
			t_p.duracion,
			t_p.palabras_clave,
			t_p.objetivo,
			t_p.estado,
			t_p.financiacion,
			t_p.monto,
			t_p.fecha_rendicion,
			t_p.rendicion_monto,
			t_p.fecha_prorroga1,
			t_p.fecha_prorroga2,
			t_p.observacion,
			t_p.estado_informe_a,
			t_p.estado_informe_f
		FROM
			pextension as t_p	LEFT OUTER JOIN unidad_acad as t_ua ON (t_p.uni_acad = t_ua.sigla)
		ORDER BY codigo";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('extension')->consultar($sql);
	}


}
?>