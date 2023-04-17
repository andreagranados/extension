<?php

class form_solicitud_ocultar_mostrar extends toba_ei_formulario {

    function extender_objeto_js() {
        $id_js = toba::escaper()->escapeJs($this->objeto_js);

        echo "
                    
                {$id_js}.evt__tipo_solicitud__procesar = function(es_inicial) 
                {
                    
                    switch (this.ef('tipo_solicitud').get_estado()) {
                        case 'I':
                            
                            this.ef('estado_solicitud_aux1').mostrar();
                            this.ef('recibido').mostrar();
                            this.ef('estado_solicitud_aux2').ocultar();

                            this.ef('barra1_aux').ocultar();
                            this.ef('barra2_aux').ocultar();
                            break;
                        case 'P':
                            
                            this.ef('estado_solicitud_aux2').mostrar();
                            this.ef('recibido').mostrar();
                            this.ef('estado_solicitud_aux1').ocultar();
                            
                            this.ef('barra1').ocultar();
                            this.ef('barra2').ocultar();
                            this.ef('barra2_aux').ocultar();
  
                            break;
                        default:
                            this.ef('estado_solicitud_aux1').ocultar();
                            this.ef('estado_solicitud_aux2').ocultar();
                            this.ef('barra1').ocultar();
                            this.ef('barra2').ocultar();
                            this.ef('barra1_aux').ocultar();
                            this.ef('barra2_aux').ocultar();
                            this.ef('recibido').ocultar();
                            this.ef('fecha_dictamen').ocultar();/*andrea*/
                            break;
                            
                    }
                }
		
		{$id_js}.evt__recibido__procesar = function(es_inicial) 
                {
                    if(this.ef('recibido').chequeado())
                    {
                        switch (this.ef('tipo_solicitud').get_estado()) {
                            case 'I':
                                this.ef('descrip_ua').mostrar();
                                this.ef('estado_solicitud_aux1').mostrar();
                                
                                break;
                            case 'P':
                                    this.ef('descrip_ua').ocultar();
                                    this.ef('estado_solicitud_aux2').mostrar();
                                break;
                            default:
                                    
                                break;
                        }
                        this.ef('fecha_solicitud').mostrar();
                        this.ef('fecha_recepcion').mostrar();
                        
                    }else{
                        this.ef('descrip_ua').ocultar();
                        this.ef('fecha_solicitud').ocultar();
                        this.ef('fecha_recepcion').ocultar();
                        
                        this.ef('nro_acta').ocultar();
                        this.ef('fecha_fin_prorroga').ocultar();
                        this.ef('obs_resolucion').ocultar();
                        this.ef('id_estado').ocultar();
                        this.ef('fecha_dictamen').ocultar();
                        this.ef('estado_solicitud_aux1').ocultar();
                        this.ef('estado_solicitud_aux2').ocultar();
                    }
                }
                
                
                    
                {$id_js}.evt__estado_solicitud_aux1__procesar = function(es_inicial) 
                {
                    switch (this.ef('estado_solicitud_aux1').get_estado()) {
                                    case 'Aceptada':
                                            this.ef('nro_acta').mostrar();
                                            this.ef('fecha_dictamen').mostrar();
                                            this.ef('obs_resolucion').mostrar();
                                            this.ef('descrip_ua').mostrar();
                                            
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('id_estado').ocultar();
                                            break;
                                    case 'Rechazada':
                                            this.ef('nro_acta').mostrar(); 
                                            this.ef('fecha_dictamen').mostrar();
                                            this.ef('obs_resolucion').mostrar();
                                            this.ef('descrip_ua').mostrar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('id_estado').ocultar();
                                            
                                            break;
                                    case 'Enviada':
                                            this.ef('nro_acta').ocultar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('obs_resolucion').ocultar();
                                            this.ef('id_estado').ocultar();
                                            this.ef('fecha_dictamen').ocultar();
                                            break;
                                    case 'Recibida':
                                            this.ef('nro_acta').ocultar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('obs_resolucion').ocultar();
                                            this.ef('id_estado').ocultar();
                                            this.ef('fecha_dictamen').ocultar();
                                            break;
                                    default:
                                            this.ef('fecha_dictamen').ocultar();/*andrea*/
                            
                                           break;
                    }
                }
                
                {$id_js}.evt__estado_solicitud_aux2__procesar = function(es_inicial) 
                {
                    switch (this.ef('estado_solicitud_aux2').get_estado()) {
                                    case 'Aceptada':
                                            this.ef('nro_acta').mostrar();
                                            this.ef('fecha_dictamen').mostrar();
                                            this.ef('obs_resolucion').mostrar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('descrip_ua').ocultar();
                                            switch (this.ef('tipo_cambio').get_estado()) {
                                                    case 'B':
                                                        this.ef('id_estado').mostrar();
                                                    break;
                                                    case 'P': 
                                                            this.ef('fecha_fin_prorroga').mostrar();
                                                            this.ef('id_estado').mostrar();
                                                    break;
                                                    case 'F':
                                                        this.ef('id_estado').mostrar();
                                                    break;
                                                    default:
                                                        this.ef('id_estado').ocultar();
                                                    break;
                                            }
                                            break;
                                    case 'Rechazada':
                                            this.ef('nro_acta').mostrar(); 
                                            this.ef('fecha_dictamen').mostrar();
                                            this.ef('obs_resolucion').mostrar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('id_estado').ocultar();
                                            break;
                                    case 'Enviada':
                                            this.ef('nro_acta').ocultar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('obs_resolucion').ocultar();
                                            this.ef('id_estado').ocultar();
                                            this.ef('fecha_dictamen').ocultar();
                                            this.ef('descrip_ua').ocultar();
                                            this.ef('estado_solicitud_aux2').ocultar();
                                            break;
                                    case 'Recibida':
                                            this.ef('nro_acta').ocultar();
                                            this.ef('fecha_fin_prorroga').ocultar();
                                            this.ef('obs_resolucion').ocultar();
                                            this.ef('id_estado').ocultar();
                                            this.ef('fecha_dictamen').ocultar();
                                            this.ef('descrip_ua').ocultar();
                                            break;
                                    default:
                                            this.ef('fecha_dictamen').ocultar();/*andrea*/
                                           break;
                    }
                }
                
          
                
                ";
    }

}

?>                                                                                               