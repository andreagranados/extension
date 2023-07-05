<?php

class ci_bases extends extension_ci {

    protected $s__mostrar;
    protected $s__where = null;
    protected $s__datos_filtro = null;
    protected $s__rubro = null;
    protected $s__bases;
    protected $s__datos;

    function get_eje_tematico($id) {
        
    }

    function ajax__descargar_bases($id_fila, toba_ajax_respuesta $respuesta) {

        $this->s__bases = $this->s__datos[$id_fila]['id_bases'];

        $respuesta->set($id_fila);
    }
//-----------------------------------------------------------------------------------
//---- filtro -----------------------------------------------------------------------
//-----------------------------------------------------------------------------------

    /**
     * Permite cambiar la configuraci�n del formulario previo a la generaci�n de la salida
     * El formato del carga debe ser array(<campo> => <valor>, ...)
     */
    function conf__filtro(toba_ei_filtro $filtro) {
        if (isset($this->s__datos_filtro))
            $filtro->set_datos($this->s__datos_filtro);
    }

    /**
     * Atrapa la interacci�n del usuario con el bot�n asociado
     * @param array $datos Estado del componente al momento de ejecutar el evento. 
     * El formato es el mismo que en la carga de la configuraci�n
     */
    function evt__filtro__filtrar($datos) {
        $this->s__where = $this->dep('filtro')->get_sql_where();
        $this->s__datos_filtro = $datos;
    }

    /**
     * Atrapa la interacci�n del usuario con el bot�n asociado
     */
    function evt__filtro__cancelar() {
//completar
//$this->dep('filtro')->limpiar_interface();
        $this->s__datos_filtro = array();
        $this->evt__filtro__filtrar($this->s__datos_filtro);
    }

//------------------------------------------------------------------------------------
//------------------------------ CUADRO ----------------------------------------------
//------------------------------------------------------------------------------------

    function conf__cuadro(toba_ei_cuadro $cuadro) {
        $perfil = toba::manejador_sesiones()->get_perfiles_funcionales()[0];
        if ($perfil != 'sec_ext_central' && $perfil != 'admin') {
            $this->dep('cuadro')->evento('seleccion')->ocultar();
            $this->controlador()->evento('nuevo')->ocultar();
        }
        $this->dep('datos')->resetear();
        if (!is_null($this->s__where)) {
            $this->s__datos = $this->dep('datos')->tabla('bases_convocatoria')->get_listado($this->s__where);
        } else {
            $this->s__datos = $this->dep('datos')->tabla('bases_convocatoria')->get_listado();
        }
        foreach($this->s__datos as $dato => $valor){
            
                if(isset($valor['ordenanza']))
                    $this->s__datos[$dato]['ordenanza']="<a href='".$this->s__datos[$dato]['ordenanza']."'target='_blank'>link a ordenanza</a>";            
        }
        
        $cuadro->set_datos($this->s__datos);
    }

    function evt__cuadro__seleccion($datos) {
        $this->set_pantalla('pant_edicion');
        $this->dep('datos')->tabla('bases_convocatoria')->cargar($datos);
    }

    function conf__cuadro_ejes(toba_ei_cuadro $cuadro) {
        if ($this->dep('datos')->tabla('bases_convocatoria')->esta_cargada()) {
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
        }
        $cuadro->set_datos($this->dep('datos')->tabla('eje_tematico_conv')->get_listado($bases['id_bases']));
    }

    function evt__cuadro_ejes__seleccion($datos) {
        $this->s__mostrar = 1;
        $this->set_pantalla('pant_ejes');
        $this->dep('datos')->tabla('eje_tematico_conv')->cargar($datos);
    }

    function conf__cuadro_rubros(toba_ei_cuadro $cuadro) {
        if ($this->dep('datos')->tabla('bases_convocatoria')->esta_cargada()) {
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
        }
        $datos = array();
        $i = 0;
        $rubros = $this->dep('datos')->tabla('rubro_presup_extension')->get_tipo();
        foreach ($rubros as $rubro) {
            $monto = $this->dep('datos')->tabla('montos_convocatoria')->get_descripciones($rubro[id_rubro_extension], $bases[id_bases])[0];
            $datos[$i][id_rubro_extension] = $rubro[id_rubro_extension];
            $datos[$i][tipo] = $rubro[tipo];
            $datos[$i][porc] = $monto[porc];
            $i = $i + 1;
        }
        $band = $this->dep('datos')->tabla('montos_convocatoria')->menor_a_100($bases[id_bases]);
        if($band){
            $this->pantalla('pant_rubros')->agregar_notificacion('La suma total de porcentajes debe ser igual o mayor a 100%','error');
        }
        $cuadro->set_datos($datos);
    }

