<?php

class dt_pextension extends extension_datos_tabla {

    function get_titulo($id_pext = null) {
        $sql = "SELECT denominacion FROM pextension WHERE id_pext = $id_pext";
        return toba::db('extension')->consultar($sql);
    }

    function get_datos($filtro = array()) {
        $where = array();
        if (isset($filtro['uni_acad'])) {
            $where[] = "t_p.uni_acad = " . quote($filtro['uni_acad']);
            $where[] = "t_p.id_pext = " . quote($filtro['id_pext']);
        }
        $sql = "SELECT
			t_p.id_pext,
                        t_p.denominacion,
                        t_ua.descripcion as uni_acad_nombre,
                        t_p.departamento,
                        t_p.area,
                        t_p.fec_desde,
                        t_p.fec_hasta,
                        t_p.fec_carga,
                        t_p.expediente,
                        t_p.duracion,
                        t_p.palabras_clave,
                        t_p.objetivo,
                        t_e.id_estado,
                        t_e.descripcion as descripcion_estado,
                        t_p.financiacion,
                        t_p.monto,
                        t_p.uni_acad,
                        
                        d.apellido || ' '|| d.nombre || ' '|| d.tipo_docum || ' '|| d.nro_docum as director,
                        d.correo_institucional as dir_email,
                        d.telefono_celular as dir_telefono,
               
                        co.apellido || ' '|| co.nombre || ' '|| co.tipo_docum || ' '|| co.nro_docum as co_director,
                        co.correo_institucional as co_email,
                        
                        p.apellido || ' '|| p.nombre || ' '|| t_eco.tipo_docum || ' '|| t_eco.nro_docum as co_director_e,
                        p.mail as co_email_e,
                        p.telefono as co_telefono,
   
 
                        t_p.eje_tematico,
                        t_p.descripcion_situacion,
                        t_p.caracterizacion_poblacion,
                        t_p.localizacion_geo,
                        t_p.antecedente_participacion,
                        t_p.importancia_necesidad,
                        b_c.id_bases,
                        t_c.id_conv,
                        t_p.responsable_carga,
                        t_p.impacto,
                        t_p.multi_uni,
                        t_p.es_multi
                    FROM
                        pextension as t_p INNER JOIN"
                . "(SELECT t_ua.* FROM dblink('" . $this->dblink_designa() . "','SELECT sigla,descripcion FROM unidad_acad') as t_ua (sigla CHARACTER(5), descripcion CHARACTER(60))) as t_ua ON (t_p.uni_acad = t_ua.sigla)
                        LEFT OUTER JOIN integrante_interno_pe as i ON (t_p.id_pext = i.id_pext AND i.funcion_p='D' AND i.hasta >= '" . date('Y-m-d') . "')
                        LEFT OUTER JOIN (SELECT d.* FROM  dblink('" . $this->dblink_designa() . "', 
                                    'SELECT d.id_designacion, dc.id_docente , dc.apellido, dc.nombre, dc.tipo_docum, dc.nro_docum,dc.correo_institucional,dc.telefono_celular 
                                     FROM designacion as d LEFT OUTER JOIN docente as dc
                                            ON(dc.id_docente = d.id_docente)') as d 
                                            ( id_designacion INTEGER ,id_docente INTEGER ,apellido CHARACTER VARYING, nombre CHARACTER VARYING, tipo_docum CHARACTER(4), nro_docum INTEGER,correo_institucional CHARACTER(60),telefono_celular CHARACTER(30) )) as d ON (i.id_designacion=d.id_designacion)
                                            
                        LEFT OUTER JOIN integrante_interno_pe as i_co ON (t_p.id_pext = i_co.id_pext AND i_co.funcion_p='CD-Co' AND i_co.hasta >= '" . date('Y-m-d') . "')                        
                        LEFT OUTER JOIN (SELECT co.* FROM  dblink('" . $this->dblink_designa() . "', 
                                    'SELECT d.id_designacion, dc.id_docente , dc.apellido, dc.nombre, dc.tipo_docum, dc.nro_docum,dc.correo_institucional,dc.telefono_celular 
                                     FROM designacion as d LEFT OUTER JOIN docente as dc
                                            ON(dc.id_docente = d.id_docente)') as co 
                                            ( id_designacion INTEGER ,id_docente INTEGER ,apellido CHARACTER VARYING, nombre CHARACTER VARYING, tipo_docum CHARACTER(4), nro_docum INTEGER,correo_institucional CHARACTER(60),telefono_celular CHARACTER(30) )) as co ON (i_co.id_designacion=co.id_designacion)
                        
                        LEFT OUTER JOIN integrante_externo_pe as t_eco ON (t_p.id_pext = t_eco.id_pext AND t_eco.funcion_p='CD-Co' AND t_eco.hasta >= '" . date('Y-m-d') . "') 
                        LEFT OUTER JOIN persona as p ON (p.tipo_docum = t_eco.tipo_docum AND p.nro_docum = t_eco.nro_docum ) 
                        
                        LEFT OUTER JOIN bases_convocatoria as b_c ON (b_c.id_bases = t_p.id_bases)
                        LEFT OUTER JOIN tipo_convocatoria as t_c ON (t_c.id_conv = b_c.tipo_convocatoria)
                        LEFT OUTER JOIN estado_pe as t_e ON (t_e.id_estado = t_p.id_estado)
                        ";


        if (count($where) > 0) {
            $sql = sql_concatenar_where($sql, $where);
        }

        return toba::db('extension')->consultar($sql);
    }

    function get_listado($where = null) {
        $usr = toba::manejador_sesiones()->get_id_usuario_instancia();
        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        $perfil_datos = toba::perfil_de_datos('designa')->get_restricciones_dimension('designa', 'unidad_acad')[0];

        if (!is_null($where)) {      
            $where = "WHERE " . $where;
        } else {
            $where = "WHERE 1=1";
        }
        
        if ('formulador' == $perfil) {
            $where .= " AND responsable_carga= '" . $usr . "'";
        } elseif ($perfil == 'sec_ext_ua') {
            $where .= " AND uni_acad='" . $perfil_datos . "'";
        }
        $sql = "SELECT distinct * FROM ( SELECT
                        t_p.id_pext,
                        t_c.descripcion,
                        dc.apellido || ' '|| dc.nombre || ' '|| dc.tipo_docum || ' '|| dc.nro_docum as director,
                        t_p.denominacion,
                        t_p.uni_acad,
                        t_p.fec_desde,
                        t_p.fec_hasta,  
                        t_p.ord_priori,
                        t_p.id_estado,
                        t_p.responsable_carga,
                        b_c.id_bases,
                        s_c.codigo,
                        t_p.monto,
                        case when t_a.id_alerta is null then 0 else 1 end as alerta,
                        t_p.es_multi
                    FROM
                        pextension as t_p INNER JOIN
                        (SELECT t_ua.* FROM dblink('" . $this->dblink_designa() . "','SELECT sigla FROM unidad_acad ') as t_ua (sigla CHARACTER(5) )) as t_ua ON (t_p.uni_acad = t_ua.sigla)
                        LEFT OUTER JOIN integrante_interno_pe as i ON (t_p.id_pext = i.id_pext AND i.funcion_p='D' AND i.hasta >= '" . date('Y-m-d') . "')
                        LEFT OUTER JOIN ( SELECT d.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT d.id_designacion,d.id_docente FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER)) as d ON (i.id_designacion = d.id_designacion)
                        LEFT OUTER JOIN ( SELECT dc.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT dc.id_docente,dc.nombre, dc.apellido, dc.tipo_docum, dc.nro_docum FROM docente as dc ') as dc ( id_docente INTEGER,apellido CHARACTER VARYING, nombre CHARACTER VARYING, tipo_docum CHARACTER(4), nro_docum INTEGER)) as dc ON (d.id_docente = dc.id_docente)
                        LEFT OUTER JOIN bases_convocatoria as b_c ON (t_p.id_bases = b_c.id_bases)
                        LEFT OUTER JOIN tipo_convocatoria as t_c ON (t_c.id_conv = b_c.tipo_convocatoria)  
                        LEFT OUTER JOIN seguimiento_central as s_c ON (t_p.id_pext = s_c.id_pext)
                        LEFT OUTER JOIN (SELECT * FROM alerta WHERE rol='".$perfil."' and estado_alerta='Pendiente'"." ) t_a ON (t_p.id_pext=t_a.id_pext)
                        ) AUX "
                . $where;
        $sql = toba::perfil_de_datos()->filtrar($sql);
        return toba::db('extension')->consultar($sql);
    }
    
    function get_proyectos_vigentes() {
        $usr = toba::manejador_sesiones()->get_id_usuario_instancia();
        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        $perfil_datos = toba::perfil_de_datos('designa')->get_restricciones_dimension('designa', 'unidad_acad')[0];

        /* SI where == null  
          $where = "WHERE " .  $where;
         * SINO 
         * $where = "WHERE 
         * fin si
         * 
         * $where 
         *           */
        $where .= "WHERE id_estado = 'FORM'";

        if ('formulador' == $perfil) {
            $where .= " AND responsable_carga= '" . $usr . "'";
        } elseif ($perfil == 'sec_ext_ua') {
            $where .= " AND uni_acad='" . $perfil_datos . "'";
        }



        $sql = "SELECT * FROM ( SELECT
                        t_p.id_pext,
                        t_c.descripcion,
                        dc.apellido || ' '|| dc.nombre || ' '|| dc.tipo_docum || ' '|| dc.nro_docum as director,
                        t_p.denominacion,
                        t_p.uni_acad,
                        t_p.fec_desde,
                        t_p.fec_hasta,  
                        t_p.ord_priori,
                        t_p.id_estado,
                        t_p.responsable_carga,
                        b_c.id_bases,
                        s_c.codigo
                    FROM
                        pextension as t_p INNER JOIN
                        (SELECT t_ua.* FROM dblink('" . $this->dblink_designa() . "','SELECT sigla FROM unidad_acad ') as t_ua (sigla CHARACTER(5) )) as t_ua ON (t_p.uni_acad = t_ua.sigla)
                        LEFT OUTER JOIN integrante_interno_pe as i ON (t_p.id_pext = i.id_pext AND i.funcion_p='D' AND i.hasta >= '" . date('Y-m-d') . "')
                        LEFT OUTER JOIN ( SELECT d.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT d.id_designacion,d.id_docente FROM designacion as d ') as d ( id_designacion INTEGER,id_docente INTEGER)) as d ON (i.id_designacion = d.id_designacion)
                        LEFT OUTER JOIN ( SELECT dc.* FROM dblink('" . $this->dblink_designa() . "', 'SELECT dc.id_docente,dc.nombre, dc.apellido, dc.tipo_docum, dc.nro_docum FROM docente as dc ') as dc ( id_docente INTEGER,apellido CHARACTER VARYING, nombre CHARACTER VARYING, tipo_docum CHARACTER(4), nro_docum INTEGER)) as dc ON (d.id_docente = dc.id_docente)
                        LEFT OUTER JOIN bases_convocatoria as b_c ON (t_p.id_bases = b_c.id_bases)
                        LEFT OUTER JOIN tipo_convocatoria as t_c ON (t_c.id_conv = b_c.tipo_convocatoria)  
                        LEFT OUTER JOIN seguimiento_central as s_c ON (t_p.id_pext = s_c.id_pext)) AUX "
                . $where;
        $sql = toba::perfil_de_datos()->filtrar($sql);
        return toba::db('extension')->consultar($sql);
    }

    function get_proyectos_anteriores($id_doc) {

        $sql = "SELECT
			t_p.id_pext,
                        t_p.denominacion,
                        t_ua.descripcion as uni_acad_nombre,
                        t_p.departamento,
                        t_p.area,
                        t_p.fec_desde,
                        t_p.fec_hasta,
                        t_e.id_estado,
                        t_e.descripcion as descripcion_estado,
                        t_p.uni_acad,
                        s_c.estado_informe_f,
                        s_c.estado_rendicion,
                        
                        d.apellido || ' '|| d.nombre || ' '|| d.tipo_docum || ' '|| d.nro_docum as director,
                        d.correo_institucional as dir_email,
               
                        b_c.id_bases,
                        t_c.id_conv
                    FROM
                        pextension as t_p INNER JOIN"
                . "(SELECT t_ua.* FROM dblink('" . $this->dblink_designa() . "','SELECT sigla,descripcion FROM unidad_acad') as t_ua (sigla CHARACTER(5), descripcion CHARACTER(60))) as t_ua ON (t_p.uni_acad = t_ua.sigla)
                        LEFT OUTER JOIN integrante_interno_pe as i ON (t_p.id_pext = i.id_pext AND i.funcion_p='D')
                        LEFT OUTER JOIN (SELECT d.* FROM  dblink('" . $this->dblink_designa() . "', 
                                    'SELECT d.id_designacion, dc.id_docente , dc.apellido, dc.nombre, dc.tipo_docum, dc.nro_docum,dc.correo_institucional
                                     FROM designacion as d LEFT OUTER JOIN docente as dc
                                            ON(dc.id_docente = d.id_docente)') as d 
                                            ( id_designacion INTEGER ,id_docente INTEGER ,apellido CHARACTER VARYING, nombre CHARACTER VARYING, tipo_docum CHARACTER(4), nro_docum INTEGER,correo_institucional CHARACTER(60) )) as d ON (i.id_designacion=d.id_designacion)
                                            
                        LEFT OUTER JOIN integrante_interno_pe as i_co ON (t_p.id_pext = i_co.id_pext AND i_co.funcion_p='CD-Co')                        
                        LEFT OUTER JOIN (SELECT co.* FROM  dblink('" . $this->dblink_designa() . "', 
                                    'SELECT d.id_designacion, dc.id_docente , dc.apellido, dc.nombre, dc.tipo_docum, dc.nro_docum,dc.correo_institucional
                                     FROM designacion as d LEFT OUTER JOIN docente as dc
                                            ON(dc.id_docente = d.id_docente)') as co 
                                            ( id_designacion INTEGER ,id_docente INTEGER ,apellido CHARACTER VARYING, nombre CHARACTER VARYING, tipo_docum CHARACTER(4), nro_docum INTEGER,correo_institucional CHARACTER(60) )) as co ON (i_co.id_designacion=co.id_designacion)
                        
                        LEFT OUTER JOIN bases_convocatoria as b_c ON (b_c.id_bases = t_p.id_bases)
                        LEFT OUTER JOIN tipo_convocatoria as t_c ON (t_c.id_conv = b_c.tipo_convocatoria)
                        LEFT OUTER JOIN estado_pe as t_e ON (t_e.id_estado = t_p.id_estado)
                        LEFT OUTER JOIN seguimiento_central as s_c ON (s_c.id_pext = t_p.id_pext)
                        
                    WHERE
                        extract(year from  b_c.fecha_hasta) < extract(year from  current_date) AND b_c.fecha_desde = t_p.fec_desde
                        AND dc.id_docente = $id_doc
                        ";

        return toba::db('extension')->consultar($sql);
    }

    function get_descripciones() {
        $sql = "SELECT id_pext, denominacion FROM pextension ORDER BY denominacion";
        return toba::db('extension')->consultar($sql);
    }
    function resetear_monto($id_pext) {
        $sql = "update pextension set monto=0 where id_pext=".$id_pext;
        toba::db('extension')->consultar($sql);
    }

}