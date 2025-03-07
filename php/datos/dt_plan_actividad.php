<?php

class dt_plan_actividad extends extension_datos_tabla {

    //Arreglar cuando el rubro ya esté definido
    function get_listado($id_obj = null) {

        $sql = "SELECT 
                
                p_a.id_plan ,
                p_a.id_rubro_extension ,
                p_a.id_obj_especifico ,
                p_a.destinatarios ,
                p_a.detalle ,
                p_a.fecha ,
                p_a.localizacion ,
                p_a.meta ,
                p_a.anio
                
                FROM plan_actividades as p_a INNER JOIN objetivo_especifico as o_e ON (p_a.id_obj_especifico = o_e.id_objetivo)
                WHERE p_a.id_obj_especifico = " . $id_obj .
                " ORDER BY id_plan";

        return toba::db('extension')->consultar($sql);
    }

    function get_datos($id_obj = null) {
        
        $sql = "SELECT
                
                    p_a.id_plan ,
                    p_a.id_rubro_extension ,
                    p_a.id_obj_especifico ,
                    p_a.destinatarios ,
                    p_a.detalle ,
                    p_a.fecha ,
                    p_a.localizacion ,
                    p_a.meta ,
                    p_a.anio
                FROM plan_actividades as p_a INNER JOIN objetivo_especifico as o_e ON (p_a.id_obj_especifico = o_e.id_objetivo)
                WHERE p_a.id_plan = " . $id_obj['id_plan'];
        return toba::db('extension')->consultar($sql);
    }

}