    function evt__cuadro_rubros__seleccion($datos) {
        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
        $datos[id_bases] = $bases[id_bases];
//        $rubros = $this->dep('datos')->tabla('rubro_presup_extension')->get_descripcion($datos[id_rubro_extension]);
        $this->s__mostrar = 1;
        $this->s__rubro = $datos[id_rubro_extension];
        $this->dep('datos')->tabla('montos_convocatoria')->cargar($datos);
    }


// ----------------- Otros eventos -------------------

    function evt__ejes_tematicos() {
        $this->s__mostrar = 0;
        $this->set_pantalla('pant_ejes');
    }

    function evt__nuevo($datos) {
        $this->set_pantalla('pant_edicion');
        $this->pantalla()->tab("pant_ejes")->ocultar();
    }

    function evt__agregar() {
        $this->s__mostrar = 1;
        $this->dep('datos')->tabla('eje_tematico_conv')->resetear();
        $this->set_pantalla('pant_ejes');
    }

    function evt__volver() {

        $this->set_pantalla('pant_edicion');
        $this->dep('datos')->tabla('bases_convocatoria')->resetear();
    }

    function conf__pant_edicion(toba_ei_pantalla $pantalla) {

        $this->s__pantalla = "pant_edicion";
        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();


        $this->pantalla()->tab("pant_cuadro")->desactivar();
        #$this->pantalla()->tab("pant_ejes")->desactivar();

        $this->pantalla()->tab("pant_cuadro")->ocultar();
        #$this->pantalla()->tab("pant_ejes")->ocultar();
        if (!$bases[tiene_monto]) {
            $this->pantalla()->tab("pant_rubros")->ocultar();
        }
    }

    function conf__pant_cuadro(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_cuadro";

        $this->pantalla()->tab("pant_edicion")->desactivar();
        $this->pantalla()->tab("pant_ejes")->desactivar();

        $this->pantalla()->tab("pant_edicion")->ocultar();
        $this->pantalla()->tab("pant_ejes")->ocultar();
        $this->pantalla()->tab("pant_rubros")->ocultar();
    }

    function conf__pant_ejes(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_ejes";
        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();

        $this->pantalla()->tab("pant_cuadro")->desactivar();
        #$this->pantalla()->tab("pant_ejes")->desactivar();

        $this->pantalla()->tab("pant_cuadro")->ocultar();
        #$this->pantalla()->tab("pant_ejes")->ocultar();
        if (!$bases[tiene_monto]) {
            $this->pantalla()->tab("pant_rubros")->ocultar();
        }
    }

    function conf__pant_rubros(toba_ei_pantalla $pantalla) {
        $this->s__pantalla = "pant_rubros";

        $this->pantalla()->tab("pant_cuadro")->desactivar();
        #$this->pantalla()->tab("pant_ejes")->desactivar();

        $this->pantalla()->tab("pant_cuadro")->ocultar();
        #$this->pantalla()->tab("pant_ejes")->ocultar();
    }

//---- Formulario -------------------------------------------------------------------

    function conf__form_ejes(toba_ei_formulario $form) {
        if ($this->s__mostrar == 1) {
            $this->dep('form_ejes')->descolapsar();
        } else {
            $this->dep('form_ejes')->colapsar();
        }
        if ($this->dep('datos')->tabla('eje_tematico_conv')->esta_cargada()) {
            $form->set_datos($this->dep('datos')->tabla('eje_tematico_conv')->get());
        }
    }

