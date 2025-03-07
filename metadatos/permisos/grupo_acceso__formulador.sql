
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	'Formulador de Proyecto', --nombre
	NULL, --nivel_acceso
	NULL, --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'0', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'3856'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'3862'  --item
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 1001
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1001000050'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1001000053'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1001000056'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1001000058'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1001000059'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1001000061'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1001000070'  --item
);
--- FIN Grupo de desarrollo 1001

--- INICIO Grupo de desarrollo 1002
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	NULL, --item_id
	'1002000004'  --item
);
--- FIN Grupo de desarrollo 1002

------------------------------------------------------------
-- apex_grupo_acc_restriccion_funcional
------------------------------------------------------------
INSERT INTO apex_grupo_acc_restriccion_funcional (proyecto, usuario_grupo_acc, restriccion_funcional) VALUES (
	'extension', --proyecto
	'formulador', --usuario_grupo_acc
	'67'  --restriccion_funcional
);
