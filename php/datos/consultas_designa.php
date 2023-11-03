<?php
class consultas_designa
{
     //metodo generico para todos los servicios web que consume el modulo extension del modulo designa 
    //variables definidas en extension
    function get_datos($recurso,$cond=null,$valor=null){
        $username = getenv('SW_USUARIO');   
        $password = getenv('SW_CLAVE');
        $condicion = ""; 
       
        switch ($recurso) {
            case 'unidades': 
                $url=getenv('SW_URL_UA');
                if(!is_null($valor)&&!is_null($cond)){
                    //$condicion = "?sigla=es_igual_a;".trim($valor) ;
                    $condicion = "?sigla=".$cond.";".trim($valor) ;
                    //http://localhost/designa/1.0/rest/unidad
                }
                break;
            case 'departamentos': 
                $url=getenv('SW_URL_DEP');
                if(!is_null($valor)){
                    $condicion = "?unidad_academica=es_igual_a;".trim($valor) ;
                    //http://localhost/designa/1.0/rest/departamentos?unidad_academica=es_igual_a;CRUB
                }
                break;
            case 'areas': 
                $url=getenv('SW_URL_AREAS');
                if(!is_null($valor)&&!is_null($cond)){
                    $condicion = "?id_departamento=".$cond.";".$valor;
                    //http://localhost/designa/1.0/rest/areas?id_departamento=es_igual_a;75
                }
                break;
            case 'docentes': 
                $url=getenv('SW_URL_DOCEN');
                //$condicion = "/docentesunco";//retorna todos los docentes
                //$condicion = "/docentesdirectorespe";//retorna los docentes directores de proy de ext
               
                if(!is_null($cond)){
                    if(!is_null($valor)){
                        //http://localhost/designa/1.0/rest/docentes/docentesdirectorespe/503
                        $condicion = "/".$cond."?id-pext=es_igual_a;".$valor;
                    }else{//trae todos
                        $condicion = "/".$cond;
                        //http://localhost/designa/1.0/rest/docentes/docentesunco
                        ////http://localhost/designa/1.0/rest/docentes/docentesdirectorespe
                    }
                }
                break;
            case 'integrantes-pext': 
                $url=getenv('SW_URL_EXT_INT');
                
                if(!is_null($cond)){
                    if(!is_null($valor)){
                       // http://localhost/designa/1.0/rest/integrantes-pext/integrantespext?id-pext=es_igual_a;501
                        $condicion = "/".$cond."?id-pext=es_igual_a;".$valor;
                    }else{//trae todos
                        $condicion = "/".$cond;
                        //http://localhost/designa/1.0/rest/integrantes-pext/integrantespext	
                    }
                }
                break;    
            case 'categoriasdocentes': 
                $url=getenv('SW_URL_DESIG');
                $url.="/categoriasdocentes";
                if(!is_null($cond)){//http://localhost/designa/1.0/rest/designaciones/categoriasdocentes?id_doc=es_igual_a;1537
                    $condicion = "?id_doc=".$cond.";".$valor;
                }
                break;
            case 'designaciones': 
                $url=getenv('SW_URL_DESIG');
                
                if(!is_null($cond)){//http://localhost/designa/1.0/rest/designaciones/categoriasdocentes?id_doc=es_igual_a;1537
                    $condicion = "/".$cond."?=es_igual_a;".$valor;
                }
                break;
//            case 'pais': //asi no funciona para mostrar en el combo cuando viene con AR 
//                $url=getenv('SW_URL_PAIS');
//                if(!is_null($valor)){
//                    $condicion = "/".$valor;
//                }
//                break; 
            case 'pais': 
                $url=getenv('SW_URL_PAIS');
                if(!is_null($valor)){
                    //http://localhost/designa/1.0/rest/paises?codigo=es_igual_a;AF
                    $condicion = "?codigo=".$cond.";".trim($valor) ;
                }
                break;
            case 'provincias': 
                $url=getenv('SW_URL_PROV');
                if(!is_null($valor)){                 
                    $condicion = "?codpais=".$cond.";".trim($valor) ;
                }
                break; 
            case 'localidades': 
                $url=getenv('SW_URL_LOC');
                if(!is_null($valor)){     //localidades de una determinada provincia
                    $url=getenv('SW_URL_PROV');
                    $condicion = "/".$valor."/localidades" ;
                }
                break;     
            default:
                break;
        }
       
        $url.=$condicion; 
        //print_r($url);
        //print_r($condicion);
        # Inicializar una sesión cURL
        $curl = curl_init($url);
        

        # Configurar opciones de la solicitud
        curl_setopt_array($curl, [
        CURLOPT_URL => $url, # Define la URL a la que se realiza la solicitud HTTP
        CURLOPT_RETURNTRANSFER => true, # Indica que debe devolver el resultado de la solicitud como una cadena de texto en lugar de mostrarlo directamente en la salida. Es util para capturarlo en una variable
        //CURLOPT_ENCODING => "UNICODE", # Permite especificar la codificación de caracteres que se debe utilizar al recibir la respuesta del servidor
        CURLOPT_ENCODING => "ISO-8859-1", # Permite especificar la codificación de caracteres que se debe utilizar al recibir la respuesta del servidor
        CURLOPT_MAXREDIRS => 10, # Establece el numero maximo de redirecciones que seguira cURL antes de abortar la solicitud
        CURLOPT_TIMEOUT => 30,# Establece el tiempo maximo que esperará cURL para recibir la respuesta antes de abortar la solicitud, en segundos
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, # Especifica la version del protocolo HTTP que se utilizara en la solicitud
        CURLOPT_CUSTOMREQUEST => "GET", # Especifica el tipo de solicitud HTTP que se realizará al servidor
        CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,# Define el tipo de autenticacion que utilizara la solicitud, debe ser la misma que está definida en el proyecto
        CURLOPT_USERPWD => $username . ":" . $password # Establece las credenciales de usuarios que son necesarias la autenticacion
        ]);

        # Realizar la solicitud GET
        $response = curl_exec($curl);
        
        # Verificar si la solicitud fue exitosa
        if ($response === false) {
            # Manejar el error
            $error = curl_error($curl);
            echo 'Error en la solicitud: ' . $error;
        } else {
            # Decodificar la respuesta JSON y transforma los caracteres a UNICODE y quita las barras invertidas.            
            //$data = json_decode($response, true, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $data = json_decode($response, true, JSON_UNESCAPED_SLASHES);
            
            if ($data !== null) {
                if($recurso!='docentes' && $recurso!='integrantes-pext' && $recurso!='localidades' && $recurso!='pais' && $recurso!='provincias'){//si le aplico la decodificacion no me inserta en tabla temporal
                    // Recorrer el arreglo y aplicar mb_convert_encoding a cada elemento
                    array_walk_recursive($data, function (&$elemento) {
                        $elemento = mb_convert_encoding($elemento, 'ISO-8859-1', 'UTF-8');
                    });
                }
            }
            // Verifica si hubo un error
            # Verificar si la decodificación fue exitosa
            if ($data === null) {
                # Manejar el error de decodificación JSON
                $error = json_last_error_msg(). json_last_error();
                echo 'Error al decodificar la respuesta JSON: ' . $error;
            } else {
                # Acceder a los datos de la respuesta
                return $data;
            }
        }
        # Cerrar la sesión cURL
        curl_close($curl);
    }   
}
?>