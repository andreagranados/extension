------------------------------------------------------------
--[1001000192]--  Proyectos Extensi�n - DR 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'extension', --proyecto
	'1001000192', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_relacion', --clase
	'1001000004', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Proyectos Extensi�n - DR', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'extension', --fuente_datos_proyecto
	'extension', --fuente_datos
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
	'2019-09-10 11:34:13', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 1001

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'extension', --proyecto
	'1001000192', --objeto
	'0', --debug
	NULL, --clave
	'2', --ap
	'1001000004', --punto_montaje
	NULL, --ap_clase
	NULL, --ap_archivo
	'0', --sinc_susp_constraints
	'1', --sinc_orden_automatico
	'1'  --sinc_lock_optimista
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000247', --dep_id
	'1001000192', --objeto_consumidor
	'1001000292', --objeto_proveedor
	'alerta', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'27'  --orden
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000045', --dep_id
	'1001000192', --objeto_consumidor
	'1001000222', --objeto_proveedor
	'area', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'23'  --orden
);
--- FIN Grupo de desarrollo 1002

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000244', --dep_id
	'1001000192', --objeto_consumidor
	'1001000289', --objeto_proveedor
	'avance', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'25'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000201', --dep_id
	'1001000192', --objeto_consumidor
	'1001000156', --objeto_proveedor
	'bases_convocatoria', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'15'  --orden
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000044', --dep_id
	'1001000192', --objeto_consumidor
	'1001000221', --objeto_proveedor
	'departamento', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'22'  --orden
);
--- FIN Grupo de desarrollo 1002

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000167', --dep_id
	'1001000192', --objeto_consumidor
	'1001000173', --objeto_proveedor
	'designacion', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'4'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000205', --dep_id
	'1001000192', --objeto_consumidor
	'1001000241', --objeto_proveedor
	'destinatarios', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'17'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000170', --dep_id
	'1001000192', --objeto_consumidor
	'1001000171', --objeto_proveedor
	'docente', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'7'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000202', --dep_id
	'1001000192', --objeto_consumidor
	'1001000239', --objeto_proveedor
	'eje_tematico_conv', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'16'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000206', --dep_id
	'1001000192', --objeto_consumidor
	'1001000217', --objeto_proveedor
	'estado_pe', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'18'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000166', --dep_id
	'1001000192', --objeto_consumidor
	'1001000174', --objeto_proveedor
	'integrante_externo_pe', --identificador
	'0', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'3'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000165', --dep_id
	'1001000192', --objeto_consumidor
	'1001000175', --objeto_proveedor
	'integrante_interno_pe', --identificador
	'0', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'2'  --orden
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000033', --dep_id
	'1001000192', --objeto_consumidor
	'1002000058', --objeto_proveedor
	'localidad', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'8'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000065', --dep_id
	'1001000192', --objeto_consumidor
	'1002000088', --objeto_proveedor
	'logs_pextension', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'26'  --orden
);
--- FIN Grupo de desarrollo 1002

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000213', --dep_id
	'1001000192', --objeto_consumidor
	'1001000246', --objeto_proveedor
	'montos_convocatoria', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'21'  --orden
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000035', --dep_id
	'1001000192', --objeto_consumidor
	'1002000060', --objeto_proveedor
	'objetivo_especifico', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'10'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000029', --dep_id
	'1001000192', --objeto_consumidor
	'1002000054', --objeto_proveedor
	'organizaciones_participantes', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'12'  --orden
);
--- FIN Grupo de desarrollo 1002

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000169', --dep_id
	'1001000192', --objeto_consumidor
	'1001000172', --objeto_proveedor
	'persona', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'6'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000168', --dep_id
	'1001000192', --objeto_consumidor
	'1001000158', --objeto_proveedor
	'pextension', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'5'  --orden
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000034', --dep_id
	'1001000192', --objeto_consumidor
	'1002000059', --objeto_proveedor
	'plan_actividades', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'13'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000020', --dep_id
	'1001000192', --objeto_consumidor
	'1002000045', --objeto_proveedor
	'presupuesto_extension', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'9'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000019', --dep_id
	'1001000192', --objeto_consumidor
	'1002000043', --objeto_proveedor
	'rubro_presup_extension', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'11'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000042', --dep_id
	'1001000192', --objeto_consumidor
	'1002000067', --objeto_proveedor
	'seguimiento_central', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'19'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000043', --dep_id
	'1001000192', --objeto_consumidor
	'1002000068', --objeto_proveedor
	'seguimiento_ua', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'20'  --orden
);
--- FIN Grupo de desarrollo 1002

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000240', --dep_id
	'1001000192', --objeto_consumidor
	'1001000285', --objeto_proveedor
	'solicitud', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'24'  --orden
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1002000030', --dep_id
	'1001000192', --objeto_consumidor
	'1002000055', --objeto_proveedor
	'tipo_organizacion', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'14'  --orden
);
--- FIN Grupo de desarrollo 1002

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'extension', --proyecto
	'1001000155', --dep_id
	'1001000192', --objeto_consumidor
	'1001000161', --objeto_proveedor
	'unidad_acad', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
--- FIN Grupo de desarrollo 1001