    function evt__form_ejes__alta($datos) {
        /*
         * todo: el periodo por defecto
         */

        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
        $fecha_actual=date('Y-m-d');
        if($fecha_actual>=$bases['fecha_desde']){
            toba::notificacion()->agregar('La convocatoria ya comenzo. Ya no puede modificar sus datos.', 'error');  
        }else{
            $tipo = $this->dep('datos')->tabla('tipos_ejes_tematicos')->get_tipo($datos['descripcion'])[0];

            $correcto = true;
            $ejes_conv = $this->dep('datos')->tabla('eje_tematico_conv')->get_listado($bases['id_bases']);
            // Control Ejes no repetidos 
            foreach ($ejes_conv as $eje) {
                if ($eje['id_eje'] == $tipo['id_eje']) {
                    $correcto = false;
                    toba::notificacion()->agregar('Eje tematico repetido, vuelva a intentarlo', 'info');
                }
            }
            if ($correcto) {
                $datos['id_bases'] = $bases['id_bases'];
                $datos['descripcion'] = $tipo['descripcion'];
                $datos['id_eje'] = $tipo['id_eje'];

                // control clave unica

                $this->dep('datos')->tabla('eje_tematico_conv')->set($datos);
                $this->dep('datos')->tabla('eje_tematico_conv')->sincronizar();
                $this->dep('datos')->tabla('eje_tematico_conv')->cargar($datos);

                $this->s__mostrar = 0;
            }
            //$this->dep('datos')->resetear();
            //$this->set_pantalla('pant_ejes');
        }
    }

    // problemas con la clave al modificar, no se actualiza ( Se elimino el evento )
    function evt__form_ejes__modificacion($datos) {
        $ejes = $this->dep('datos')->tabla('eje_tematico_conv')->get();
        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
        $fecha_actual=date('Y-m-d');
        if($fecha_actual>=$bases['fecha_desde']){
            toba::notificacion()->agregar('La convocatoria ya comenzo. Ya no puede modificar sus datos.', 'error');  
        }else{
            if ($ejes['descripcion'] == $datos['descripcion']) {
                $datos['descripcion'] = $ejes['id_eje'];
            }
            $tipo = $this->dep('datos')->tabla('tipos_ejes_tematicos')->get_tipo($datos['descripcion'])[0];

            $correcto = true;
            $ejes_conv = $this->dep('datos')->tabla('eje_tematico_conv')->get_listado($bases['id_bases']);
            // Control Ejes no repetidos 
            foreach ($ejes_conv as $eje) {
                if ($eje['id_eje'] == $tipo['id_eje']) {
                    $correcto = false;
                    toba::notificacion()->agregar('Eje tematico repetido, vuelva a intentarlo', 'info');
                }
            }
            if ($correcto) {
                $datos['id_bases'] = $bases['id_bases'];
                $datos['descripcion'] = $tipo['descripcion'];
                $datos['id_eje'] = $tipo['id_eje'];

                // control clave unica

                $this->dep('datos')->tabla('eje_tematico_conv')->set($datos);
                $this->dep('datos')->tabla('eje_tematico_conv')->sincronizar();

                $this->s__mostrar = 0;
            }
        }
    }

    function evt__form_ejes__baja() {
        $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
        $fecha_actual=date('Y-m-d');
        if($fecha_actual>=$bases['fecha_desde']){
            toba::notificacion()->agregar('La convocatoria ya comenzo. Ya no puede modificar sus datos.', 'error');  
        }else{
            $this->dep('datos')->tabla('eje_tematico_conv')->eliminar_todo();
            toba::notificacion()->agregar('El registro se ha eliminado correctamente', 'info');

            $this->dep('datos')->tabla('eje_tematico_conv')->resetear();
            //$this->set_pantalla('pant_ejes');
            $this->s__mostrar = 0;
        }
    }

    function evt__form_ejes__cancelar() {

        $this->dep('datos')->tabla('eje_tematico_conv')->resetear();
        $this->set_pantalla('pant_ejes');
        $this->s__mostrar = 0;
    }

    // Formulario montos

    function conf__formulario_montos(toba_ei_formulario $form) {
        if ($this->s__mostrar == 1) {
            $this->dep('formulario_montos')->descolapsar();
        } else {
            $this->dep('formulario_montos')->colapsar();
        }
        if ($this->dep('datos')->tabla('montos_convocatoria')->esta_cargada()) {
            $datos=$this->dep('datos')->tabla('montos_convocatoria')->get();
            $form->set_datos($datos);
        }
    }

