------------------------------------------------------------
--[1001000208]--  Personas - Cuadro. 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'extension', --proyecto
	'1001000208', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_ei_cuadro', --clase
	'1001000004', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Personas - Cuadro.', --nombre
	'Listado de Personas', --titulo
	'0', --colapsable
	NULL, --descripcion
	NULL, --fuente_datos_proyecto
	NULL, --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2019-09-17 10:24:52', --creacion
	'abajo'  --posicion_botonera
);
--- FIN Grupo de desarrollo 1001

------------------------------------------------------------
-- apex_objeto_eventos
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'extension', --proyecto
	'1001000254', --evento_id
	'1001000208', --objeto
	'seleccion', --identificador
	NULL, --etiqueta
	'1', --maneja_datos
	'1', --sobre_fila
	NULL, --confirmacion
	NULL, --estilo
	'apex', --imagen_recurso_origen
	'tilde.gif', --imagen
	'0', --en_botonera
	NULL, --ayuda
	'1', --orden
	NULL, --ci_predep
	NULL, --implicito
	NULL, --defecto
	NULL, --display_datos_cargados
	NULL, --grupo
	'P', --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	'0', --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple, es_autovinculo) VALUES (
	'extension', --proyecto
	'1001000261', --evento_id
	'1001000208', --objeto
	'editar', --identificador
	NULL, --etiqueta
	'1', --maneja_datos
	'1', --sobre_fila
	NULL, --confirmacion
	NULL, --estilo
	'apex', --imagen_recurso_origen
	'editable.gif', --imagen
	'0', --en_botonera
	NULL, --ayuda
	'2', --orden
	NULL, --ci_predep
	NULL, --implicito
	NULL, --defecto
	NULL, --display_datos_cargados
	NULL, --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0', --es_seleccion_multiple
	'0'  --es_autovinculo
);
--- FIN Grupo de desarrollo 1001

------------------------------------------------------------
-- apex_objeto_cuadro
------------------------------------------------------------
INSERT INTO apex_objeto_cuadro (objeto_cuadro_proyecto, objeto_cuadro, titulo, subtitulo, sql, columnas_clave, columna_descripcion, clave_dbr, archivos_callbacks, ancho, ordenar, paginar, tamano_pagina, tipo_paginado, mostrar_total_registros, eof_invisible, eof_customizado, siempre_con_titulo, exportar_paginado, exportar, exportar_rtf, pdf_propiedades, pdf_respetar_paginacion, asociacion_columnas, ev_seleccion, ev_eliminar, dao_nucleo_proyecto, dao_nucleo, dao_metodo, dao_parametros, desplegable, desplegable_activo, scroll, scroll_alto, cc_modo, cc_modo_anidado_colap, cc_modo_anidado_totcol, cc_modo_anidado_totcua) VALUES (
	'extension', --objeto_cuadro_proyecto
	'1001000208', --objeto_cuadro
	NULL, --titulo
	NULL, --subtitulo
	NULL, --sql
	'tipo_docum,nro_docum', --columnas_clave
	'apellido', --columna_descripcion
	'0', --clave_dbr
	NULL, --archivos_callbacks
	'85%', --ancho
	'1', --ordenar
	'0', --paginar
	NULL, --tamano_pagina
	'P', --tipo_paginado
	'0', --mostrar_total_registros
	'1', --eof_invisible
	NULL, --eof_customizado
	'0', --siempre_con_titulo
	'0', --exportar_paginado
	'1', --exportar
	'0', --exportar_rtf
	NULL, --pdf_propiedades
	NULL, --pdf_respetar_paginacion
	NULL, --asociacion_columnas
	NULL, --ev_seleccion
	NULL, --ev_eliminar
	NULL, --dao_nucleo_proyecto
	NULL, --dao_nucleo
	NULL, --dao_metodo
	NULL, --dao_parametros
	NULL, --desplegable
	NULL, --desplegable_activo
	'1', --scroll
	'250px', --scroll_alto
	NULL, --cc_modo
	NULL, --cc_modo_anidado_colap
	NULL, --cc_modo_anidado_totcol
	NULL  --cc_modo_anidado_totcua
);

