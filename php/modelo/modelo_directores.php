<?php
class modelo_directores
{
    protected $id;

    static function get_directores($where = "", $order_by = "", $limit = "")
    {
        if ($order_by == "") {
            $order_by = "ORDER BY id_designacion ASC";
        }
        $where .= " AND funcion_p = 'D' ";

        $sql = "SELECT DISTINCT
                    id_designacion
				FROM 
                    integrante_interno_pe
				WHERE  $where $order_by $limit";

        $datos = toba::db()->consultar($sql);
        return $datos;
    }

    static function get_cant_directores($where = "")
    {
        $where .= " AND funcion_p = 'D' ";
        $sql = "SELECT count(*) as cantidad
		  FROM 
                    integrante_interno_pe
				WHERE  $where";
        $datos = toba::db()->consultar_fila($sql);
        return $datos['cantidad'];
    }

    function __construct($id)
    {
        $this->id = (int)$id;
    }


    function get_director()
    {
        $sql = "SELECT DISTINCT
                    id_designacion
				FROM 
                    integrante_interno_pe
                WHERE funcion_p = 'D' AND id_designacion = " . quote($this->id);


        $fila = toba::db()->consultar_fila($sql);

        return $fila;
    }

    static function get_codirectores($where = "", $order_by = "", $limit = "")
    {
        if ($order_by == "") {
            $order_by = "ORDER BY id_designacion ASC";
        }
        $where .= " AND funcion_p = 'CD-Co' ";

        $sql = "SELECT DISTINCT
                    id_designacion
				FROM 
                    integrante_interno_pe
				WHERE  $where $order_by $limit";

        $datos = toba::db()->consultar($sql);
        return $datos;
    }

    function get_codirector()
    {
        $sql = "SELECT DISTINCT
                    id_designacion
				FROM 
                    integrante_interno_pe
                WHERE funcion_p = 'CD-Co' AND id_designacion = " . quote($this->id);


        $fila = toba::db()->consultar_fila($sql);

        return $fila;
    }
    static function get_cant_codirectores($where = "")
    {
        $where .= " AND funcion_p = 'CD-Co' ";
        $sql = "SELECT 
					count(*) as cantidad
				FROM 
                    integrante_interno_pe
				WHERE $where";
        $datos = toba::db()->consultar_fila($sql);
        return $datos['cantidad'];
    }

}