    function evt__formulario_montos__modificacion($datos) {
            //hace el alta y la modificacion
        if($datos['porc']>100){
            toba::notificacion()->agregar('El porcentaje del rubro de la convocatoria no puede superar el 100%', 'info');
        }else{
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
            $fecha_actual=date('Y-m-d');
            if($fecha_actual>=$bases['fecha_desde']){
                toba::notificacion()->agregar('La convocatoria ya comenzo. Ya no puede modificar sus datos.', 'error');  
            }else{
                $datos['id_bases'] = $bases['id_bases'];
                $datos[id_rubro_extension] = $this->s__rubro;
                $this->dep('datos')->tabla('montos_convocatoria')->set($datos);
                $this->dep('datos')->tabla('montos_convocatoria')->sincronizar();
                $this->dep('datos')->tabla('montos_convocatoria')->resetear();
                $this->s__mostrar = 0;
            }
        }
    }

    function evt__formulario_montos__cancelar() {

        $this->dep('datos')->tabla('montos_convocatoria')->resetear();
        $this->s__mostrar = 0;
    }

    function conf__formulario(toba_ei_formulario $form) {
        if ($this->dep('datos')->tabla('bases_convocatoria')->esta_cargada()) {
            $datos = $this->dep('datos')->tabla('bases_convocatoria')->get();
            $form->set_datos($datos);
        }
    }

    function evt__formulario__alta($datos) {
        /*
         * todo: el periodo por defecto
         */
        if($datos['fecha_desde']>=$datos['fecha_hasta']){
                throw new toba_error(utf8_decode('La fecha hasta debe ser mayor a la fecha desde'));
        }else{ 
            if($datos['fecha_hasta']>=$datos['fecha_lim_modif']){
                throw new toba_error(utf8_decode('La fecha límite de modificación debe ser mayor a la fecha hasta'));
            }else{
                $this->dep('datos')->tabla('bases_convocatoria')->set($datos);
                $this->dep('datos')->tabla('bases_convocatoria')->sincronizar();
                $this->dep('datos')->tabla('bases_convocatoria')->cargar($datos);
            }
        }
    }

    function evt__formulario__modificacion($datos) {
       
        if ($this->dep('datos')->tabla('bases_convocatoria')->esta_cargada()) {
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();
           
            if($datos['fecha_desde']>=$datos['fecha_hasta']){
                toba::notificacion()->agregar('La fecha de fin debe ser mayor a la fecha desde', 'error');  
            }else{ 
                if($datos['fecha_hasta']>=$datos['fecha_lim_modif']){
                    toba::notificacion()->agregar('La fecha limite de modificacion debe ser mayor a la fecha hasta', 'error');  
                }else{
                    $fecha_actual=date('Y-m-d');
                    if($fecha_actual>=$bases['fecha_desde']){
                        toba::notificacion()->agregar('La convocatoria ya comenzo. Ya no puede modificar sus datos.', 'error');  
                    }else{
                        if(!$datos['tiene_monto']){//cuando modifica el monto
                            $datos['monto_max']=null;
                            $respuesta=$this->dep('datos')->tabla('montos_convocatoria')->eliminar_porcentajes_rubro($bases['id_bases']);
                            if($respuesta){
                              toba::notificacion()->agregar('Se han eliminado los porcentajes maximos por rubro', 'info');  
                            }
                        }
                        $this->dep('datos')->tabla('bases_convocatoria')->set($datos);
                        $this->dep('datos')->tabla('bases_convocatoria')->sincronizar();
                    }
                }
            }
        }
    }

    function evt__formulario__baja() {
        $this->dep('datos')->eliminar_todo();
        toba::notificacion()->agregar('El registro se ha eliminado correctamente', 'info');
        $this->resetear();
        $this->set_pantalla('pant_cuadro');
    }

    function evt__formulario__cancelar() {
        $this->resetear();
        $this->set_pantalla('pant_cuadro');
    }

    function resetear() {
        $this->dep('datos')->resetear();
    }