------------------------------------------------------------
-- apex_objeto_ei_cuadro_columna
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc, usar_vinculo, vinculo_carpeta, vinculo_item, vinculo_popup, vinculo_popup_param, vinculo_target, vinculo_celda, vinculo_servicio, permitir_html, grupo, evento_asociado) VALUES (
	'extension', --objeto_cuadro_proyecto
	'1001000208', --objeto_cuadro
	'1001000513', --objeto_cuadro_col
	'apellido', --clave
	'1', --orden
	'Apellido', --titulo
	'ei-cuadro-col-tit', --estilo_titulo
	'4', --estilo
	NULL, --ancho
	'1', --formateo
	NULL, --vinculo_indice
	NULL, --no_ordenar
	NULL, --mostrar_xls
	NULL, --mostrar_pdf
	NULL, --pdf_propiedades
	NULL, --desabilitado
	NULL, --total
	NULL, --total_cc
	NULL, --usar_vinculo
	NULL, --vinculo_carpeta
	NULL, --vinculo_item
	NULL, --vinculo_popup
	NULL, --vinculo_popup_param
	NULL, --vinculo_target
	NULL, --vinculo_celda
	NULL, --vinculo_servicio
	'0', --permitir_html
	NULL, --grupo
	NULL  --evento_asociado
);
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc, usar_vinculo, vinculo_carpeta, vinculo_item, vinculo_popup, vinculo_popup_param, vinculo_target, vinculo_celda, vinculo_servicio, permitir_html, grupo, evento_asociado) VALUES (
	'extension', --objeto_cuadro_proyecto
	'1001000208', --objeto_cuadro
	'1001000514', --objeto_cuadro_col
	'nombre', --clave
	'2', --orden
	'Nombre', --titulo
	'ei-cuadro-col-tit', --estilo_titulo
	'4', --estilo
	NULL, --ancho
	'1', --formateo
	NULL, --vinculo_indice
	NULL, --no_ordenar
	NULL, --mostrar_xls
	NULL, --mostrar_pdf
	NULL, --pdf_propiedades
	NULL, --desabilitado
	NULL, --total
	NULL, --total_cc
	NULL, --usar_vinculo
	NULL, --vinculo_carpeta
	NULL, --vinculo_item
	NULL, --vinculo_popup
	NULL, --vinculo_popup_param
	NULL, --vinculo_target
	NULL, --vinculo_celda
	NULL, --vinculo_servicio
	'0', --permitir_html
	NULL, --grupo
	NULL  --evento_asociado
);
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc, usar_vinculo, vinculo_carpeta, vinculo_item, vinculo_popup, vinculo_popup_param, vinculo_target, vinculo_celda, vinculo_servicio, permitir_html, grupo, evento_asociado) VALUES (
	'extension', --objeto_cuadro_proyecto
	'1001000208', --objeto_cuadro
	'1001000516', --objeto_cuadro_col
	'tipo_docum', --clave
	'3', --orden
	'Tipo Docum', --titulo
	'ei-cuadro-col-tit', --estilo_titulo
	'4', --estilo
	NULL, --ancho
	'1', --formateo
	NULL, --vinculo_indice
	NULL, --no_ordenar
	NULL, --mostrar_xls
	NULL, --mostrar_pdf
	NULL, --pdf_propiedades
	NULL, --desabilitado
	NULL, --total
	NULL, --total_cc
	NULL, --usar_vinculo
	NULL, --vinculo_carpeta
	NULL, --vinculo_item
	NULL, --vinculo_popup
	NULL, --vinculo_popup_param
	NULL, --vinculo_target
	NULL, --vinculo_celda
	NULL, --vinculo_servicio
	'0', --permitir_html
	NULL, --grupo
	NULL  --evento_asociado
);
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc, usar_vinculo, vinculo_carpeta, vinculo_item, vinculo_popup, vinculo_popup_param, vinculo_target, vinculo_celda, vinculo_servicio, permitir_html, grupo, evento_asociado) VALUES (
	'extension', --objeto_cuadro_proyecto
	'1001000208', --objeto_cuadro
	'1001000517', --objeto_cuadro_col
	'nro_docum', --clave
	'4', --orden
	'Nro Docum', --titulo
	'ei-cuadro-col-tit', --estilo_titulo
	'0', --estilo
	NULL, --ancho
	'7', --formateo
	NULL, --vinculo_indice
	NULL, --no_ordenar
	NULL, --mostrar_xls
	NULL, --mostrar_pdf
	NULL, --pdf_propiedades
	NULL, --desabilitado
	NULL, --total
	NULL, --total_cc
	NULL, --usar_vinculo
	NULL, --vinculo_carpeta
	NULL, --vinculo_item
	NULL, --vinculo_popup
	NULL, --vinculo_popup_param
	NULL, --vinculo_target
	NULL, --vinculo_celda
	NULL, --vinculo_servicio
	'0', --permitir_html
	NULL, --grupo
	NULL  --evento_asociado
);
--- FIN Grupo de desarrollo 1001
