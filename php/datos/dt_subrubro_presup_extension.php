<?php
class dt_subrubro_presup_extension extends extension_datos_tabla {
    
    function get_descripciones($id_rubro_extension = null) {
        if(isset($id_rubro_extension)){
          $where=" WHERE id_rubro_extension=$id_rubro_extension";  
        }else{
          $where=" WHERE 1=1 ";  
        }
        $sql = "SELECT
                    id_subrubro_extension,
                    id_rubro_extension ,
                    descripcion
                    
                FROM
                   subrubro_presup_extension  
                $where
                ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
    }
}
?>
