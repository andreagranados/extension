<?php

class dt_rubro_presup_extension extends extension_datos_tabla {

    function get_descripcion($id_rubro_extension = null) {
        $sql = "SELECT
                    id_rubro_extension ,
                    tipo
                    
                FROM
                   rubro_presup_extension  
                WHERE id_rubro_extension= $id_rubro_extension
                ORDER BY tipo";

        return toba::db('extension')->consultar($sql);
    }

    function get_listado_filtro($filtro = array()) {

        $where = array();
        if (isset($filtro)) {
            //$where[] = "tipo ILIKE ".quote("%{$filtro['tipo']}%");
            $where[] = $filtro;
        }

        $sql = "SELECT
                    id_rubro_extension ,
                    tipo
                    
                FROM
                   rubro_presup_extension  
                ORDER BY tipo";
        if (count($where) > 0) {
            $sql = sql_concatenar_where($sql, $where);
        }


        //print_r($where);
        //$sql = toba::perfil_de_datos()->filtrar($sql);
        // to do filtrar por formulador o filtrar dentro de formulario
        //print_r($sql);
        //exit();
        return toba::db('extension')->consultar($sql);
    }

    function get_tipo() {
        $sql = "SELECT id_rubro_extension,tipo "
                . " FROM rubro_presup_extension"
                . " WHERE id_rubro_extension<>1 "
                . " ORDER BY tipo";
        return toba::db('extension')->consultar($sql);
    }

    //Formulario que simula filtro
    /* function get_listado($filtro = array()) {
      $where = array();
      if (isset($filtro['uni_acad'])) {
      $where[] = "t_p.uni_acad = " . quote($filtro['uni_acad']);
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
      t_p.estado_informe_f,
      t_p.uni_acad,
      dc.apellido || ' '|| dc.nombre as director,
      dpto.descripcion,
      a.descripcion,
      t_p.eje_tematico,
      t_p.descripcion_situacion,
      t_p.caracterizacion_poblacion,
      t_p.localizacion_geo,
      t_p.antecedente_participacion,
      t_p.importancia_necesidad
      FROM
      pextension as t_p INNER JOIN unidad_acad as t_ua ON (t_p.uni_acad = t_ua.sigla)
      LEFT OUTER JOIN integrante_interno_pe as i ON (t_p.id_pext = i.id_pext AND i.funcion_p='D')
      LEFT OUTER JOIN designacion as d ON (i.id_designacion = d.id_designacion )
      LEFT OUTER JOIN docente as dc ON ( dc.id_docente = d.id_docente )
      LEFT OUTER JOIN departamento as dpto ON (dpto.idunidad_academica = t_ua.sigla)
      LEFT OUTER JOIN area as a ON (a.iddepto = dpto.iddepto)
      ORDER BY codigo";
      if (count($where) > 0) {
      $sql = sql_concatenar_where($sql, $where);
      }
      //print_r($sql);      //  exit();
      return toba::db('extension')->consultar($sql);
      } */
}