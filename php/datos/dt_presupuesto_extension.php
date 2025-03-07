<?php

class dt_presupuesto_extension extends extension_datos_tabla {

    function get_listado($id_p = null) {

        $sql = "select "
                . "p_e.id_pext,"
                . "p_e.id_presupuesto,"
                . "p_e.id_rubro_extension,"
                . "r.tipo as rubro,"
                . "p_e.concepto,"
                . "p_e.cantidad,"
                . "p_e.monto,"
                . "p_e.uni_acad ,"
                . " t_s.id_subrubro_extension ,"
                . " t_s.descripcion as subrubroextension "
                . " from presupuesto_extension as p_e "
                . " INNER JOIN rubro_presup_extension as r ON ( p_e.id_rubro_extension = r.id_rubro_extension )  "
                . " LEFT OUTER JOIN subrubro_presup_extension t_s ON (t_s.id_subrubro_extension=p_e.id_subrubro)"
                . " where id_pext=" . $id_p
                . " order by uni_acad,concepto";
        return toba::db('extension')->consultar($sql);
    }
    function get_montos($id_p = null) {

        $sql = "select "
                . "p_e.id_pext,"
                . "p_e.id_presupuesto,"
                . "p_e.monto,"
                . "p_e.uni_acad "
                . "from presupuesto_extension as p_e "
                . "INNER JOIN rubro_presup_extension as r ON ( p_e.id_rubro_extension = r.id_rubro_extension )  "
                . "where id_pext=" . $id_p
                . " order by uni_acad";
        return toba::db('extension')->consultar($sql);
    }

    function get_datos($id_presupuesto = null) {

        $sql = "select "
                . "p_e.id_pext,"
                . "p_e.id_presupuesto,"
                . "p_e.id_rubro_extension,"
                . "p_e.concepto,"
                . "p_e.cantidad,"
                . "p_e.monto "
                . "from presupuesto_extension as p_e "
                . "INNER JOIN rubro_presup_extension as r ON ( p_e.id_rubro_extension = r.id_rubro_extension )"
                . "LEFT OUTER JOIN pextension as p ON ( p_e.id_pext = p.id_pext )  "
                . " where p_e.id_presupuesto =" . $id_presupuesto;
        return toba::db('extension')->consultar($sql);
    }
    
    function get_listado_rubro($id_rubro_extension = null){
        $sql = "select "
                . "p_e.id_pext,"
                . "p_e.id_presupuesto,"
                . "p_e.id_rubro_extension,"
                . "r.tipo as rubro,"
                . "p_e.concepto,"
                . "p_e.cantidad,"
                . "p_e.monto "
                . "from presupuesto_extension as p_e "
                . "INNER JOIN rubro_presup_extension as r ON ( p_e.id_rubro_extension = r.id_rubro_extension )  "
                . "where p_e.id_rubro_extension=" . $id_rubro_extension
                . " order by concepto,monto";
        return toba::db('extension')->consultar($sql);
    }
     //monto total del presupuestos del proyecto de un rubro
    function get_total_rubro($id_pext = null,$id_rubro_extension = null){
        $salida=0;
        $sql="SELECT sum(monto) as total"
                . " FROM presupuesto_extension "
                . " WHERE id_pext=$id_pext"
                . " and id_rubro_extension=$id_rubro_extension";
        
        $resultado = toba::db('extension')->consultar($sql);
        if(count($resultado)>0){
            if(isset($resultado[0]['total'])){
                $salida=$resultado[0]['total'];
            } 
        }
        return $salida;
    }
    //monto total de todos los presupuestos del proyecto
    function get_total($id_pext = null){
        $salida=0;
        $sql="SELECT sum(monto) as total"
                . " FROM presupuesto_extension "
                . " WHERE id_pext=$id_pext";
        
        $resultado = toba::db('extension')->consultar($sql);
        if(count($resultado)>0){
            if(isset($resultado[0]['total'])){
                $salida=$resultado[0]['total'];
            } 
        }
        return $salida;
    }
    function get_total_modif($id_pext = null,$id_presup = null){
        $salida=0;
        $sql="SELECT sum(monto) as total"
                . " FROM presupuesto_extension "
                . " WHERE id_pext=$id_pext"
                . " and id_presupuesto<>$id_presup ";
        
        $resultado = toba::db('extension')->consultar($sql);
        if(isset($resultado[0]['total'])){
           $salida=$resultado[0]['total'];
        }
        return $salida;
    }
    function resetear_montos($id_pext = null){
         $sql=" UPDATE presupuesto_extension set monto=0 "
                . " WHERE id_pext=$id_pext";
         toba::db('extension')->consultar($sql);
    }
    function eliminar_presupuesto($id_pext = null){
         $sql=" delete from  presupuesto_extension"
                . " WHERE id_pext=$id_pext";
         toba::db('extension')->consultar($sql);
    }
}