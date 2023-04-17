<?php

class form_solicitud_ocultar_mostrar2 extends toba_ei_formulario {

    function extender_objeto_js() {
        $id_js = toba::escaper()->escapeJs($this->objeto_js);

        echo "
                    
                              
                {$id_js}.evt__estado_solicitud_aux2__procesar = function(es_inicial) 
                {
                    switch (this.ef('estado_solicitud_aux2').get_estado()) {
                                    case 'Aceptada': 
                                        switch (this.ef('tipo_cambio').get_estado()) {
                                            case 'P': 
                                               this.ef('fecha_fin_prorroga').mostrar();
                                               break;
                                             default: 
                                                this.ef('fecha_fin_prorroga').ocultar();
                                                break;
                                            }
                                            break;
                                    default:  
                                            this.ef('fecha_fin_prorroga').ocultar();
                                           break;
                    }
                }
                
          
                
                ";
    }

}

?>                                                                                               