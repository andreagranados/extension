<?php
class modelo_integrantes
{
    protected $id;

    static function get_integrantes($where = "", $order_by = "", $limit = "")
    {
        if ($order_by == "") {
            $order_by = "ORDER BY id_designacion ASC";
        }
        $sql = "SELECT DISTINCT
                    id_designacion
                FROM 
                    integrante_interno_pe
                WHERE  $where $order_by $limit";
        $datos = toba::db()->consultar($sql);
        return $datos;
    }

    static function get_cant_integrantes($where = "")
    {
        $sql = "SELECT 
					count(*) as cantidad
				FROM 
                    integrante_interno_pe
				WHERE $where";
        $datos = toba::db()->consultar_fila($sql);
        return $datos['cantidad'];
    }

    function __construct($id)
    {
        $this->id = (int)$id;
    }


    function get_datos()
    {
        $sql = "SELECT
                    id_designacion
                FROM 
                    integrante_interno_pe
                WHERE id_designacion = " . quote($this->id);

        $fila = toba::db()->consultar_fila($sql);

        return $fila;
    }
}
