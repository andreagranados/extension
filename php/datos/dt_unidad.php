<?php   
require 'consultas_designa.php';
//comentario de prueba
class dt_unidad extends extension_datos_tabla 
{
    //trae todas las dependencias 
    function get_descripciones() {

        $sql = "SELECT sigla,descripcion FROM unidad  "
                . " ORDER BY descripcion";
        return toba::db('extension')->consultar($sql);
    }
    function get_unidades()
    {
        $sql="SELECT * "
                . " FROM unidad";
        return toba::db('extension')->consultar($sql);
    }
    function get_ua()
    {
        $recurso='unidades';
        $condicion=null;
        $valor=null;
        //primero veo si esta asociado a un perfil de datos y obtengo la ua del departamento
        $perfil_datos = toba::perfil_de_datos('extension')->get_restricciones_dimension('extension', 'unidad')[0];
        if(isset($perfil_datos)){
            $valor=$perfil_datos;
            $condicion="es_igual_a";
        }
        $res = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $res;
    }
     function get_ua_restantes($sigla) {
        $recurso='unidades';
        $condicion=null;
        $valor=null;
        if(isset($sigla)){
            $condicion='es_distinto_de';
            $valor=$sigla;
        }
        //http://localhost/designa/1.0/rest/unidad?sigla=es_distinto_de;CRUB
        $res = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $res;
    }
    function get_departamentos($id_ua = null)
    {//si recibe parametro entonces filtra por la ua que recibe
        $recurso='departamentos';
        $condicion=null;
        $valor=null;
        if (isset($id_ua)) {
            $valor=trim($id_ua);
        }
        //obtengo el perfil de datos del usuario logueado
        $perfil_datos = toba::perfil_de_datos('extension')->get_restricciones_dimension('extension', 'unidad')[0];
        if(isset($perfil_datos)){
            $valor=trim($perfil_datos);
        }
        $res = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $res;
    }   
    function get_areas($id_nro_dpto=null)
    {
        $recurso='areas';
        $condicion=null;
        $valor=null;  

        if(isset($id_nro_dpto)){
               $valor=$id_nro_dpto;
               $condicion='es_igual_a';
            }
        $res = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $res; 
    }
    //trae todos los docentes directores de proyectos de extension
    function get_directores($recurso,$condicion,$valor)
    {        
        $res = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $res; 
    }
     //trae todos los docentes codirectores de proyectos de extension
    function get_codirectores($recurso,$condicion,$valor)
    {
        //$recurso='docentes';
        //$condicion='docentesdirectorespe';
        //$valor=null;  
        $res = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $res; 
    }
     //trae todos los datos personales de los integrantes de proyectos de extension (integrante_interno_pe)
    function get_integrantes($valor)
    {
        $recurso='integrantes-pext';
        $condicion='integrantespext';
        $res = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $res; 
    }
  //trae todos los docentes de designa
    function get_docentes($where=null) {
       // print_r($where);//Array ( [apellido] => Array ( [condicion] => contiene [valor] => gra ) [nro_docum] => Array ( [condicion] => es_igual_a [valor] => 28399996 ) [legajo] => Array ( [condicion] => es_igual_a [valor] => 5698 ) )
        $band=true;
        $where2=" WHERE 1=1 ";
        //$condicion=null;
        $condicion="docentesunco";
        $valor=null;
        $recurso="docentes";
        if(isset($where)){//selecciono filtros
            $band=false;
            $where2.=' and '.$where;
        }
        $datos = consultas_designa::get_datos($recurso,$condicion,$valor);
        if(!$band){//sino tiene filtros
            #Crea la tabla temporal
            $query=" CREATE LOCAL TEMP TABLE auxi(
                        id serial NOT NULL PRIMARY KEY,
                        docente json
            );";
            toba::db('extension')->consultar($query);

            foreach ($datos as $value) {//cada elemento es un arreglo
            //Devuelve un string con la representación JSON de value.
                $datos2=json_encode($value);
                $query = "INSERT INTO auxi (docente) VALUES("
                . quote($datos2).");";
                toba::db('extension')->consultar($query);
            }
            $query="select * from (select docente->>'id_docente' as id_docente,"
            . "docente->>'apellido' as apellido,"
            . "docente->>'nombre' as nombre,"
            . "docente->>'legajo' as legajo,"
            . "docente->>'tipo_docum' as tipo_docum,"
            . "docente->>'nro_docum' as nro_docum"
            . " from auxi)sub "
            . "$where2";

            $datos=toba::db('extension')->consultar($query);
        }
        return $datos;
    }
    function get_id_docente($id_desig) {//trae los datos del docente cuya id_designacion es
        $condicion='docentescondicion?iddesig=';
        $valor=$id_desig;
        $recurso="docentes";
        $result = consultas_designa::get_datos($recurso,$condicion,$valor);
        //aqui armar un arreglo como Array ( [nombre] => GABRIELA NOEMI, ARANDA [id_docente] => 7 ) 
        $salida['id_docente']=$result[0]['id_docente'];
        $salida['nombre']=$result[0]['apellido'].", ".$result[0]['nombre'];
        return $salida;
    }
    //trae las designaciones de un docentes
    //debe excluir las designaciones que estan anuladas
    function get_categorias_doc($id_doc = null) {
        $condicion=null;
        $valor=null;
        $recurso="categoriasdocentes";
        //http://localhost/designa/1.0/rest/designaciones/categoriasdocentes?id_doc=es_igual_a;1537
        
        if (!is_null($id_doc)) {
            $condicion='es_igual_a';
            $valor=$id_doc;
            $res = consultas_designa::get_datos($recurso,$condicion,$valor);
        }
        else{
            $res = array();
        }
        return $res;
    }
    function get_pais() {//trae argentina
        $condicion='es_igual_a';
        $valor="AR";
        $recurso="pais";
        $result = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $result;
        //ojo aqui, no se porque no muestra nada en el combo cuando llamo por paises/AR 
    }
    function get_provincias($pais){
        $recurso="provincias";
        $condicion=null;
        $valor=null;
        if(isset($pais)){
            $condicion='es_igual_a';
            $valor=$pais;
        }
        
        $result = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $result;
    }
    static function get_paises_todos() {//trae argentina
        $condicion=null;
        $valor=null;
        $recurso="pais";
        $result = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $result;
    }
    function get_localidades($pcia){
        $recurso="localidades";
        $condicion=null;
        $valor=null;
        if(isset($pcia)){
            $condicion='es_igual_a';
            $valor=$pcia;
        }
        $result = consultas_designa::get_datos($recurso,$condicion,$valor);
        //print_r($result);exit;
//        $salida=array();
//        foreach ($result as $key => $value) {
//                $elem['id']=$value['id'];
//                $elem['id_provincia']=$value['id_provincia'];
//                $elem['localidad']=mb_convert_encoding($value['localidad'],'ISO-8859-1', 'UTF-8');
//                array_push($salida, $elem);
//        }
//        return $salida;
        return $result;
    }
     //retorna la UA de una designacion docente
     function get_ua_designacion($id_des) {
        $recurso="designaciones";
        $condicion="designacionestodas";
        $valor=null;
        if(isset($id_des)){
            $valor=$id_des;
        }
        $result = consultas_designa::get_datos($recurso,$condicion,$valor);
        return $result[0]['uni_acad'];
    }
}