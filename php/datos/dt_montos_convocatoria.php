<?php

class dt_montos_convocatoria extends extension_datos_tabla {

    function menor_a_100($id_bases){
        $band=false;
        $sql = "SELECT sum(porc) as total "
                . " FROM montos_convocatoria "
                . " WHERE id_bases=$id_bases";
        $resultado= toba::db('extension')->consultar($sql);
        if(count($resultado)>0){
            if($resultado[0]['total']<100){
                $band=true;
            }
        }
        return $band;
    }
    //controla que el monto ingresado no supere el maximo total definido para el rubro
    function get_puedo_agregar_monto_max($id_rubro,$id_bases,$id_pext,$monto){
        $salida=false;
        $sql="select * from montos_convocatoria"
                . " where id_bases=$id_bases"
                . " and id_rubro_extension=$id_rubro";
        $resultado= toba::db('extension')->consultar($sql);
        if(count($resultado>0)){//en $resultado[0][porc] tengo el porcentaje total
       
            //obtengo el monto del proyecto
            $sql="select case when monto is not null then monto else 0 end as mont"
                    . " from pextension"
                    . " where id_pext=$id_pext ";
            $resulmonto= toba::db('extension')->consultar($sql);
             
            $financia_hasta=$resulmonto[0]['mont']*$resultado[0]['porc']/100;
            
            $sql_total=" select sum(monto) as total "
                    . " from presupuesto_extension "
                    . " where id_pext=$id_pext "
                    . " and id_rubro_extension=$id_rubro ";
            $resultotal= toba::db('extension')->consultar($sql_total);
            
            if(isset($resultotal[0]['total'])){//tiene otros items del rubro
                if(($resultotal[0]['total']+$monto)<=$financia_hasta){
                    $salida=true;
                }
            }else{//el proyecto no tiene nada de ese rubro
                if($monto<=$financia_hasta){
                    $salida=true;
                }
            }
        }//la convocatoria no financia el rubro salida en false
        return $salida;
    }
    //controla que el monto ingresado no supere el maximo total definido para el rubro
    function get_puedo_agregar_monto_max_modif($id_rubro,$id_bases,$id_pext,$monto,$id_presup){
        $salida=false;
        $sql="select * from montos_convocatoria"
                . " where id_bases=$id_bases"
                . " and id_rubro_extension=$id_rubro";
        $resultado= toba::db('extension')->consultar($sql);
        if(count($resultado>0)){//en $resultado[0][porc] tengo el porcentaje total
       
            //obtengo el monto del proyecto
            $sql="select case when monto is not null then monto else 0 end as mont"
                    . " from pextension"
                    . " where id_pext=$id_pext ";
            $resulmonto= toba::db('extension')->consultar($sql);
             
            $financia_hasta=$resulmonto[0]['mont']*$resultado[0]['porc']/100;
            
            $sql_total=" select sum(monto) as total "
                    . " from presupuesto_extension "
                    . " where id_pext=$id_pext "
                    . " and id_rubro_extension=$id_rubro "
                    . " and id_presupuesto<>$id_presup ";
            $resultotal= toba::db('extension')->consultar($sql_total);
            
            if(isset($resultotal[0]['total'])){//tiene otros items del rubro
                if(($resultotal[0]['total']+$monto)<=$financia_hasta){
                    $salida=true;
                }
            }else{//el proyecto no tiene nada de ese rubro
                if($monto<=$financia_hasta){
                    $salida=true;
                }
            }
        }//la convocatoria no financia el rubro salida en false
        return $salida;
    }
    function get_descripciones($id_rubro_extension = null,$id_bases = null) {
        $where = "";
        if (!is_null($id_rubro_extension)) {
            $where = " WHERE id_rubro_extension=$id_rubro_extension AND id_bases = $id_bases ";
        }
        $sql = "SELECT * "
                . " FROM montos_convocatoria "
                . " $where";
        return toba::db('extension')->consultar($sql);
        
    }
    function get_listado($id_bases = null){
        $where = "";
        if (!is_null($id_bases)) {
            $where = " WHERE id_bases=$id_bases";
        }
        $sql = "SELECT id_rubro_extension,id_bases, monto_max"
                . " FROM montos_convocatoria "
                . " $where";
        return toba::db('extension')->consultar($sql);
    }
    function eliminar_porcentajes_rubro($id_bases = null){
        $where = "";
        $band=false;
        if (!is_null($id_bases)) {
            $where = " WHERE id_bases=$id_bases";
            $sql = "DELETE "
                . " FROM montos_convocatoria "
                . " $where";
            toba::db('extension')->consultar($sql);
            $band=true;
        }
        return $band;
    }

}

?>