    function vista_pdf(toba_vista_pdf $salida) {
        if (isset($this->s__bases)) {
            $base['id_bases'] = $this->s__bases;
            $this->dep('datos')->tabla('bases_convocatoria')->resetear(); //limpia
            $this->dep('datos')->tabla('bases_convocatoria')->cargar($base); //carga el articulo que se selecciono
        }

        if ($this->dep('datos')->tabla('bases_convocatoria')->esta_cargada()) {
            $bases = $this->dep('datos')->tabla('bases_convocatoria')->get();

            $ejes_conv = $this->dep('datos')->tabla('eje_tematico_conv')->get_descripciones($bases[id_bases]);

            //configuramos el nombre que tendrá el archivo pdf
            $salida->set_nombre_archivo("Bases_Convocatoria.pdf");

            //recuperamos el objteo ezPDF para agregar la cabecera y el pie de página 
            $salida->set_papel_orientacion('portrait'); //landscape
            $salida->inicializar();
            //$salida->set_pdf_fuente('Times-Roman.afm');
            //$salida->set_papel_tamanio('A4');

            $pdf = $salida->get_pdf();
            //terc izquierda 
            //bajo normas Icontec y APA
            $pdf->ezSetCmMargins(2.54, 2.54, 2.54, 2.54);

            //Configuramos el pie de página. El mismo, tendra el número de página centrado en la página y la fecha ubicada a la derecha. 
            //Primero definimos la plantilla para el número de página.
            $formato = utf8_decode('Página {PAGENUM} de {TOTALPAGENUM} ');

            //Determinamos la ubicación del número página en el pié de pagina definiendo las coordenadas x y, tamaño de letra, posición, texto, pagina inicio 
            $pdf->ezStartPageNumbers(300, 20, 8, 'justify', utf8_d_seguro($formato), 1);
            //$pdf->ezText('full');
            //Luego definimos la ubicación de la fecha en el pie de página.
            $pdf->addText(380, 20, 8, 'Mocovi - Extension ' . date('d/m/Y h:i:s a'));

            //Configuración de Título.
            $salida->titulo(utf8_d_seguro('UNIVERSIDAD NACIONAL DEL COMAHUE' . chr(10) . 'SECRETARÍA DE EXTENSIÓN UNIVERSITARIA' . chr(10) . 'BASES DE CONVOCATORIA '));
            $titulo = "   ";




            $pdf->ezText("\n\n\n\n", 10, ['justification' => 'full']);
            //titulo ej: Convocatoria 2017 ( Ejecucion 2018)
            $pdf->ezText('' . utf8_d_seguro('<b>' . $bases['bases_titulo'] . '</b>'), 10, ['justification' => 'full']);
            //introduccion
            $pdf->ezText($bases['convocatoria'], 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);
            //objetivo
            $pdf->ezText('<b>' . utf8_d_seguro('OBJETIVOS: ') . '</b>', 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['objetivo']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> EJES TEMÁTICOS: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['eje_tematico_txt']), 10, ['justification' => 'full']);

            foreach ($ejes_conv as $eje) {
                $pdf->ezText(' - ' . $eje[descripcion], 10, ['justification' => 'full']);
            }

            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> DESTINATARIOS: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['destinatarios']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> INTEGRANTES - ¿QUIENES PUEDEN PARTIPAR? : </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['integrantes']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> MONTO A FINANCIAR: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['monto']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> DURACIÓN DE LOS PROYECTOS (EJECUCIÓN DE LOS PROYECTOS): </b>'), 10);
            $pdf->ezText(utf8_d_seguro($bases['duracion']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> FECHA DE PRESENTACIÓN: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['fecha']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> EVALUACIÓN: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['evaluacion']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> ADJUDICACIÓN DE LOS PROYECTOS: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['adjudicacion']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);

            $pdf->ezText(utf8_d_seguro('<b> CONSULTAS: </b>'), 10, ['justification' => 'full']);
            $pdf->ezText(utf8_d_seguro($bases['consulta']), 10, ['justification' => 'full']);
            //salto de linea
            $pdf->ezText('  ', 10, ['justification' => 'full']);




            // Logos pimera pagina
            $id = 7;
            $pdf->reopenObject($id); //definimos el path a la imagen de logo de la organizacion 
            //agregamos al documento la imagen y definimos su posición a través de las coordenadas (x,y) y el ancho y el alto.
            $imagen = toba::proyecto()->get_path() . '/www/img/logouniversidadgrande.jpg';
            $imagen2 = toba::proyecto()->get_path() . '/www/img/logouniversidadgrande.jpg';
            $pdf->addJpegFromFile($imagen, 40, 715, 70, 66);
            $pdf->addJpegFromFile($imagen2, 480, 715, 70, 66);
            $pdf->closeObject();
        }
    }

}

?>