--DROP TABLE ctl_direccionesborradas;
CREATE TABLE ctl_direccionesborradas(
	num_registro	BIGSERIAL,
	clientekeyx		BIGINT,
	direccionpedidokeyx	BIGINT,
	fecha_borrado	TIMESTAMP DEFAULT NOW(),
	PRIMARY KEY (num_registro)
);
--DROP INDEX ctl_direccionesborradas_clientekeyx_direccionpedidokeyx ;
CREATE INDEX ctl_direccionesborradas_clientekeyx_direccionpedidokeyx ON ctl_direccionesborradas (clientekeyx,direccionpedidokeyx);

--DROP TABLE ctl_cotizaciones;
CREATE TABLE ctl_cotizaciones(
	foliopedido 		BIGSERIAL,
	clientekeyx		BIGINT,
	direccionpedidokeyx	BIGINT,
	articulopedidokeyx	BIGINT,
	fechamovimiento		TIMESTAMP DEFAULT NOW(),
	fechaentregapedido	DATE DEFAULT NOW()::DATE,
	fechavueltapedido	DATE DEFAULT NOW()::DATE,
	flag_recogermismodia	INTEGER,
	notahoraentrega		VARCHAR,
	notahorarecoger		VARCHAR,
	estatuspedido		INTEGER,
	empleado			INTEGER,
	garantia 			INTEGER DEFAULT 0,
	manteleria 			VARCHAR DEFAULT '',
	flete 				DECIMAL(18) DEFAULT 0,
	flag_iva 			INTEGER DEFAULT 0,
	articulospendientes VARCHAR DEFAULT '',
	flag_descuento 		INTEGER DEFAULT 0,
	porcentajedescuento INTEGER DEFAULT 0,
	PRIMARY KEY (foliopedido)
);

-- DROP TABLE mae_articuloscotizacion;
CREATE TABLE mae_articuloscotizacion(
	keyx 		BIGSERIAL,
	foliopedido 	BIGINT,
	id_articulo	BIGINT,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta VARCHAR,
	flag_rentado INTEGER DEFAULT 0
);

--DROP INDEX mae_articuloscotizacion_keyx;
CREATE INDEX mae_articuloscotizacion_keyx ON mae_articuloscotizacion(keyx);

--DROP INDEX mae_articuloscotizacion_foliopedido;
CREATE INDEX mae_articuloscotizacion_foliopedido ON mae_articuloscotizacion(foliopedido);

--DROP INDEX mae_articuloscotizacion_id_articulo ON mae_articuloscotizacion(id_articulo);
CREATE INDEX mae_articuloscotizacion_id_articulo ON mae_articuloscotizacion(id_articulo);

-- DROP TABLE mae_articuloscotizacionhist;
CREATE TABLE mae_articuloscotizacionhist(
	keyx 		BIGSERIAL,
	foliopedido 	BIGINT,
	id_articulo	BIGINT,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta VARCHAR,
	flag_rentado INTEGER DEFAULT 0
);


--DROP INDEX mae_articuloscotizacionhist_id_articulo ON mae_articuloscotizacionhist(id_articulo);
CREATE INDEX mae_articuloscotizacionhist_id_articulo ON mae_articuloscotizacionhist(id_articulo);

--DROP INDEX mae_articuloscotizacionhist_keyx;
CREATE INDEX mae_articuloscotizacionhist_keyx ON mae_articuloscotizacionhist(keyx);

--DROP INDEX mae_articuloscotizacionhist_foliopedido;
CREATE INDEX mae_articuloscotizacionhist_foliopedido ON mae_articuloscotizacionhist(foliopedido);

--DROP TABLE cat_estatuscotizacion;
CREATE TABLE cat_estatuscotizacion(
	keyx 		serial,
	descripcion 	VARCHAR,
	PRIMARY KEY (keyx)
);

INSERT INTO cat_estatuscotizacion (keyx,descripcion) SELECT 1,'CAPTURADO';
INSERT INTO cat_estatuscotizacion (keyx,descripcion) SELECT 4,'CONVERTIDO EN FOLIO';
INSERT INTO cat_estatuscotizacion (keyx,descripcion) SELECT 99,'BORRADO';

--DROP TABLE ctl_variables;
CREATE TABLE ctl_variables(
	empresa		INTEGER,
	keyx 		BIGINT,
	valor		INTEGER,
	descripcion	VARCHAR,
	PRIMARY KEY (empresa,keyx)
);

INSERT INTO ctl_variables(empresa,keyx,valor,descripcion)
SELECT 1,1,30,'PORCENTAJE DE DESCUENTO MAXIMO';

INSERT INTO ctl_variables(empresa,keyx,valor,descripcion)
SELECT 1,2,60,'SEGUNDOS SIN ACTIVIDAD PARA UN USUARIO';

--DROP TABLE ctl_descartarborrados;
CREATE TABLE ctl_descartarborrados(
	foliopedido 		BIGINT
	,fechamovimiento	TIMESTAMP DEFAULT NOW()
	,empleado			BIGINT
	,PRIMARY KEY (foliopedido)
);

---ALTERS

ALTER TABLE mae_clientes  DROP CONSTRAINT mae_clientes_pkey;
ALTER TABLE mae_clientes  ADD PRIMARY KEY (keyx,nombres,apellidos,telcasa,telcelular);
ALTER TABLE ctl_pedidos ADD COLUMN garantia INTEGER DEFAULT 0;
ALTER TABLE ctl_abonospagos ADD COLUMN fecha_corte TIMESTAMP DEFAULT '1900-01-01 00:00:00';
ALTER TABLE ctl_abonospagos ADD COLUMN flag_corte INTEGER DEFAULT 0;
ALTER TABLE ctl_abonospagos ADD COLUMN empleado INTEGER DEFAULT 0;
ALTER TABLE ctl_abonospagos ADD COLUMN nom_empleado VARCHAR DEFAULT '';
ALTER TABLE ctl_abonospagos ADD COLUMN recibio VARCHAR DEFAULT '';
ALTER TABLE ctl_pedidos ADD COLUMN manteleria VARCHAR DEFAULT '';
ALTER TABLE ctl_pedidos ADD COLUMN flete DECIMAL(18) DEFAULT 0;
ALTER TABLE ctl_pedidos ADD COLUMN flag_iva INTEGER DEFAULT 0;
ALTER TABLE mae_articulospedidos ADD COLUMN flag_rentado INTEGER DEFAULT 0;
ALTER TABLE mae_articulospedidoshist ADD COLUMN flag_rentado INTEGER DEFAULT 0;
ALTER TABLE cat_direcciones ADD COLUMN keyx BIGSERIAL;
ALTER TABLE ctl_pedidos ADD COLUMN articulospendientes VARCHAR DEFAULT '';
ALTER TABLE ctl_pedidos ADD COLUMN flag_descuento INTEGER DEFAULT 0;
ALTER TABLE ctl_pedidos ADD COLUMN porcentajedescuento INTEGER DEFAULT 0;
ALTER TABLE ctl_pedidos ADD COLUMN flag_descuento INTEGER DEFAULT 0;
ALTER TABLE ctl_pedidos ADD COLUMN porcentajedescuento INTEGER DEFAULT 0;
--SELECT MAX(foliopedido) FROM ctl_pedidos_foliopedido_seq --Resultado ponerle abajo
ALTER SEQUENCE ctl_pedidos_foliopedido_seq RESTART WITH ##;



/*

--DROP TYPES
DROP TYPE if exists typ_pedidosanticiposgarantias;
DROP TYPE if exists typ_ctl_variables;
DROP TYPE if exists typ_abonospagosdetalle;
DROP TYPE if exists typ_pedidospendiente;
DROP TYPE if exists typ_foliosmes;
DROP TYPE if exists typ_pedidospendiente2;
DROP TYPE if exists typ_ctl_pedidos;
DROP TYPE if exists typ_mae_articulospedidos;
DROP TYPE if exists typ_mae_articulospedidos2;
DROP TYPE if exists typ_inventespecial;
DROP TYPE if exists typ_mae_direccionpedidos;
DROP TYPE if exists typ_direcciones;
DROP TYPE if exists typ_cat_regiones;
DROP TYPE if exists typ_cat_grupo;
DROP TYPE if exists typ_ctl_regiones;
DROP TYPE if exists typ_mae_clientes;
DROP TYPE if exists typ_cat_usuarios;
DROP TYPE if exists typ_usuario;
DROP TYPE if exists typ_ctl_abonospagos2;
DROP TYPE if exists typ_inventario;





--DROP FUNCTIONS
DROP FUNCTION if exists fn_pedidosdepositodevueltos_insert(BIGINT,DECIMAL(18),BIGINT);
DROP FUNCTION if exists fn_articuloscotizacion_select(BIGINT);
DROP FUNCTION if exists fn_articulosxmodificacioncotizacion_delete(BIGINT);
DROP FUNCTION if exists fn_cotizacion_delete(BIGINT);
DROP FUNCTION if exists fn_cotizacionarticulos_select(BIGINT);
DROP FUNCTION if exists fn_cotizacion_select();
DROP FUNCTION if exists fn_cotizacion_update(BIGINT,INTEGER);
DROP FUNCTION if exists fn_cotizacionfolio_select();
DROP FUNCTION if exists fn_cotizacion_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER);
DROP FUNCTION if exists fn_cotizacionmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER);
DROP FUNCTION if exists fn_cotizacion_select(BIGINT);
DROP FUNCTION if exists fn_cotizacionpendientes_select(bFolioPedido BIGINT);
DROP FUNCTION if exists fn_pedidosdescartaborrado_insert();
DROP FUNCTION if exists fn_pedidosanticiposgarantias_select();
DROP FUNCTION if exists fn_pedidosanticiposgarantiascorte_insert(BIGINT);
DROP FUNCTION if exists fn_variables_select(BIGINT,INTEGER);
DROP FUNCTION if exists fn_pedidosporempleado_select(INTEGER);
DROP FUNCTION if exists fn_abonospagosdetalle_select(BIGINT);
DROP FUNCTION if exists fn_pedidostodos_select();
DROP FUNCTION if exists fn_user_insert(INTEGER,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION if exists fn_user_update(INTEGER,INTEGER,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION if exists fn_user_delete(VARCHAR);
DROP FUNCTION if exists fn_user_delete(INTEGER);
DROP FUNCTION if exists fn_user_select(INTEGER);
DROP FUNCTION if exists fn_user_select();
DROP FUNCTION if exists fn_user_select(VARCHAR,VARCHAR,INTEGER);
DROP FUNCTION if exists fn_cat_user_select();
DROP FUNCTION if exists fn_ctl_regiones_insert(BIGINT,BIGINT);
DROP FUNCTION if exists fn_ctl_regionunazona_delete(BIGINT);
DROP FUNCTION if exists fn_ctl_regiones_delete(BIGINT);
DROP FUNCTION if exists fn_ctl_regiones_update(BIGINT,BIGINT);
DROP FUNCTION if exists fn_ctl_regiones_update(BIGINT,BIGINT,BIGINT);
DROP FUNCTION if exists fn_ctl_regiones_select();
DROP FUNCTION if exists fn_cat_regiones_insert(VARCHAR,VARCHAR);
DROP FUNCTION if exists fn_cat_regiones_delete(BIGINT);
DROP FUNCTION if exists fn_cat_regiones_update(BIGINT,VARCHAR,VARCHAR);
DROP FUNCTION if exists fn_cat_regiones_select();
DROP FUNCTION if exists fn_cat_regiones_update(BIGINT,VARCHAR);
DROP FUNCTION if exists fn_abonospagos_insert(BIGINT,DECIMAL);
DROP FUNCTION if exists fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR);
DROP FUNCTION if exists fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR,INTEGER);
DROP FUNCTION if exists fn_abonospagos_select(BIGINT);
DROP FUNCTION if exists fn_pedidos_update(BIGINT,BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER);
DROP FUNCTION if exists fn_pedidos_update(BIGINT,INTEGER);
DROP FUNCTION if exists fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER);
DROP FUNCTION if exists fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL);
DROP FUNCTION if exists fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER);
DROP FUNCTION if exists fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER);
DROP FUNCTION if exists fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER);
DROP FUNCTION if exists fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL);
DROP FUNCTION if exists fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER);
DROP FUNCTION if exists fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER);
DROP FUNCTION if exists fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER);
DROP FUNCTION if exists fn_pedidosmodificados_insert(bigint, bigint, bigint, date, date, integer, character varying, character varying, integer, integer, character varying, numeric, integer, integer, integer);
DROP FUNCTION if exists fn_pedidospendientesmes_select();
DROP FUNCTION if exists fn_pedidos_delete(BIGINT);
DROP FUNCTION if exists fn_pedidosarticulospendientes_select(BIGINT);
DROP FUNCTION if exists fn_pedidosabonado_select();
DROP FUNCTION if exists fn_pedidospendientes_select(bFolioPedido BIGINT);
DROP FUNCTION if exists fn_pedidospendientes_select();
DROP FUNCTION if exists fn_pedidos_select(BIGINT);
DROP FUNCTION if exists fn_importepedido_select(BIGINT);
DROP FUNCTION if exists fn_articulospedidos_select(BIGINT);
DROP FUNCTION if exists fn_articulospedidosrentado_insert(BIGINT,BIGINT,INTEGER,VARCHAR,INTEGER);
DROP FUNCTION if exists fn_articulospedidos_insert(BIGINT,BIGINT,INTEGER,VARCHAR);
DROP FUNCTION if exists fn_articulospedidoshist_insert(BIGINT,BIGINT,INTEGER);
DROP FUNCTION if exists fn_articulospedidoshist_insert(BIGINT);
DROP FUNCTION if exists fn_articulosxmodificacion_delete(BIGINT);
DROP FUNCTION if exists fn_unarticulopedidohist_insert(BIGINT,BIGINT,INTEGER);
DROP FUNCTION if exists fn_inventespecial_select(BIGINT);
DROP FUNCTION if exists fn_invent_delete(BIGINT);
DROP FUNCTION if exists fn_invent_update(BIGINT,VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER);
DROP FUNCTION if exists fn_invent_insert(VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER);
DROP FUNCTION if exists fn_invent_select(SMALLINT);
DROP FUNCTION if exists fn_invent_select();
DROP FUNCTION if exists fn_inventrentadopordia_select(BIGINT,INTEGER,DATE,BIGINT);
DROP FUNCTION if exists fn_inventrentadopordia_select(BIGINT,INTEGER,DATE);
DROP FUNCTION if exists fn_inventrentado_select(BIGINT,INTEGER);
DROP FUNCTION if exists fn_invent_select(BIGINT);
DROP FUNCTION if exists fn_invent_select(VARCHAR);
DROP FUNCTION if exists fn_inventespecial_select(BIGINT,DATE);
DROP FUNCTION if exists fn_direccionpedidoscliente_select(BIGINT);
DROP FUNCTION if exists fn_direccionpedidos_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR,INTEGER,VARCHAR,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION if exists fn_direccionpedidos_select(BIGINT);
DROP FUNCTION if exists fn_dir_select(INTEGER,bigint);
DROP FUNCTION if exists fn_dir_select(INTEGER,VARCHAR);
DROP FUNCTION if exists fn_cte_delete(BIGINT);
DROP FUNCTION if exists fn_cte_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION if exists fn_cte_update(BIGINT,VARCHAR,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION if exists fn_cte_select(VARCHAR);
DROP FUNCTION if exists fn_cte_select(BIGINT);
DROP FUNCTION if exists fn_cte_select();
DROP FUNCTION if exists fn_abonospagosresumedetalleempleados_select();
DROP FUNCTION if exists fn_pedidosdepositodevueltos_select();


*/
-- CREATE TYPES
--DROP INDEX ctl_pedidos_flag_corte;
CREATE INDEX ctl_pedidos_flag_corte ON ctl_pedidos (flag_corte);
ALTER TABLE ctl_pedidos ADD COLUMN flag_corte INTEGER DEFAULT 0;
ALTER TABLE ctl_pedidos ADD COLUMN fecha_corte TIMESTAMP DEFAULT '1900-01-01';


ALTER TABLE ctl_cortegarantias ADD COLUMN flag_corte INTEGER DEFAULT 0;
ALTER TABLE ctl_cortegarantias ADD COLUMN fecha_corte TIMESTAMP;

--DROP TYPE typ_inventario;
CREATE TYPE typ_inventario AS (
	id_articulo bigint,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta INTEGER
);

--DROP TYPE typ_pedidosanticiposgarantias;
CREATE TYPE typ_pedidosanticiposgarantias AS (
	monto			DECIMAL,
	empleado		BIGINT,
	nom_empleado	VARCHAR,
	folios			TEXT
);

--DROP TYPE typ_abonospagosdetalle;
CREATE TYPE typ_abonospagosdetalle AS (
	numeroabonos 	BIGINT,
	monto			DECIMAL,
	empleado		BIGINT,
	nom_empleado	VARCHAR,
	folios			TEXT
);

--DROP TYPE typ_ctl_variables;
CREATE TYPE typ_ctl_variables AS(
	empresa		INTEGER,
	keyx 		BIGINT,
	valor		INTEGER,
	descripcion	VARCHAR
);

--DROP TYPE typ_pedidospendiente2;
CREATE TYPE typ_pedidospendiente2 AS(
	foliopedido 		BIGINT,
	region				VARCHAR,
	calle				VARCHAR,
	colonia				VARCHAR,
	codigopostal		VARCHAR,
	numext				VARCHAR,
	numint				VARCHAR,
	ciudad				VARCHAR,
	estado				VARCHAR,
	nombrecte			VARCHAR,
	apellidocte			VARCHAR,
	telefonocasa		VARCHAR,
	telefonocelular		VARCHAR,
	referencias			VARCHAR,
	detallepedido		VARCHAR,
	notahoraentrega		VARCHAR,
	notahorarecoger		VARCHAR,
	abono				DECIMAL,
	total				DECIMAL,
	fechapedido			DATE,
	fechavueltapedido	DATE,
	empleado			VARCHAR,
	estatuspedido		INTEGER,
	flete				DECIMAL,
	manteleria			VARCHAR,
	iva					INTEGER,
	descuento			INTEGER,
	cantidaddescuento	INTEGER,
	garantia			INTEGER
);

--DROP TYPE typ_ctl_pedidos;
CREATE TYPE typ_ctl_pedidos AS(
	foliopedido 		BIGINT,
	clientekeyx		BIGINT,
	direccionpedidokeyx	BIGINT,
	articulopedidokeyx	BIGINT,
	fechamovimiento		TIMESTAMP,
	fechaentregapedido	DATE,
	fechavueltapedido	DATE,
	flag_recogermismodia	INTEGER,
	notahoraentrega		VARCHAR,
	notahorarecoger		VARCHAR,
	estatuspedido		INTEGER,
	empleado			INTEGER,
	flete				DECIMAL(18),
	manteleria			VARCHAR,
	iva					INTEGER,
	descuento			INTEGER,
	cantidaddescuento	INTEGER,
	garantia			INTEGER
);


CREATE TYPE typ_ctl_abonospagos2 AS (
	foliopedido 	BIGINT,
	monto		DECIMAL,
	fechaabono	TIMESTAMP,
	montoantesoperacion	DECIMAL,
	recibio		VARCHAR,
	usuario		VARCHAR
);
CREATE TYPE typ_cat_usuarios AS 
(
	id_puesto INTEGER,
	puesto VARCHAR,
	permisos VARCHAR
);
CREATE TYPE typ_usuario AS (
	id_puesto integer,
	keyx integer,
	usuario VARCHAR,
	pwd VARCHAR,
	nombre VARCHAR,
	permisos VARCHAR,
	descripcionempleado VARCHAR
);
CREATE TYPE typ_mae_clientes AS (
	keyx 		BIGINT,
	nombres		VARCHAR,
	apellidos	VARCHAR,
	telcasa		VARCHAR,
	telcelular	VARCHAR
);
CREATE TYPE typ_cat_regiones AS (
	id_region BIGINT,
	nombreregion VARCHAR,
	descregion 	VARCHAR
);
CREATE TYPE typ_cat_grupo AS (
	id_grupo 	BIGINT,
	nombregrupo VARCHAR,
	descgrupo 	VARCHAR
);
CREATE TYPE typ_ctl_regiones AS (
	keyx BIGINT,
	id_region 	BIGINT,
	keyxdir		BIGINT,
	nombreregion VARCHAR,
	d_codigo	INTEGER,
	d_asenta	VARCHAR,
	d_mnpio		VARCHAR
);
CREATE TYPE typ_direcciones AS (
	keyx 		BIGINT,
	d_codigo 	INTEGER,
	d_asenta 	VARCHAR,
	d_mnpio 	VARCHAR
);
CREATE TYPE typ_mae_direccionpedidos AS (
	keyx 		BIGINT,
	calle		VARCHAR,
	numinterior	VARCHAR,
	numexterior	VARCHAR,
	colonia		VARCHAR,
	codigopostal	INTEGER,
	entrecalles	VARCHAR,
	observaciones	VARCHAR,
	estado		VARCHAR,
	ciudad		VARCHAR
);
CREATE TYPE typ_inventespecial AS (
	id_articulo bigint,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta VARCHAR
);
CREATE TYPE typ_pedidospendiente AS(
	foliopedido 		BIGINT,
	region				VARCHAR,
	calle				VARCHAR,
	colonia				VARCHAR,
	codigopostal		VARCHAR,
	numext				VARCHAR,
	numint				VARCHAR,
	ciudad				VARCHAR,
	estado				VARCHAR,
	nombrecte			VARCHAR,
	telefonocasa		VARCHAR,
	telefonocelular		VARCHAR,
	referencias			VARCHAR,
	detallepedido		VARCHAR,
	notahoraentrega		VARCHAR,
	notahorarecoger		VARCHAR,
	abono				DECIMAL,
	total				DECIMAL,
	fechapedido			DATE,
	fechavueltapedido	DATE,
	empleado			VARCHAR,
	estatuspedido		INTEGER
);
CREATE TYPE typ_foliosmes AS(cantidad INTEGER,fechapedido DATE);

CREATE TYPE typ_mae_articulospedidos AS (
	foliopedido 	BIGINT,
	id_articulo	BIGINT,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta VARCHAR
);
CREATE TYPE typ_mae_articulospedidos2 AS (
	foliopedido 	BIGINT,
	id_articulo	BIGINT,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta VARCHAR,
	flag_rentado INTEGER
);


--CREATE FUNCTIONS

--DROP INDEX ctl_pedidos_foliopedido_fechamovimiento;
CREATE INDEX ctl_pedidos_foliopedido_fechamovimiento ON ctl_pedidos (foliopedido,fechamovimiento);


-- Function: fn_abonospagos_select
CREATE OR REPLACE FUNCTION fn_abonospagos_select(bFolioPedido BIGINT)
  RETURNS SETOF typ_ctl_abonospagos AS
$BODY$
DECLARE
	rDatos typ_ctl_abonospagos;
BEGIN
	FOR rDatos IN 	SELECT foliopedido,SUM(monto),MAX(fechaabono),montoantesoperacion 
			FROM ctl_abonospagos WHERE foliopedido = bFolioPedido 
			GROUP BY foliopedido,montoantesoperacion
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_abonospagos_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_abonospagos_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_abonospagos_select(BIGINT) FROM public;


-- Function: fn_abonospagos_insert
CREATE OR REPLACE FUNCTION fn_abonospagos_insert(bFolioPedido BIGINT,dMonto DECIMAL,vRecibio VARCHAR,iEmpleado INTEGER)
  RETURNS DECIMAL AS
$BODY$
DECLARE
	iReturn 	DECIMAL DEFAULT 0; --DEVUELVE LA FERIA DEL CLIENTE
	dTotal	 	DECIMAL DEFAULT 0;
	dTotalFlete	DECIMAL DEFAULT 0;
	dIVA	 	DECIMAL DEFAULT 0;
	dMontoAbonado 	DECIMAL DEFAULT 0;
	dDescto		 	DECIMAL DEFAULT 0;
	dCantidadDescto	DECIMAL DEFAULT 0;
	dGarantia		DECIMAL DEFAULT 0;
	vNomEmpleado	VARCHAR DEFAULT '';
	dFechaPedido 	DATE DEFAULT '1900-01-01';
BEGIN
	SELECT COALESCE(SUM(flete),0),flag_iva,flag_descuento,porcentajedescuento,garantia,fechaentregapedido INTO dTotalFlete,dIVA,dDescto,dCantidadDescto,dGarantia,dFechaPedido 
	FROM ctl_pedidos WHERE foliopedido = bFolioPedido GROUP BY flag_iva,flag_descuento,porcentajedescuento,garantia,fechaentregapedido;
	
	SELECT COALESCE(SUM(precio),0)+ dTotal INTO dTotal FROM mae_articulospedidos WHERE foliopedido = bFolioPedido;
	SELECT COALESCE(SUM(precio),0)+ dTotal INTO dTotal FROM mae_articulospedidoshist WHERE foliopedido = bFolioPedido;
	SELECT COALESCE(SUM(monto),0)+ dMonto INTO dMontoAbonado FROM ctl_abonospagos WHERE foliopedido = bFolioPedido;
	
	IF (dCantidadDescto > 0) THEN
		dTotal = ((dTotal * (100 - dCantidadDescto))/100)::DECIMAL(18);
	END IF;
	
	dTotal = (dTotal)::DECIMAL(18) + dTotalFlete::DECIMAL(18);
	
	IF (dIVA = 1) THEN
		dTotal = (dTotal * 1.16)::DECIMAL(18);
	ELSE
		dTotal = (dTotal)::DECIMAL(18);
	END IF;
	
	IF (dMontoAbonado > dTotal) THEN
		iReturn = dMontoAbonado - dTotal;
		dMonto = dMonto - iReturn;
	END IF;
	
	SELECT UPPER(nombre) INTO vNomEmpleado FROM ctl_usuarios WHERE keyx = iEmpleado;
	IF (vNomEmpleado = '') THEN
		vNomEmpleado = 'NO EXISTE EL EMPLEADO';
	END IF;

	IF (dMonto > 0) THEN 
		INSERT INTO ctl_abonospagos(foliopedido,monto,fechaabono,montoantesoperacion,recibio,empleado,nom_empleado)
		SELECT bFolioPedido,dMonto,NOW(),dTotal,UPPER(vRecibio),iEmpleado,vNomEmpleado;
	END IF;
	
	IF (dGarantia > 0 AND NOT EXISTS (SELECT 1 FROM ctl_cortegarantias WHERE foliopedido = bFolioPedido)) THEN
		PERFORM fn_pedidos_update(bFolioPedido,3);
	ELSEIF (SELECT COUNT(1) FROM ctl_pedidos WHERE foliopedido = bFolioPedido AND articulospendientes !='') > 0 THEN
		PERFORM fn_pedidos_update(bFolioPedido,3);
	ELSEIF (SELECT COUNT(1) FROM mae_articulospedidos WHERE foliopedido = bFolioPedido) > 0 THEN
		PERFORM fn_pedidos_update(bFolioPedido,3);
	ELSEIF (dMontoAbonado >= dTotal AND dFechaPedido <= NOW()::DATE) THEN
		PERFORM fn_pedidos_update(bFolioPedido,4);
	ELSE
		PERFORM fn_pedidos_update(bFolioPedido,3);
	END IF;

	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR,INTEGER) FROM public;



-- Function: fn_pedidos_update
CREATE OR REPLACE FUNCTION fn_pedidos_update(	bFolioPedido BIGINT,iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT,iArticulopedidokeyx BIGINT,
						tFechaentregapedido DATE,tFechavueltapedido DATE,iFlag_recogermismodia INTEGER,
						vNotahoraentrega VARCHAR,vNotahorarecoger VARCHAR,iEstatuspedido INTEGER,iEmpleado INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn INTEGER DEFAULT 0;
BEGIN
	UPDATE ctl_pedidos SET clientekeyx = iClientekeyx, direccionpedidokeyx = iDireccionpedidokeyx, articulopedidokeyx = iArticulopedidokeyx,
	fechaentregapedido = tFechaentregapedido, fechavueltapedido = tFechavueltapedido,flag_recogermismodia = iFlag_recogermismodia, 
	notahoraentrega = vNotahoraentrega,notahorarecoger = vNotahorarecoger,estatuspedido = iEstatuspedido, empleado = iEmpleado
	WHERE foliopedido = bFolioPedido;
	IF FOUND THEN
		iReturn = 1;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidos_update(BIGINT,BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidos_update(BIGINT,BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidos_update(BIGINT,BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER) FROM public;



-- Function: fn_pedidos_update
CREATE OR REPLACE FUNCTION fn_pedidos_update(bFolioPedido BIGINT,iEstatuspedido INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn INTEGER DEFAULT 0;
BEGIN
	UPDATE ctl_pedidos SET estatuspedido = iEstatuspedido
	WHERE foliopedido = bFolioPedido;
	IF FOUND THEN
		iReturn = 1;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidos_update(BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidos_update(BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidos_update(BIGINT,INTEGER) FROM public;


CREATE OR REPLACE FUNCTION fn_pedidospendientesmes_select()
  RETURNS SETOF typ_foliosmes AS
$BODY$
DECLARE
	rDatos typ_foliosmes;
BEGIN
	FOR rDatos IN 	SELECT COUNT(*),fechaentregapedido FROM ctl_pedidos 
					WHERE estatuspedido IN(1,2,3)
					GROUP BY fechaentregapedido
					ORDER BY fechaentregapedido
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidospendientesmes_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidospendientesmes_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidospendientesmes_select() FROM public;


-- Function: fn_pedidos_delete
CREATE OR REPLACE FUNCTION fn_pedidos_delete(bFolioPedido BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn INTEGER DEFAULT 0;
BEGIN
	IF (SELECT fn_pedidos_update(bFolioPedido,99))> 0 THEN
		INSERT INTO mae_articulospedidoshist(foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado)
		SELECT foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado 
		FROM mae_articulospedidos WHERE foliopedido = bFolioPedido;
		iReturn = 1;
		IF FOUND THEN
			DELETE FROM mae_articulospedidos WHERE foliopedido = bFolioPedido;
		END IF;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidos_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidos_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidos_delete(BIGINT) FROM public;


CREATE OR REPLACE FUNCTION fn_pedidosarticulospendientes_select(bFolioPedido BIGINT)
  RETURNS SETOF typ_mae_articulospedidos AS
$BODY$
DECLARE
	rDatos typ_mae_articulospedidos;
BEGIN

	FOR rDatos IN  	SELECT foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM mae_articulospedidos WHERE foliopedido = bFolioPedido
					UNION ALL
					SELECT foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM mae_articulospedidoshist WHERE foliopedido = bFolioPedido
	LOOP
			RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosarticulospendientes_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosarticulospendientes_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosarticulospendientes_select(BIGINT) FROM public;


-- Function: fn_articulospedidos_select
CREATE OR REPLACE FUNCTION fn_articulospedidos_select(iFolioPedido BIGINT)
  RETURNS SETOF typ_mae_articulospedidos AS
$BODY$
DECLARE
	rDatos typ_mae_articulospedidos;
BEGIN
	FOR rDatos IN  	SELECT foliopedido,id_articulo,descripcion,SUM(cantidad),SUM(precio)::DECIMAL(18),flag_especial,horasrenta
			FROM mae_articulospedidos  WHERE foliopedido = iFolioPedido GROUP BY foliopedido,id_articulo,descripcion,flag_especial,horasrenta
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articulospedidos_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articulospedidos_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_articulospedidos_select(BIGINT) FROM public;

-- Function: fn_importepedido_select
CREATE OR REPLACE FUNCTION fn_importepedido_select(iFolioPedido BIGINT)
  RETURNS DECIMAL AS
$BODY$
DECLARE
	dTotalPedido DECIMAL DEFAULT 0;
BEGIN
	SELECT SUM(totalpedido) INTO dTotalPedido FROM 
	(SELECT COALESCE(SUM(precio),0)AS totalpedido FROM mae_articulospedidos WHERE foliopedido = iFolioPedido
	UNION ALL
	SELECT COALESCE(SUM(precio),0) AS totalpedido FROM mae_articulospedidoshist WHERE foliopedido = iFolioPedido) AS tb2;
	
	RETURN dTotalPedido;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_importepedido_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_importepedido_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_importepedido_select(BIGINT) FROM public;


-- Function: fn_articulospedidosrentado_insert
CREATE OR REPLACE FUNCTION fn_articulospedidosrentado_insert(iFolioPedido BIGINT,iId_articulo BIGINT,iCantidad INTEGER,vHorarioRenta VARCHAR,vFlagRentado INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 				INTEGER DEFAULT 0;
	iArticulosRentados		INTEGER DEFAULT 0;
	iArticulosDisponibles	INTEGER DEFAULT 0;
	dFechaEntregaPedido 	DATE DEFAULT '1900-01-01';
	iSecuencia 				INTEGER DEFAULT 0;
BEGIN 
	-- obtengo la fecha del pedido.
	SELECT fechaentregapedido::DATE INTO dFechaEntregaPedido FROM ctl_pedidos WHERE foliopedido = iFolioPedido;
	
	--obtengo los articulos rentados para la fecha del pedido.
	SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
	WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido::DATE = dFechaEntregaPedido::DATE) 
	AND id_articulo = iId_articulo
	AND flag_rentado = vFlagRentado::INTEGER;
	
	-- Articulos disponibles de inventario
	SELECT COALESCE(cantidad,0) INTO iArticulosDisponibles FROM ctl_inventario WHERE id_articulo = iId_articulo;
	
	IF (iArticulosDisponibles >= (iCantidad+ iArticulosRentados) OR EXISTS(SELECT 1 FROM ctl_inventario WHERE id_articulo = iId_articulo AND flag_especial = 1)) THEN
		
		INSERT INTO mae_articulospedidos (foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado)
		SELECT iFoliopedido,id_articulo,descripcion,iCantidad,precio * iCantidad,flag_especial,vHorarioRenta,vFlagRentado
		FROM ctl_inventario WHERE id_articulo = iId_articulo;
		
		IF NOT FOUND THEN
			iRetorno = 0;
		ELSE
			SELECT COALESCE(MAX(secuenciamodificacion),0)::INTEGER INTO iSecuencia FROM track_ctl_pedidos WHERE foliopedido = iFoliopedido;
			
			iSecuencia = COALESCE(MAX(iSecuencia),0)::INTEGER + 1;
			
			INSERT INTO track_mae_articulospedidos (foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado,secuenciamodificacion)
			SELECT iFoliopedido,id_articulo,descripcion,iCantidad,precio * iCantidad,flag_especial,vHorarioRenta,vFlagRentado,iSecuencia
			FROM ctl_inventario WHERE id_articulo = iId_articulo;
		END IF;
	END IF;
	
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articulospedidosrentado_insert(BIGINT,BIGINT,INTEGER,VARCHAR,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articulospedidosrentado_insert(BIGINT,BIGINT,INTEGER,VARCHAR,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_articulospedidosrentado_insert(BIGINT,BIGINT,INTEGER,VARCHAR,INTEGER) FROM public;

-- Function: fn_articulospedidos_insert
CREATE OR REPLACE FUNCTION fn_articulospedidos_insert(iFolioPedido BIGINT,iId_articulo BIGINT,iCantidad INTEGER,vHorarioRenta VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
	iArticulosDisponibles 	INTEGER DEFAULT 0;
	iArticulosRentados 	INTEGER DEFAULT 0;
	iSecuencia INTEGER DEFAULT 0;
BEGIN 
	
	iRetorno = iFolioPedido;
	
	--obtengo los articulos rentados
	SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
	WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido::DATE = NOW()::DATE) 
	AND id_articulo = iId_articulo
	AND flag_rentado = 0::INTEGER;
	
	-- Articulos disponibles de inventario
	SELECT COALESCE(cantidad,0) INTO iArticulosDisponibles FROM ctl_inventario WHERE id_articulo = iId_articulo;
	
	IF (iArticulosDisponibles >= (iCantidad+ iArticulosRentados)) THEN
		
		INSERT INTO mae_articulospedidos (foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado)
		SELECT iFoliopedido,id_articulo,descripcion,iCantidad,precio * iCantidad,flag_especial,vHorarioRenta,0
		FROM ctl_inventario WHERE id_articulo = iId_articulo;
		
		IF NOT FOUND THEN
			iRetorno = 0;
		ELSE
			SELECT COALESCE(MAX(secuenciamodificacion),0)::INTEGER INTO iSecuencia FROM track_ctl_pedidos WHERE foliopedido = iFoliopedido;
			
			iSecuencia = COALESCE(MAX(iSecuencia),0)::INTEGER + 1;
			
			INSERT INTO track_mae_articulospedidos (foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado,secuenciamodificacion)
			SELECT iFoliopedido,id_articulo,descripcion,iCantidad,precio * iCantidad,flag_especial,vHorarioRenta,vFlagRentado,iSecuencia
			FROM ctl_inventario WHERE id_articulo = iId_articulo;
		END IF;
	END IF;

	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articulospedidos_insert(BIGINT,BIGINT,INTEGER,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articulospedidos_insert(BIGINT,BIGINT,INTEGER,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_articulospedidos_insert(BIGINT,BIGINT,INTEGER,VARCHAR) FROM public;

-- Function: fn_articulospedidoshist_insert
CREATE OR REPLACE FUNCTION fn_articulospedidoshist_insert(iFolioPedido BIGINT,iId_articulo BIGINT,iCantidad INTEGER)
  RETURNS SETOF typ_mae_articulospedidos2 AS
$BODY$
DECLARE
	rDatos 	typ_mae_articulospedidos2;
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,id_articulo,descripcion,CASE WHEN iCantidad <= SUM(cantidad) THEN iCantidad ELSE SUM(cantidad)END
				,SUM(precio),flag_especial,horasrenta,flag_rentado,flag_rentado
			FROM mae_articulospedidos  WHERE foliopedido = iFolioPedido AND id_articulo = iId_articulo
			GROUP BY foliopedido,id_articulo,descripcion,flag_especial,horasrenta,flag_rentado,flag_rentado
	LOOP
		INSERT INTO mae_articulospedidoshist(foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta)
		SELECT rDatos.foliopedido,rDatos.id_articulo,rDatos.descripcion,rDatos.cantidad,rDatos.precio,rDatos.flag_especial,rDatos.horasrenta;

		IF FOUND THEN
			DELETE FROM mae_articulospedidos WHERE foliopedido = iFolioPedido AND id_articulo = rDatos.id_articulo;
			PERFORM fn_pedidos_update(iFolioPedido,3);
		END IF;		
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articulospedidoshist_insert(BIGINT,BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articulospedidoshist_insert(BIGINT,BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_articulospedidoshist_insert(BIGINT,BIGINT,INTEGER) FROM public;



-- Function: fn_articulosxmodificacion_delete
CREATE OR REPLACE FUNCTION fn_articulosxmodificacion_delete(iFolioPedido BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 1;
BEGIN
	DELETE FROM mae_articulospedidos WHERE foliopedido = iFolioPedido;
		IF FOUND THEN
			DELETE FROM mae_articulospedidoshist WHERE foliopedido = iFolioPedido;
			iRetorno = 1;
		END IF;		
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articulosxmodificacion_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articulosxmodificacion_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_articulosxmodificacion_delete(BIGINT) FROM public;

-- Function: fn_invent_select
CREATE OR REPLACE FUNCTION fn_invent_select(vDescripcion VARCHAR)
  RETURNS SETOF typ_inventario AS
$BODY$
DECLARE
	rDatos typ_inventario;
BEGIN
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM ctl_inventario WHERE descripcion like vDescripcion ||'%'
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_invent_select(VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_invent_select(VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_invent_select(VARCHAR) FROM public;


-- Function: fn_invent_select
CREATE OR REPLACE FUNCTION fn_invent_select(bId_Articulo BIGINT)
  RETURNS SETOF typ_inventario AS
$BODY$
DECLARE
	rDatos typ_inventario;
BEGIN
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM ctl_inventario WHERE id_articulo = bId_Articulo
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_invent_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_invent_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_invent_select(BIGINT) FROM public;


--//Articulos rentados 
-- Function: fn_inventrentado_select
CREATE OR REPLACE FUNCTION fn_inventrentado_select(bId_Articulo BIGINT,vFlagRentado INTEGER)
  RETURNS SETOF typ_inventario AS
$BODY$
DECLARE
	rDatos typ_inventario;
	iArticulosRentados		INTEGER DEFAULT 0;
BEGIN
	SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
	WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido::DATE = NOW()::DATE) 
	AND id_articulo = bId_Articulo
	AND flag_rentado = vFlagRentado::INTEGER;
	
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM ctl_inventario WHERE id_articulo = bId_Articulo
	LOOP	
		rDatos.cantidad = rDatos.cantidad - iArticulosRentados;
		
		IF (rDatos.cantidad <= 0) THEN
			rDatos.cantidad = 0;
		END IF;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_inventrentado_select(BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_inventrentado_select(BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_inventrentado_select(BIGINT,INTEGER) FROM public;



--//Articulos rentados 
-- Function: fn_inventrentado_select
CREATE OR REPLACE FUNCTION fn_inventrentadopordia_select(bId_Articulo BIGINT,vFlagRentado INTEGER,vDate DATE)
  RETURNS SETOF typ_inventario AS
$BODY$
DECLARE
	rDatos typ_inventario;
	iArticulosRentados		INTEGER DEFAULT 0;
BEGIN
	SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
	WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido::DATE = vDate::DATE) 
	AND id_articulo = bId_Articulo
	AND flag_rentado = vFlagRentado::INTEGER;
	
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM ctl_inventario WHERE id_articulo = bId_Articulo
	LOOP	
		rDatos.cantidad = rDatos.cantidad - iArticulosRentados;
		
		IF (rDatos.cantidad <= 0) THEN
			rDatos.cantidad = 0;
		END IF;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_inventrentadopordia_select(BIGINT,INTEGER,DATE)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_inventrentadopordia_select(BIGINT,INTEGER,DATE) TO postgres;
REVOKE ALL ON FUNCTION fn_inventrentadopordia_select(BIGINT,INTEGER,DATE) FROM public;

--//Articulos rentados 
-- Function: fn_inventrentado_select
CREATE OR REPLACE FUNCTION fn_inventrentadopordia_select(bId_Articulo BIGINT,vFlagRentado INTEGER,vDate DATE,vFolio BIGINT)
  RETURNS SETOF typ_inventario AS
$BODY$
DECLARE
	rDatos typ_inventario;
	iArticulosRentados		INTEGER DEFAULT 0;
BEGIN
	SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
	WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE foliopedido != vFolio AND fechaentregapedido::DATE = vDate::DATE) 
	AND id_articulo = bId_Articulo
	AND flag_rentado = vFlagRentado::INTEGER;
	
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM ctl_inventario WHERE id_articulo = bId_Articulo
	LOOP	
		rDatos.cantidad = rDatos.cantidad - iArticulosRentados;
		
		IF (rDatos.cantidad <= 0) THEN
			rDatos.cantidad = 0;
		END IF;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_inventrentadopordia_select(BIGINT,INTEGER,DATE,BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_inventrentadopordia_select(BIGINT,INTEGER,DATE,BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_inventrentadopordia_select(BIGINT,INTEGER,DATE,BIGINT) FROM public;


-- Function: fn_inventespecial_select
CREATE OR REPLACE FUNCTION fn_inventespecial_select(bId_Articulo BIGINT)
  RETURNS SETOF typ_inventespecial AS
$BODY$
DECLARE
	rDatos typ_inventespecial;
BEGIN
	FOR rDatos IN 	SELECT inv.id_articulo,inv.descripcion,inv.cantidad,inv.precio,inv.flag_especial,('folio: '|| mae.foliopedido||', '|| mae.horasrenta ||', fecha: ' || ped.fechaentregapedido) AS horasrentadas 
					FROM ctl_inventario AS inv
					INNER JOIN mae_articulospedidos AS mae ON (inv.id_articulo = mae.id_articulo)
					INNER JOIN ctl_pedidos AS ped ON (mae.foliopedido = ped.foliopedido)
					WHERE inv.id_articulo = bId_Articulo
					ORDER BY ped.fechaentregapedido
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_inventespecial_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_inventespecial_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_inventespecial_select(BIGINT) FROM public;


-- Function: fn_invent_insert
CREATE OR REPLACE FUNCTION fn_invent_insert(vDescripcion VARCHAR,iCantidad INTEGER,dPrecio DECIMAL,iFlag_especial INTEGER,iHorasrenta INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn 	INTEGER DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT * FROM ctl_inventario WHERE descripcion = vDescripcion) THEN	
		INSERT INTO ctl_inventario (descripcion,cantidad,precio,flag_especial,horasrenta)
		SELECT vDescripcion,iCantidad,dPrecio,iFlag_especial,iHorasrenta;

		IF FOUND THEN 
			iReturn = 1;
		END IF;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_invent_insert(VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_invent_insert(VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_invent_insert(VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER) FROM public;


-- Function: fn_invent_update
CREATE OR REPLACE FUNCTION fn_invent_update(iId_articulo BIGINT,vDescripcion VARCHAR,iCantidad INTEGER,dPrecio DECIMAL,iFlag_especial INTEGER,iHorasrenta INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn 	INTEGER DEFAULT 0;
BEGIN
	IF EXISTS (SELECT * FROM ctl_inventario WHERE id_articulo = iId_articulo) THEN	
		UPDATE ctl_inventario SET descripcion = vDescripcion,cantidad = iCantidad,precio = dPrecio,flag_especial = iFlag_especial,horasrenta = iHorasrenta
		WHERE id_articulo = iId_articulo;

		IF FOUND THEN 
			iReturn = 1;
		END IF;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_invent_update(BIGINT,VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_invent_update(BIGINT,VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_invent_update(BIGINT,VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER) FROM public;


-- Function: fn_invent_delete
CREATE OR REPLACE FUNCTION fn_invent_delete(iId_articulo BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn 	INTEGER DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT 1 FROM mae_articulospedidos 
	WHERE foliopedido IN ( SELECT foliopedido FROM ctl_pedidos WHERE estatuspedido IN (0,1,2,3) AND fechaentregapedido::DATE >= NOW()::DATE )
	AND id_articulo = iId_articulo) THEN

		DELETE FROM ctl_inventario WHERE id_articulo = iId_articulo;

		IF FOUND THEN 
			iReturn = 1;
		END IF;
	ELSE
		iReturn = 2;
	END IF;	
	
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_invent_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_invent_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_invent_delete(BIGINT) FROM public;

-- Function: fn_direccionpedidos_select
CREATE OR REPLACE FUNCTION fn_direccionpedidos_select(bKeyx BIGINT)
  RETURNS SETOF typ_mae_direccionpedidos AS
$BODY$
DECLARE
	rDatos typ_mae_direccionpedidos;
BEGIN
	FOR rDatos IN  	SELECT keyx,calle,numinterior,numexterior,colonia,codigopostal,entrecalles,observaciones,estado,ciudad 
			FROM mae_direccionpedidos  WHERE keyx = bKeyx
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_direccionpedidos_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_direccionpedidos_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_direccionpedidos_select(BIGINT) FROM public;


-- Function: fn_direccionpedidos_insert
CREATE OR REPLACE FUNCTION fn_direccionpedidos_insert(vCalle VARCHAR,vInterior VARCHAR,vExterior VARCHAR,vColonia VARCHAR,iCodigoPostal INTEGER,vEntreCalles VARCHAR,vObservaciones VARCHAR,vEstado VARCHAR,vCiudad VARCHAR)
  RETURNS BIGINT AS
$BODY$
DECLARE
	iReturn BIGINT DEFAULT 0;
	iKeyxCatDir BIGINT DEFAULT 0;
	iColonia BIGINT DEFAULT 0;
BEGIN
	vCalle = UPPER(vCalle); 
	vInterior = UPPER(vInterior); 
	vExterior = UPPER(vExterior); 
	vColonia = INITCAP(vColonia); 
	vEntreCalles = UPPER(vEntreCalles); 
	vObservaciones = UPPER(vObservaciones); 
	vEstado = UPPER(vEstado); 
	vCiudad = UPPER(vCiudad); 
	--iColonia = REGEXP_REPLACE(SPLIT_PART(vColonia::VARCHAR||' - x','-',1),'[^0-9]*','0');
	iColonia = SPLIT_PART(vColonia::VARCHAR||' - x','-',1);
	
	IF NOT EXISTS (SELECT 1 FROM cat_direcciones WHERE keyx  = iColonia) THEN
		SELECT NEXTVAL('cat_direcciones_keyx_seq') AS retorno INTO iKeyxCatDir;
		
		vColonia = SPLIT_PART(vColonia::VARCHAR||' - x','-',2);
		--SELECT last_value  INTO iKeyxCatDir FROM cat_direcciones_keyx_seq; 
		
		INSERT INTO cat_direcciones(d_codigo,d_asenta,d_tipo_asenta,d_mnpio,d_estado,d_ciudad,d_cp,c_estado,c_oficina,c_tipo_asenta,c_mnpio,id_asenta_cpcons,d_zona,c_cve_ciudad,c_cp,keyx)
		SELECT iCodigoPostal,vColonia,'AGREGADA POR SISTEMA','NO ESPECIFICADO','SINALOA','NO ESPECIFICADO',0,25,0,0,0,0,'POR SISTEMA','02','',iKeyxCatDir;
		
		vColonia = iKeyxCatDir || ' - ' || vColonia || ' - ' || vCiudad;
	END IF;
	
	SELECT MAX(keyx) INTO iReturn FROM mae_direccionpedidos WHERE calle = vCalle AND numinterior = vInterior AND numexterior = vExterior
			AND colonia = vColonia AND codigopostal = iCodigoPostal AND estado = vEstado AND ciudad = vCiudad
			AND entrecalles = vEntreCalles AND observaciones = vObservaciones;
	
	IF (iReturn IS NULL) THEN
		INSERT INTO mae_direccionpedidos (calle,numinterior,numexterior,colonia,codigopostal,entrecalles,observaciones,estado,ciudad)
		SELECT vCalle,vInterior,vExterior,vColonia,iCodigoPostal,vEntreCalles,vObservaciones,vEstado,vCiudad;

		IF FOUND THEN
			 SELECT (CASE WHEN Last_value = 1 THEN (SELECT COUNT (1) FROM mae_direccionpedidos) ELSE Last_value END)::BIGINT INTO iReturn FROM  mae_direccionpedidos_keyx_seq;
		END IF;
	ELSE
		UPDATE mae_direccionpedidos SET observaciones = vObservaciones WHERE keyx = iReturn;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_direccionpedidos_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR,INTEGER,VARCHAR,VARCHAR,VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_direccionpedidos_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR,INTEGER,VARCHAR,VARCHAR,VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_direccionpedidos_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR,INTEGER,VARCHAR,VARCHAR,VARCHAR,VARCHAR) FROM public;


-- Function: fn_direccionpedidoscliente_select
CREATE OR REPLACE FUNCTION fn_direccionpedidoscliente_select(iCliente BIGINT)
  RETURNS SETOF typ_mae_direccionpedidos AS
$BODY$
DECLARE
	rDatos typ_mae_direccionpedidos;
	bKeyx 	BIGINT DEFAULT 0;
	bCount 	BIGINT DEFAULT 0;
BEGIN
	FOR bKeyx,bCount IN SELECT direccionpedidokeyx,COUNT(1) AS NumeroDomicilios FROM fn_pedidos_select(iCliente::BIGINT) GROUP BY direccionpedidokeyx ORDER BY NumeroDomicilios DESC
	LOOP
		SELECT keyx,calle,numinterior,numexterior,colonia,codigopostal,entrecalles,observaciones,estado,ciudad 
		INTO rDatos.keyx,rDatos.calle,rDatos.numinterior,rDatos.numexterior,rDatos.colonia,rDatos.codigopostal,rDatos.entrecalles,rDatos.observaciones,rDatos.estado,rDatos.ciudad 
		FROM mae_direccionpedidos  WHERE keyx = bKeyx;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_direccionpedidoscliente_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_direccionpedidoscliente_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_direccionpedidoscliente_select(BIGINT) FROM public;

-- Function: fn_dir_select
CREATE OR REPLACE FUNCTION fn_dir_select(iCodigo INTEGER,vColonia VARCHAR)
  RETURNS SETOF typ_direcciones AS
$BODY$
DECLARE
	rDatos typ_direcciones;
	tSql  	TEXT;
BEGIN
	vColonia = UPPER(vColonia);
	tSql = 'SELECT keyx,d_codigo,INITCAP(d_asenta),INITCAP(d_mnpio) FROM cat_direcciones ';
	IF iCodigo != 0 AND  vColonia != '' THEN
		tSql = tSql || 'WHERE d_codigo = '|| iCodigo ||' AND UPPER(d_asenta) LIKE ''' ||vColonia || '%''';
	ELSIF iCodigo != 0 THEN
		tSql =  tSql || 'WHERE d_codigo = '|| iCodigo;
	ELSIF vColonia != '' THEN
		tSql = tSql || 'WHERE UPPER(d_asenta) LIKE ''' ||vColonia || '%''';
	END IF;
	
	FOR rDatos IN  EXECUTE tSql
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_dir_select(INTEGER,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_dir_select(INTEGER,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_dir_select(INTEGER,VARCHAR) FROM public;

-- Function: fn_dir_select
CREATE OR REPLACE FUNCTION fn_dir_select(iCodigo INTEGER,iKeyx bigint)
  RETURNS SETOF typ_direcciones AS
$BODY$
DECLARE
	rDatos typ_direcciones;
BEGIN	
	FOR rDatos IN  SELECT keyx,d_codigo,INITCAP(d_asenta),INITCAP(d_mnpio) FROM cat_direcciones WHERE (d_codigo = iCodigo OR keyx = iKeyx) 
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_dir_select(INTEGER,bigint)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_dir_select(INTEGER,bigint) TO postgres;
REVOKE ALL ON FUNCTION fn_dir_select(INTEGER,bigint) FROM public;

-- Function: fn_cat_regiones_select
CREATE OR REPLACE FUNCTION fn_cat_regiones_select()
  RETURNS SETOF typ_cat_regiones AS
$BODY$
DECLARE
	rDatos typ_cat_regiones;
BEGIN
	FOR rDatos IN SELECT id_region,nombreregion,descregion FROM cat_regiones ORDER BY id_region
	LOOP 
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_regiones_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_regiones_select() TO postgres;
REVOKE ALL ON FUNCTION fn_cat_regiones_select() FROM public;

-- Function: fn_cat_regiones_update
CREATE OR REPLACE FUNCTION fn_cat_regiones_update(iRegion BIGINT,vNombre VARCHAR, vDescRegion VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	UPDATE cat_regiones SET nombreregion = vNombre, descregion = vDescRegion WHERE id_region = iRegion;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_regiones_update(BIGINT,VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_regiones_update(BIGINT,VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_cat_regiones_update(BIGINT,VARCHAR,VARCHAR) FROM public;


-- Function: fn_cat_regiones_delete
CREATE OR REPLACE FUNCTION fn_cat_regiones_delete(iRegion BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	DELETE FROM cat_regiones WHERE id_region = iRegion;
	IF FOUND THEN
		iRetorno = 1;
		PERFORM fn_ctl_regionunazona_delete(iRegion);
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_regiones_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_regiones_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_cat_regiones_delete(BIGINT) FROM public;


-- Function: fn_cat_regiones_insert
CREATE OR REPLACE FUNCTION fn_cat_regiones_insert(vNombre VARCHAR,vDesc VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT 1 FROM cat_regiones WHERE nombreregion = vNombre ) THEN
		INSERT INTO cat_regiones (nombreregion,descregion) SELECT vNombre,vDesc;
		IF FOUND THEN
			iRetorno = 1;
		END IF;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_regiones_insert(VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_regiones_insert(VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_cat_regiones_insert(VARCHAR,VARCHAR) FROM public;


-- Function: fn_ctl_regiones_select
CREATE OR REPLACE FUNCTION fn_ctl_regiones_select()
  RETURNS SETOF typ_ctl_regiones AS
$BODY$
DECLARE
	rDatos typ_ctl_regiones;
BEGIN
	FOR rDatos IN 	SELECT ctlreg.keyx,ctlreg.id_region,ctlreg.keyxdir,reg.nombreregion,dir.d_codigo,dir.d_asenta,dir.d_mnpio FROM ctl_regiones AS ctlreg
					INNER JOIN cat_regiones AS reg ON (ctlreg.id_region = reg.id_region)
					INNER JOIN cat_direcciones AS dir ON (ctlreg.keyxdir = dir.keyx)
					ORDER BY ctlreg.keyx,dir.d_codigo
	LOOP 
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_ctl_regiones_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_ctl_regiones_select() TO postgres;
REVOKE ALL ON FUNCTION fn_ctl_regiones_select() FROM public;


-- Function: fn_ctl_regiones_update

CREATE OR REPLACE FUNCTION fn_ctl_regiones_update(iKeyx BIGINT,iRegion BIGINT,iKeyxDir BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	UPDATE ctl_regiones SET id_region = iRegion,keyxdir = iKeyxDir WHERE keyx = iKeyx;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_ctl_regiones_update(BIGINT,BIGINT,BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_ctl_regiones_update(BIGINT,BIGINT,BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_ctl_regiones_update(BIGINT,BIGINT,BIGINT) FROM public;


-- Function: fn_ctl_regiones_update

CREATE OR REPLACE FUNCTION fn_ctl_regiones_update(iKeyx BIGINT,iRegion BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	UPDATE ctl_regiones SET id_region = iRegion WHERE keyx = iKeyx;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_ctl_regiones_update(BIGINT,BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_ctl_regiones_update(BIGINT,BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_ctl_regiones_update(BIGINT,BIGINT) FROM public;


-- Function: fn_ctl_regiones_delete

CREATE OR REPLACE FUNCTION fn_ctl_regiones_delete(iKeyx BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	DELETE FROM ctl_regiones WHERE keyx = iKeyx;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_ctl_regiones_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_ctl_regiones_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_ctl_regiones_delete(BIGINT) FROM public;


CREATE OR REPLACE FUNCTION fn_ctl_regionunazona_delete(iRegion BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	DELETE FROM ctl_regiones WHERE id_region = iRegion;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_ctl_regionunazona_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_ctl_regionunazona_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_ctl_regionunazona_delete(BIGINT) FROM public;

-- Function: fn_ctl_regiones_insert
CREATE OR REPLACE FUNCTION fn_ctl_regiones_insert(iRegion BIGINT,iKeyxDir BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
	iCP		 	BIGINT DEFAULT 0;
	iKeyxDireccion		 	BIGINT DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT 1 FROM ctl_regiones WHERE keyxdir =  iKeyxDir) THEN
		SELECT d_codigo INTO iCP FROM cat_direcciones WHERE keyx = iKeyxDir;
		
		FOR iKeyxDireccion IN SELECT keyx FROM cat_direcciones WHERE d_codigo = iCP
		LOOP
			IF NOT EXISTS (SELECT 1 FROM ctl_regiones WHERE keyxdir =  iKeyxDireccion) THEN
				INSERT INTO ctl_regiones (id_region,keyxdir) SELECT iRegion,keyx FROM cat_direcciones WHERE keyx = iKeyxDireccion;
				IF FOUND THEN
					iRetorno = 1;
				END IF;
			END IF;
		END LOOP;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_ctl_regiones_insert(BIGINT,BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_ctl_regiones_insert(BIGINT,BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_ctl_regiones_insert(BIGINT,BIGINT) FROM public;

-- Function: fn_cte_select
CREATE OR REPLACE FUNCTION fn_cte_select(bKeyx BIGINT)
  RETURNS SETOF typ_mae_clientes AS
$BODY$
DECLARE
	rDatos typ_mae_clientes;
BEGIN
	FOR rDatos IN  SELECT keyx,nombres,apellidos,telcasa,telcelular FROM mae_clientes WHERE keyx = bKeyx
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cte_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cte_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_cte_select(BIGINT) FROM public;

-- Function: fn_cte_select
CREATE OR REPLACE FUNCTION fn_cte_select(vTelefono VARCHAR)
  RETURNS SETOF typ_mae_clientes AS
$BODY$
DECLARE
	rDatos typ_mae_clientes;
BEGIN
	FOR rDatos IN  	SELECT MAX(keyx)AS keyx,nombres,apellidos,telcasa,telcelular 
					FROM mae_clientes WHERE (telcasa = vTelefono OR telcelular = vTelefono)
					GROUP BY nombres,apellidos,telcasa,telcelular 
					ORDER BY keyx DESC LIMIT 1
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cte_select(VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cte_select(VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_cte_select(VARCHAR) FROM public;

-- Function: fn_cte_update
CREATE OR REPLACE FUNCTION fn_cte_update(bKeyx BIGINT,vNombres VARCHAR,vApellidos VARCHAR,vTelefonoCasa VARCHAR,vTelefonoCelular VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	UPDATE mae_clientes SET nombres = vNombres,apellidos = vApellidos,telcasa = vTelefonoCasa,telcelular = vTelefonoCelular
	WHERE keyx = bKeyx;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cte_update(BIGINT,VARCHAR,VARCHAR,VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cte_update(BIGINT,VARCHAR,VARCHAR,VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_cte_update(BIGINT,VARCHAR,VARCHAR,VARCHAR,VARCHAR) FROM public;

CREATE OR REPLACE FUNCTION fn_cte_insert(vNombres VARCHAR,vApellidos VARCHAR,vTelefonoCasa VARCHAR,vTelefonoCelular VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	SELECT COALESCE(MAX(keyx),0) INTO iRetorno FROM mae_clientes 
	WHERE (telcasa = vTelefonoCelular OR telcelular = vTelefonoCelular) 
	AND (vTelefonoCelular != '')
	ORDER BY 1 DESC LIMIT 1;

	IF (iRetorno <= 0) THEN
		SELECT COALESCE(MAX(keyx),0) INTO iRetorno FROM mae_clientes 
		WHERE (telcasa = vtelefonocasa OR telcelular = vtelefonocasa) 
		AND (vtelefonocasa != '')
		ORDER BY 1 DESC LIMIT 1;
	END IF;
	
	iRetorno = COALESCE(iRetorno,0);
	
	IF (iRetorno <= 0) THEN
		INSERT INTO mae_clientes(nombres,apellidos,telcasa,telcelular)
		SELECT vNombres,vApellidos,vTelefonoCasa,vTelefonoCelular ;
		IF FOUND THEN
			SELECT (CASE WHEN Last_value = 1 THEN (SELECT COUNT (1) FROM mae_clientes) ELSE Last_value END)::BIGINT INTO iRetorno FROM  mae_clientes_keyx_seq;
		END IF;
	ELSE		
		UPDATE mae_clientes SET nombres = vNombres,apellidos = vApellidos,telcasa = vTelefonoCasa,telcelular = vTelefonoCelular
		WHERE keyx = iRetorno;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cte_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cte_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_cte_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR) FROM public;

-- Function: fn_cte_delete
CREATE OR REPLACE FUNCTION fn_cte_delete(bKeyx BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	DELETE FROM mae_clientes WHERE keyx = bKeyx;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cte_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cte_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_cte_delete(BIGINT) FROM public;

-- Function: fn_cat_user_select
CREATE OR REPLACE FUNCTION fn_cat_user_select()
  RETURNS SETOF typ_cat_usuarios AS
$BODY$
DECLARE
	rDatos typ_cat_usuarios;
BEGIN
	FOR rDatos IN 	SELECT a.id_puesto,a.puesto,a.permisos FROM cat_usuarios AS a ORDER BY a.id_puesto
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_user_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_user_select() TO postgres;
REVOKE ALL ON FUNCTION fn_cat_user_select() FROM public;


CREATE OR REPLACE FUNCTION fn_user_select(cUser VARCHAR,cPwd VARCHAR,cOpcion INTEGER)
  RETURNS SETOF typ_usuario AS
$BODY$
DECLARE
	rDatos typ_usuario;
BEGIN
	RAISE NOTICE 'Entro';
	SELECT a.keyx,a.id_puesto,a.usuario,a.pwd,UPPER(a.nombre) INTO rDatos.keyx,rDatos.id_puesto,rDatos.usuario,rDatos.pwd,rDatos.nombre 
	FROM ctl_usuarios AS a
	WHERE a.usuario = cUser AND a.pwd = MD5(cPwd);

	SELECT permisos,puesto INTO rDatos.permisos,rDatos.descripcionempleado 
	FROM cat_usuarios 
	WHERE id_puesto = rDatos.id_puesto ;--AND cOpcion = ANY (permisos::int[]);
	
	IF (rDatos.permisos::VARCHAR = '' OR rDatos.permisos::VARCHAR = null ) THEN
		rDatos.permisos = '';
		RAISE NOTICE 'Si';
	END IF;
	raise notice 'cOpcion: %', rDatos;
	RETURN NEXT rDatos;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_user_select(VARCHAR,VARCHAR,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_user_select(VARCHAR,VARCHAR,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_user_select(VARCHAR,VARCHAR,INTEGER) FROM public;


-- Function: fn_user_select
CREATE OR REPLACE FUNCTION fn_user_select()
  RETURNS SETOF typ_usuario AS
$BODY$
DECLARE
	rDatos typ_usuario;
BEGIN
	
	FOR rDatos IN 	SELECT a.keyx,a.id_puesto,a.usuario,a.pwd,UPPER(a.nombre) FROM ctl_usuarios AS a ORDER BY a.keyx
	LOOP
		SELECT permisos,puesto INTO rDatos.permisos,rDatos.descripcionempleado FROM cat_usuarios WHERE id_puesto = rDatos.keyx;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_user_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_user_select() TO postgres;
REVOKE ALL ON FUNCTION fn_user_select() FROM public;


-- Function: fn_user_select
CREATE OR REPLACE FUNCTION fn_user_select(iKeyx INTEGER)
  RETURNS SETOF typ_usuario AS
$BODY$
DECLARE
	rDatos typ_usuario;
BEGIN
	
	FOR rDatos IN 	SELECT a.keyx,a.id_puesto,a.usuario,a.pwd,UPPER(a.nombre) FROM ctl_usuarios AS a WHERE a.keyx = iKeyx
	LOOP
		SELECT permisos,puesto INTO rDatos.permisos,rDatos.descripcionempleado FROM cat_usuarios WHERE id_puesto = rDatos.keyx;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_user_select(INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_user_select(INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_user_select(INTEGER) FROM public;


-- Function: fn_user_delete
CREATE OR REPLACE FUNCTION fn_user_delete(iKeyx INTEGER)
  RETURNS VARCHAR AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	DELETE FROM ctl_usuarios WHERE keyx = iKeyx;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_user_delete(INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_user_delete(INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_user_delete(INTEGER) FROM public;

-- Function: fn_user_update
CREATE OR REPLACE FUNCTION fn_user_update(iKeyx INTEGER,iId_puesto INTEGER,cUser VARCHAR,cPwd VARCHAR,cNombre VARCHAR)
  RETURNS VARCHAR AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	IF (SELECT COUNT(1) FROM ctl_usuarios WHERE usuario = cUser) <= 1 THEN
		UPDATE ctl_usuarios 
		SET id_puesto = iId_puesto , usuario = cUser, pwd = MD5(cPwd) ,nombre = cNombre
		WHERE keyx = iKeyx;	
		IF FOUND THEN
			iRetorno = 1;
		END IF;
	END IF;
	
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_user_update(INTEGER,INTEGER,VARCHAR,VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_user_update(INTEGER,INTEGER,VARCHAR,VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_user_update(INTEGER,INTEGER,VARCHAR,VARCHAR,VARCHAR) FROM public;

-- Function: fn_user_insert
CREATE OR REPLACE FUNCTION fn_user_insert(iId_puesto INTEGER,cUser VARCHAR,cPwd VARCHAR,cNombre VARCHAR)
  RETURNS VARCHAR AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT 1 FROM ctl_usuarios WHERE usuario = cUser) THEN
		INSERT INTO ctl_usuarios (id_puesto,usuario,pwd,nombre)
		SELECT iId_puesto, cUser, MD5(cPwd) ,cNombre;

		IF FOUND THEN
			iRetorno = 1;
		END IF;
	END IF;
	
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_user_insert(INTEGER,VARCHAR,VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_user_insert(INTEGER,VARCHAR,VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_user_insert(INTEGER,VARCHAR,VARCHAR,VARCHAR) FROM public;

-- Function: fn_variables_select
-- DROP FUNCTION fn_variables_select(BIGINT,INTEGER);

CREATE OR REPLACE FUNCTION fn_variables_select(bKeyx BIGINT,vEmpresa INTEGER)
  RETURNS SETOF typ_ctl_variables AS
$BODY$
DECLARE
	rDatos		typ_ctl_variables;
BEGIN
	FOR rDatos IN SELECT empresa,keyx,valor,descripcion FROM ctl_variables WHERE empresa = vEmpresa AND keyx = bKeyx
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_variables_select(BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_variables_select(BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_variables_select(BIGINT,INTEGER) FROM public;

--SELECT * FROM fn_variables_select(1,1);



-- Function: fn_variables_update
-- DROP FUNCTION fn_variables_update(BIGINT,INTEGER,INTEGER);

CREATE OR REPLACE FUNCTION fn_variables_update(bKeyx BIGINT,vEmpresa INTEGER,iValor INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	UPDATE ctl_variables SET valor= iValor WHERE empresa = vEmpresa AND keyx = bKeyx;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_variables_update(BIGINT,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_variables_update(BIGINT,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_variables_update(BIGINT,INTEGER,INTEGER) FROM public;

--SELECT * FROM fn_variables_update(1,1,40);



-- DROP FUNCTION fn_pedidosfolio_select();

CREATE OR REPLACE FUNCTION fn_pedidosfolio_select()
  RETURNS BIGINT AS
$BODY$
DECLARE
	iRetorno 	BIGINT DEFAULT 0;
	iMaxFolio 	BIGINT DEFAULT 0;
BEGIN
	SELECT LAST_VALUE INTO iRetorno FROM ctl_pedidos_foliopedido_seq;
	SELECT COALESCE(MAX(foliopedido),0) INTO iMaxFolio FROM ctl_pedidos;
	
	IF (iRetorno != iMaxFolio + 1) THEN
		iRetorno = iMaxFolio + 1;
		WHILE EXISTS(SELECT 1 FROM ctl_pedidos WHERE foliopedido = iRetorno) LOOP
			iRetorno = iRetorno + 1;
		END LOOP;
	ELSE
		SELECT NEXTVAL('ctl_pedidos_foliopedido_seq') INTO iRetorno;	
	END IF;		
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosfolio_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosfolio_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosfolio_select() FROM public;

--SELECT * FROM fn_pedidosfolio_select();

-- DROP FUNCTION fn_inventespecial_select(BIGINT,DATE);

CREATE OR REPLACE FUNCTION fn_inventespecial_select(bId_Articulo BIGINT,vFecha DATE)
  RETURNS SETOF typ_inventespecial AS
$BODY$
DECLARE
	rDatos typ_inventespecial;
BEGIN
	FOR rDatos IN 	SELECT inv.id_articulo,inv.descripcion,inv.cantidad,inv.precio,inv.flag_especial,('folio: '|| mae.foliopedido||', '|| mae.horasrenta ||', fecha: ' || ped.fechaentregapedido) AS horasrentadas 
					FROM ctl_inventario AS inv
					INNER JOIN mae_articulospedidos AS mae ON (inv.id_articulo = mae.id_articulo)
					INNER JOIN ctl_pedidos AS ped ON (mae.foliopedido = ped.foliopedido)
					WHERE inv.id_articulo = bId_Articulo
					AND fechaentregapedido::DATE = vFecha::DATE
					ORDER BY ped.fechaentregapedido
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_inventespecial_select(BIGINT,DATE)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_inventespecial_select(BIGINT,DATE) TO postgres;
REVOKE ALL ON FUNCTION fn_inventespecial_select(BIGINT,DATE) FROM public;


--SELECT * FROM fn_inventespecial_select(1,'2016-01-31'::DATE);



CREATE OR REPLACE FUNCTION fn_pedidos_insert(	iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT,iArticulopedidokeyx BIGINT,
						tFechaentregapedido DATE,tFechavueltapedido DATE,iFlag_recogermismodia INTEGER,
						vNotahoraentrega VARCHAR,vNotahorarecoger VARCHAR,iEstatuspedido INTEGER,iEmpleado INTEGER,vManteleria VARCHAR,
						dFlete DECIMAL, iIVA INTEGER,iFlagDescto INTEGER,iMontoDescto INTEGER, iMontoGarantia INTEGER)
  RETURNS BIGINT AS
$BODY$
DECLARE
	iReturn BIGINT DEFAULT 0;
BEGIN
	iReturn = iArticulopedidokeyx;
	INSERT INTO ctl_pedidos (foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
				 notahoraentrega,notahorarecoger,estatuspedido,empleado,manteleria,flete,flag_iva,flag_descuento,porcentajedescuento,garantia)
	SELECT iReturn,iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
				vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIVA,iFlagDescto,iMontoDescto,iMontoGarantia;
	IF NOT FOUND THEN
		iReturn = 0;
	ELSE
		PERFORM fn_trackpedidos_insert(iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
		vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIVA,iFlagDescto,iMontoDescto,iMontoGarantia);
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) FROM public;

/*SELECT * FROM fn_pedidos_insert(1::BIGINT,1::BIGINT,1::BIGINT,'2015-12-05'::DATE,'1900-01-01'::DATE,0,'entregar en la mañana'::VARCHAR,'recoger el dia siguiente'::VARCHAR,0,'',0,0,0,0,100);*/



CREATE OR REPLACE FUNCTION fn_pedidosmodificados_insert(	iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT,iArticulopedidokeyx BIGINT,
						tFechaentregapedido DATE,tFechavueltapedido DATE,iFlag_recogermismodia INTEGER,
						vNotahoraentrega VARCHAR,vNotahorarecoger VARCHAR,iEstatuspedido INTEGER,iEmpleado INTEGER,vManteleria VARCHAR,
						dFlete DECIMAL,iIva INTEGER,iFlagDescto INTEGER,iMontoDescto INTEGER,iMontoGarantia INTEGER)
  RETURNS BIGINT AS
$BODY$
DECLARE
	iReturn BIGINT DEFAULT 0;
BEGIN
	iReturn = iArticulopedidokeyx;
	
	DELETE FROM ctl_pedidos WHERE foliopedido = iReturn;
	
	IF FOUND THEN
		INSERT INTO ctl_pedidos (foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
					 notahoraentrega,notahorarecoger,estatuspedido,empleado,manteleria,flete,flag_iva,flag_descuento,porcentajedescuento,garantia)
		SELECT iReturn,iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
					vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIva,iFlagDescto,iMontoDescto,iMontoGarantia;
		IF NOT FOUND THEN
			iReturn = 0;
		ELSE
			PERFORM fn_trackpedidos_insert(iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
					vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIVA,iFlagDescto,iMontoDescto,iMontoGarantia);
		END IF;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) FROM public;

/*SELECT * FROM fn_pedidosmodificados_insert(1::BIGINT,1::BIGINT,1::BIGINT,'2015-12-05'::DATE,'1900-01-01'::DATE,0,'entregar en la mañana'::VARCHAR,'recoger el dia siguiente'::VARCHAR,0,'',0,1,0,0,100);*/

-- Function: fn_pedidos_select
-- DROP FUNCTION fn_pedidos_select(BIGINT);
CREATE OR REPLACE FUNCTION fn_pedidos_select(bClienteKeyx BIGINT)
  RETURNS SETOF typ_ctl_pedidos AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,notahoraentrega,notahorarecoger,estatuspedido,empleado,flete,UPPER(manteleria),
				flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_pedidos WHERE clientekeyx = bClienteKeyx
	LOOP
		IF EXISTS (SELECT 1 FROM ctl_direccionesborradas WHERE clientekeyx = rDatos.clientekeyx AND direccionpedidokeyx = rDatos.direccionpedidokeyx) THEN
			CONTINUE;
		END IF;
		
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidos_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidos_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidos_select(BIGINT) FROM public;

/*SELECT * FROM fn_pedidos_select(1);*/

-- Function: fn_pedidospendientes_select
CREATE OR REPLACE FUNCTION fn_pedidospendientes_select()
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,
				UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_pedidos WHERE estatuspedido IN (0,1,2,3)
	LOOP
		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,/*UPPER(dir.d_asenta)*/UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
		
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		vTexto = '';
		SELECT * FROM fn_pedidosnota_select(rDatos.foliopedido) AS retorno INTO vTexto;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidos WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidospendientes_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidospendientes_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidospendientes_select() FROM public;


/*SELECT * FROM fn_pedidospendientes_select() ORDER BY region DESC;*/


-- Function: fn_pedidospendientes_select
CREATE OR REPLACE FUNCTION fn_pedidospendientes_select(bFolioPedido BIGINT)
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	--rRecord		VARCHAR DEFAULT '';
BEGIN
		SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
				notahoraentrega,notahorarecoger,estatuspedido,empleado,flete,UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
		INTO 	rDatos.foliopedido,rDatos.clientekeyx,rDatos.direccionpedidokeyx,rDatos.articulopedidokeyx,rDatos.fechamovimiento,rDatos.fechaentregapedido,rDatos.fechavueltapedido,rDatos.flag_recogermismodia,
				rDatos.notahoraentrega,rDatos.notahorarecoger,rDatos.estatuspedido,rDatos.empleado,rDatos.flete,rDatos.manteleria,rDatos.iva,rDatos.descuento,rDatos.cantidaddescuento,rDatos.garantia
		FROM ctl_pedidos WHERE foliopedido = bFolioPedido AND estatuspedido IN (0,1,2,3);

		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,/*UPPER(dir.d_asenta)*/UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
		
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
	RETURN NEXT rDatosSalida;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidospendientes_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidospendientes_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidospendientes_select(BIGINT) FROM public;


/*SELECT * FROM fn_pedidospendientes_select(30) ORDER BY region DESC;*/


-- Function: fn_pedidosabonado_select
CREATE OR REPLACE FUNCTION fn_pedidosabonado_select()
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,
				UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_pedidos WHERE estatuspedido IN (0,1,2,3,4)
	LOOP
		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,UPPER(dir.d_asenta)/*UPPER(mae.colonia) */,UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
		
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		vTexto = '';
		SELECT * FROM fn_pedidosnota_select(rDatos.foliopedido) AS retorno INTO vTexto;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidos WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosabonado_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosabonado_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosabonado_select() FROM public;


/*SELECT * FROM fn_pedidosabonado_select() ORDER BY region DESC;*/


-- Function: fn_pedidostodos_select
-- DROP FUNCTION fn_pedidostodos_select();
CREATE OR REPLACE FUNCTION fn_pedidostodos_select()
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,
				UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_pedidos
	LOOP
		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,/*UPPER(dir.d_asenta)*/UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
		
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		vTexto = '';
		SELECT * FROM fn_pedidosnota_select(rDatos.foliopedido) AS retorno INTO vTexto;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN 	SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidos WHERE foliopedido = rDatos.foliopedido
						UNION ALL
						SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidoshist WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidostodos_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidostodos_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidostodos_select() FROM public;


/*SELECT * FROM fn_pedidostodos_select() WHERE estatuspedido !=99 AND to_char(fechapedido, 'YYYY-MM') LIKE '2016-01';*/


-- Function: fn_pedidosporempleado_select
-- DROP FUNCTION fn_pedidosporempleado_select(INTEGER);
CREATE OR REPLACE FUNCTION fn_pedidosporempleado_select(iEmpleado INTEGER)
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,
				UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_pedidos WHERE empleado = iEmpleado
	LOOP
		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,/*UPPER(dir.d_asenta)*/UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
		
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		vTexto = '';
		SELECT * FROM fn_pedidosnota_select(rDatos.foliopedido) AS retorno INTO vTexto;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN 	SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidos WHERE foliopedido = rDatos.foliopedido
						UNION ALL
						SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidoshist WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosporempleado_select(INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosporempleado_select(INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosporempleado_select(INTEGER) FROM public;


/*SELECT * FROM fn_pedidosporempleado_select(1) WHERE estatuspedido !=99 AND to_char(fechapedido, 'YYYY-MM') LIKE '2016-01';*/

-- Function: fn_abonospagos_insert
--DROP FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL);
-- DROP FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR);

CREATE OR REPLACE FUNCTION fn_abonospagos_insert(bFolioPedido BIGINT,dMonto DECIMAL,vRecibio VARCHAR)
  RETURNS DECIMAL AS
$BODY$
DECLARE
	iReturn 	DECIMAL DEFAULT 0; --DEVUELVE LA FERIA DEL CLIENTE
	dTotal	 	DECIMAL DEFAULT 0;
	dTotalFlete	DECIMAL DEFAULT 0;
	dIVA	 	DECIMAL DEFAULT 0;
	dMontoAbonado 	DECIMAL DEFAULT 0;
	dDescto		 	DECIMAL DEFAULT 0;
	dGarantia		DECIMAL DEFAULT 0;
	dCantidadDescto	DECIMAL DEFAULT 0;
	dFechaPedido 	DATE DEFAULT '1900-01-01';
BEGIN
	SELECT COALESCE(SUM(flete),0),flag_iva,flag_descuento,porcentajedescuento,garantia,fechaentregapedido INTO dTotalFlete,dIVA,dDescto,dCantidadDescto,dGarantia,dFechaPedido 
	FROM ctl_pedidos WHERE foliopedido = bFolioPedido GROUP BY flag_iva,flag_descuento,porcentajedescuento,garantia,fechaentregapedido;
	
	SELECT COALESCE(SUM(precio),0)+ dTotal INTO dTotal FROM mae_articulospedidos WHERE foliopedido = bFolioPedido;
	SELECT COALESCE(SUM(precio),0)+ dTotal INTO dTotal FROM mae_articulospedidoshist WHERE foliopedido = bFolioPedido;
	SELECT COALESCE(SUM(monto),0)+ dMonto INTO dMontoAbonado FROM ctl_abonospagos WHERE foliopedido = bFolioPedido;
	
	IF (dCantidadDescto > 0) THEN
		dTotal = ((dTotal * (100 - dCantidadDescto))/100)::DECIMAL(18);
	END IF;
	
	dTotal = (dTotal)::DECIMAL(18) + dTotalFlete::DECIMAL(18);
	
	IF (dIVA = 1) THEN
		dTotal = (dTotal * 1.16)::DECIMAL(18);
	ELSE
		dTotal = (dTotal)::DECIMAL(18);
	END IF;
	
	IF (dMontoAbonado > dTotal) THEN
		iReturn = dMontoAbonado - dTotal;
		dMonto = dMonto - iReturn;
	END IF;
	

	IF (dMonto > 0) THEN 
		INSERT INTO ctl_abonospagos(foliopedido,monto,fechaabono,montoantesoperacion,recibio)
		SELECT bFolioPedido,dMonto,NOW(),dTotal,UPPER(vRecibio);
	END IF;
	IF (dGarantia > 0 AND NOT EXISTS (SELECT 1 FROM ctl_cortegarantias WHERE foliopedido = bFolioPedido)) THEN
		PERFORM fn_pedidos_update(bFolioPedido,3);
	ELSEIF (SELECT COUNT(1) FROM ctl_pedidos WHERE foliopedido = bFolioPedido AND articulospendientes !='') > 0 THEN
		PERFORM fn_pedidos_update(bFolioPedido,3);
	ELSEIF (SELECT COUNT(1) FROM mae_articulospedidos WHERE foliopedido = bFolioPedido) > 0 THEN
		PERFORM fn_pedidos_update(bFolioPedido,3);
	ELSEIF (dMontoAbonado >= dTotal AND dFechaPedido <= NOW()::DATE) THEN
		PERFORM fn_pedidos_update(bFolioPedido,4);
	ELSE
		PERFORM fn_pedidos_update(bFolioPedido,3);
	END IF;

	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR) FROM public;


-- Function: fn_pedidosnota_select
-- DROP FUNCTION fn_pedidosnota_select(BIGINT);

CREATE OR REPLACE FUNCTION fn_pedidosnota_select(bFolioPedido BIGINT)
  RETURNS VARCHAR AS
$BODY$
DECLARE
	iRetorno VARCHAR DEFAULT '';
BEGIN
	SELECT COALESCE(articulospendientes,'') INTO iRetorno FROM ctl_pedidos WHERE foliopedido = bFolioPedido;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosnota_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosnota_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosnota_select(BIGINT) FROM public;


CREATE OR REPLACE FUNCTION fn_abonospagosgenerarcorte_update()
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn INTEGER DEFAULT 0;
	rRecord	RECORD;
BEGIN
	DELETE FROM ctl_cortetda WHERE fechamovimiento::DATE <= NOW()::DATE - 31; 

	INSERT INTO ctl_cortetda (idproceso,numeroabonos,monto,empleado,nom_empleado,folios)
	select 1,* from fn_abonospagosresumedetalleempleados_select();
	
	FOR rRecord IN select empleado from fn_abonospagosresumedetalleempleados_select()
	LOOP
		INSERT INTO ctl_cortetda (idproceso,numeroabonos,monto,empleado,nom_empleado,folios)
		select 2,0,* from fn_pedidosdepositodevueltos_select() WHERE empleado = rRecord.empleado;
		
		INSERT INTO ctl_cortetda (idproceso,numeroabonos,monto,empleado,nom_empleado,folios)
		select 3,* from fn_depositosresumedetalleempleados_select(rRecord.empleado);
	END LOOP;

	UPDATE ctl_pedidos SET flag_corte = 1, fecha_corte = now() WHERE flag_corte = 0;
	UPDATE ctl_cortegarantias SET flag_corte = 1, fecha_corte = now() WHERE flag_corte = 0;
	UPDATE ctl_abonospagos SET flag_corte = 1, fecha_corte = now() WHERE flag_corte = 0;
	
	IF FOUND THEN
		
		iReturn = 1;
	END IF;
	
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_abonospagosgenerarcorte_update()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_abonospagosgenerarcorte_update() TO postgres;
REVOKE ALL ON FUNCTION fn_abonospagosgenerarcorte_update() FROM public;



/*
--DROP TABLE ctl_cortegarantias;
CREATE TABLE ctl_cortegarantias(
	foliopedido 		BIGINT
	,garantia			INTEGER
	,fechamovimiento	TIMESTAMP DEFAULT '1900-01-01 00:00:00.0'
	,empleado			BIGINT,
	flag_corte			INTEGER DEFAULT 0,
	,PRIMARY KEY (foliopedido)
);*/


--DROP FUNCTION fn_pedidosanticiposgarantiascorte_insert(BIGINT)
CREATE OR REPLACE FUNCTION fn_pedidosanticiposgarantiascorte_insert(iEmpleado BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	
	iReturn INTEGER DEFAULT 0;
BEGIN
	INSERT INTO ctl_cortegarantias (foliopedido,garantia,fechamovimiento,empleado)
	SELECT foliopedido,SUM(garantia),NOW(),iEmpleado
	FROM ctl_pedidos
	WHERE estatuspedido IN (0,1,2,3,4) 
	AND fechamovimiento::DATE <= NOW()::DATE 
	AND garantia > 0
	AND foliopedido NOT IN (SELECT foliopedido FROM ctl_cortegarantias)
	GROUP BY foliopedido;
	
	IF FOUND THEN
		iReturn = 1;
	END IF;
	
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosanticiposgarantiascorte_insert(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosanticiposgarantiascorte_insert(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosanticiposgarantiascorte_insert(BIGINT) FROM public;


CREATE OR REPLACE FUNCTION fn_pedidosdescartaborrado_insert(bFolioPedido BIGINT,iUser INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	
	iReturn INTEGER DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT 1 FROM ctl_descartarborrados WHERE foliopedido = bFolioPedido) THEN
		INSERT INTO ctl_descartarborrados (foliopedido,fechamovimiento,empleado)
		SELECT bFolioPedido,NOW(),iUser;
	
		IF FOUND THEN
			iReturn = 1;
		END IF;
	ELSE
		iReturn = 1;
	END IF;
	
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosdescartaborrado_insert(BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosdescartaborrado_insert(BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosdescartaborrado_insert(BIGINT,INTEGER) FROM public;


-- Function: fn_cotizacion_delete
CREATE OR REPLACE FUNCTION fn_cotizacion_delete(bFolioPedido BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn INTEGER DEFAULT 0;
BEGIN
	IF (SELECT fn_cotizacion_update(bFolioPedido,99))> 0 THEN
		INSERT INTO mae_articuloscotizacionhist(foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado)
		SELECT foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado 
		FROM mae_articuloscotizacion WHERE foliopedido = bFolioPedido;
		iReturn = 1;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacion_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacion_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacion_delete(BIGINT) FROM public;


--Revisar si se ocupa
CREATE OR REPLACE FUNCTION fn_cotizacionarticulos_select(bFolioPedido BIGINT)
  RETURNS SETOF typ_mae_articulospedidos AS
$BODY$
DECLARE
	rDatos typ_mae_articulospedidos;
BEGIN

	FOR rDatos IN  	SELECT foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM mae_articuloscotizacion WHERE foliopedido = bFolioPedido
					UNION ALL
					SELECT foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM mae_articuloscotizacionhist WHERE foliopedido = bFolioPedido
	LOOP
			RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacionarticulos_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacionarticulos_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacionarticulos_select(BIGINT) FROM public;

-- Function: fn_cotizacion_select
CREATE OR REPLACE FUNCTION fn_cotizacion_select()
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,
				UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_cotizaciones WHERE estatuspedido = 1
	LOOP
		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		rDatosSalida.abono = 0;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(precio),0)AS totalpedido INTO rDatosSalida.total FROM mae_articuloscotizacion WHERE foliopedido = rDatosSalida.foliopedido;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
		
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		
		vTexto = '';
		--SELECT * FROM fn_pedidosnota_select(rDatos.foliopedido) AS retorno INTO vTexto;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articuloscotizacion WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacion_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacion_select() TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacion_select() FROM public;


-- Function: fn_cotizacion_update
CREATE OR REPLACE FUNCTION fn_cotizacion_update(bFolioPedido BIGINT,iEstatuscotizacion INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn INTEGER DEFAULT 0;
BEGIN
	UPDATE ctl_cotizaciones SET estatuspedido = iEstatuscotizacion
	WHERE foliopedido = bFolioPedido;
	IF FOUND THEN
		iReturn = 1;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacion_update(BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacion_update(BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacion_update(BIGINT,INTEGER) FROM public;


-- Function: fn_cotizacionfolio_select
CREATE OR REPLACE FUNCTION fn_cotizacionfolio_select()
  RETURNS BIGINT AS
$BODY$
DECLARE
	iRetorno 	BIGINT DEFAULT 0;
	iMaxFolio 	BIGINT DEFAULT 0;
BEGIN
	SELECT LAST_VALUE INTO iRetorno FROM ctl_cotizaciones_foliopedido_seq;
	SELECT COALESCE(MAX(foliopedido),0) INTO iMaxFolio FROM ctl_cotizaciones;
	
	IF (iRetorno != iMaxFolio + 1) THEN
		iRetorno = iMaxFolio + 1;
		WHILE EXISTS(SELECT 1 FROM ctl_cotizaciones WHERE foliopedido = iRetorno) LOOP
			iRetorno = iRetorno + 1;
		END LOOP;
	ELSE
		SELECT NEXTVAL('ctl_cotizaciones_foliopedido_seq') INTO iRetorno;	
	END IF;		
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacionfolio_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacionfolio_select() TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacionfolio_select() FROM public;


-- Function: fn_cotizacion_insert
CREATE OR REPLACE FUNCTION fn_cotizacion_insert(	iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT,iArticulopedidokeyx BIGINT,
						tFechaentregapedido DATE,tFechavueltapedido DATE,iFlag_recogermismodia INTEGER,
						vNotahoraentrega VARCHAR,vNotahorarecoger VARCHAR,iEstatuspedido INTEGER,iEmpleado INTEGER,vManteleria VARCHAR,
						dFlete DECIMAL, iIVA INTEGER,iFlagDescto INTEGER,iMontoDescto INTEGER, iMontoGarantia INTEGER)
  RETURNS BIGINT AS
$BODY$
DECLARE
	iReturn BIGINT DEFAULT 0;
BEGIN
	iReturn = iArticulopedidokeyx;
	INSERT INTO ctl_cotizaciones (foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
				 notahoraentrega,notahorarecoger,estatuspedido,empleado,manteleria,flete,flag_iva,flag_descuento,porcentajedescuento,garantia)
	SELECT iReturn,iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
				vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIVA,iFlagDescto,iMontoDescto,iMontoGarantia;
	IF NOT FOUND THEN
		iReturn = 0;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacion_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacion_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacion_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) FROM public;


CREATE OR REPLACE FUNCTION fn_cotizacionmodificados_insert(	iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT,iArticulopedidokeyx BIGINT,
						tFechaentregapedido DATE,tFechavueltapedido DATE,iFlag_recogermismodia INTEGER,
						vNotahoraentrega VARCHAR,vNotahorarecoger VARCHAR,iEstatuspedido INTEGER,iEmpleado INTEGER,vManteleria VARCHAR,
						dFlete DECIMAL,iIva INTEGER,iFlagDescto INTEGER,iMontoDescto INTEGER,iMontoGarantia INTEGER)
  RETURNS BIGINT AS
$BODY$
DECLARE
	iReturn BIGINT DEFAULT 0;
BEGIN
	iReturn = iArticulopedidokeyx;
	
	DELETE FROM ctl_cotizaciones WHERE foliopedido = iReturn;
	
	IF FOUND THEN
		INSERT INTO ctl_cotizaciones (foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
					 notahoraentrega,notahorarecoger,estatuspedido,empleado,manteleria,flete,flag_iva,flag_descuento,porcentajedescuento,garantia)
		SELECT iReturn,iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
					vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIva,iFlagDescto,iMontoDescto,iMontoGarantia;
		IF NOT FOUND THEN
			iReturn = 0;
		END IF;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacionmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacionmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacionmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) FROM public;



-- Function: fn_cotizacion_select
CREATE OR REPLACE FUNCTION fn_cotizacion_select(bClienteKeyx BIGINT)
  RETURNS SETOF typ_ctl_pedidos AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,notahoraentrega,notahorarecoger,estatuspedido,empleado,flete,UPPER(manteleria),
				flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_cotizaciones WHERE clientekeyx = bClienteKeyx
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacion_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacion_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacion_select(BIGINT) FROM public;


-- Function: fn_cotizacionpendientes_select
CREATE OR REPLACE FUNCTION fn_cotizacionpendientes_select(bFolioPedido BIGINT)
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
		SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
				notahoraentrega,notahorarecoger,estatuspedido,empleado,flete,UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
		INTO 	rDatos.foliopedido,rDatos.clientekeyx,rDatos.direccionpedidokeyx,rDatos.articulopedidokeyx,rDatos.fechamovimiento,rDatos.fechaentregapedido,rDatos.fechavueltapedido,rDatos.flag_recogermismodia,
				rDatos.notahoraentrega,rDatos.notahorarecoger,rDatos.estatuspedido,rDatos.empleado,rDatos.flete,rDatos.manteleria,rDatos.iva,rDatos.descuento,rDatos.cantidaddescuento,rDatos.garantia
		FROM ctl_cotizaciones WHERE foliopedido = bFolioPedido AND estatuspedido = 1;

		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		rDatosSalida.abono = 0;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(precio),0)AS totalpedido INTO rDatosSalida.total FROM mae_articuloscotizacion WHERE foliopedido = bFolioPedido;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
		
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articuloscotizacion WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
	RETURN NEXT rDatosSalida;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cotizacionpendientes_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cotizacionpendientes_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_cotizacionpendientes_select(BIGINT) FROM public;



-- Function: fn_articuloscotizacion_insert
CREATE OR REPLACE FUNCTION fn_articuloscotizacion_insert(iFolioPedido BIGINT,iId_articulo BIGINT,iCantidad INTEGER,vHorarioRenta VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
	iArticulosDisponibles 	INTEGER DEFAULT 0;
	iArticulosRentados 	INTEGER DEFAULT 0;
BEGIN 
	
	iRetorno = iFolioPedido;
	
	--obtengo los articulos rentados
	SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
	WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido::DATE = NOW()::DATE) 
	AND id_articulo = iId_articulo
	AND flag_rentado = 0::INTEGER;
	
	-- Articulos disponibles de inventario
	SELECT COALESCE(cantidad,0) INTO iArticulosDisponibles FROM ctl_inventario WHERE id_articulo = iId_articulo;
	
	IF (iArticulosDisponibles >= (iCantidad+ iArticulosRentados)) THEN
		
		INSERT INTO mae_articuloscotizacion (foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado)
		SELECT iFoliopedido,id_articulo,descripcion,iCantidad,precio * iCantidad,flag_especial,vHorarioRenta,0
		FROM ctl_inventario WHERE id_articulo = iId_articulo;
		
		IF NOT FOUND THEN
			iRetorno = 0;
		END IF;
	END IF;

	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articuloscotizacion_insert(BIGINT,BIGINT,INTEGER,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articuloscotizacion_insert(BIGINT,BIGINT,INTEGER,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_articuloscotizacion_insert(BIGINT,BIGINT,INTEGER,VARCHAR) FROM public;


CREATE OR REPLACE FUNCTION fn_articuloscotizacionrentado_insert(iFolioPedido BIGINT,iId_articulo BIGINT,iCantidad INTEGER,vHorarioRenta VARCHAR,vFlagRentado INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 				INTEGER DEFAULT 0;
	iArticulosRentados		INTEGER DEFAULT 0;
	iArticulosDisponibles	INTEGER DEFAULT 0;
	dFechaEntregaPedido 	DATE DEFAULT '1900-01-01';
BEGIN 
	-- obtengo la fecha del pedido.
	SELECT fechaentregapedido::DATE INTO dFechaEntregaPedido FROM ctl_pedidos WHERE foliopedido = iFolioPedido;
	
	--obtengo los articulos rentados para la fecha del pedido.
	SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
	WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido::DATE = dFechaEntregaPedido::DATE) 
	AND id_articulo = iId_articulo
	AND flag_rentado = vFlagRentado::INTEGER;
	
	-- Articulos disponibles de inventario
	SELECT COALESCE(cantidad,0) INTO iArticulosDisponibles FROM ctl_inventario WHERE id_articulo = iId_articulo;
	
	IF (iArticulosDisponibles >= (iCantidad+ iArticulosRentados) OR EXISTS(SELECT 1 FROM ctl_inventario WHERE id_articulo = iId_articulo AND flag_especial = 1)) THEN
		
		INSERT INTO mae_articuloscotizacion (foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado)
		SELECT iFoliopedido,id_articulo,descripcion,iCantidad,precio * iCantidad,flag_especial,vHorarioRenta,vFlagRentado
		FROM ctl_inventario WHERE id_articulo = iId_articulo;
		
		IF NOT FOUND THEN
			iRetorno = 0;
		END IF;
	END IF;
	
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articuloscotizacionrentado_insert(BIGINT,BIGINT,INTEGER,VARCHAR,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articuloscotizacionrentado_insert(BIGINT,BIGINT,INTEGER,VARCHAR,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_articuloscotizacionrentado_insert(BIGINT,BIGINT,INTEGER,VARCHAR,INTEGER) FROM public;

-- Function: fn_articuloscotizacion_select
CREATE OR REPLACE FUNCTION fn_articuloscotizacion_select(iFolioPedido BIGINT)
  RETURNS SETOF typ_mae_articulospedidos AS
$BODY$
DECLARE
	rDatos typ_mae_articulospedidos;
BEGIN
	FOR rDatos IN  	SELECT foliopedido,id_articulo,descripcion,SUM(cantidad),SUM(precio)::DECIMAL(18),flag_especial,horasrenta
					FROM mae_articuloscotizacion  
					WHERE foliopedido = iFolioPedido 
					GROUP BY foliopedido,id_articulo,descripcion,flag_especial,horasrenta
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articuloscotizacion_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articuloscotizacion_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_articuloscotizacion_select(BIGINT) FROM public;


CREATE OR REPLACE FUNCTION fn_articulosxmodificacioncotizacion_delete(iFolioPedido BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 1;
BEGIN
	DELETE FROM mae_articuloscotizacion WHERE foliopedido = iFolioPedido;
		IF FOUND THEN
			DELETE FROM mae_articuloscotizacionhist WHERE foliopedido = iFolioPedido;
			iRetorno = 1;
		END IF;		
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articulosxmodificacioncotizacion_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articulosxmodificacioncotizacion_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_articulosxmodificacioncotizacion_delete(BIGINT) FROM public;



CREATE OR REPLACE FUNCTION fn_pedidosdepositodevueltos_insert(bFolioPedido BIGINT,bMonto DECIMAL(18),bEmpleado BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno INTEGER DEFAULT 0;
	iAbono INTEGER DEFAULT 0;
BEGIN
	IF NOT 	EXISTS (SELECT 1 FROM ctl_cortegarantias WHERE foliopedido = bFolioPedido) AND 
			EXISTS (SELECT 1 FROM ctl_pedidos WHERE foliopedido = bFolioPedido AND garantia::DECIMAL(18) = bMonto::DECIMAL(18))THEN
		INSERT INTO ctl_cortegarantias (foliopedido,garantia,fechamovimiento,empleado)
		SELECT bFolioPedido,bMonto::DECIMAL(18),NOW(),bEmpleado;
		
		IF FOUND THEN
			--PERFORM pg_sleep(3);
			PERFORM fn_abonospagos_insert(bFolioPedido,0,'');
			iRetorno = 1;
		END IF;
	ELSE
		iRetorno = 2;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosdepositodevueltos_insert(BIGINT,DECIMAL(18),BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosdepositodevueltos_insert(BIGINT,DECIMAL(18),BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosdepositodevueltos_insert(BIGINT,DECIMAL(18),BIGINT) FROM public;




CREATE OR REPLACE FUNCTION fn_pedidosdomiciliocliente_delete(iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno INTEGER DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT 1 FROM ctl_direccionesborradas WHERE clientekeyx = iClientekeyx AND direccionpedidokeyx = iDireccionpedidokeyx )THEN
		INSERT INTO ctl_direccionesborradas(clientekeyx,direccionpedidokeyx)
		SELECT iClientekeyx,iDireccionpedidokeyx;
		
		IF FOUND THEN
			iRetorno = 1;
		END IF;
	ELSE
		iRetorno = 2;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosdomiciliocliente_delete(BIGINT,BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosdomiciliocliente_delete(BIGINT,BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosdomiciliocliente_delete(BIGINT,BIGINT) FROM public;



CREATE OR REPLACE FUNCTION fn_cte_select()
  RETURNS SETOF typ_mae_clientes AS
$BODY$
DECLARE
	rDatos typ_mae_clientes;
BEGIN
	FOR rDatos IN  	SELECT MAX(keyx),nombres,apellidos,telcasa,telcelular 
					FROM mae_clientes
					GROUP BY nombres,apellidos,telcasa,telcelular 
					ORDER BY nombres,apellidos
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cte_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cte_select() TO postgres;
REVOKE ALL ON FUNCTION fn_cte_select() FROM public;



CREATE OR REPLACE FUNCTION fn_trackpedidos_insert(	iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT,iArticulopedidokeyx BIGINT,
						tFechaentregapedido DATE,tFechavueltapedido DATE,iFlag_recogermismodia INTEGER,
						vNotahoraentrega VARCHAR,vNotahorarecoger VARCHAR,iEstatuspedido INTEGER,iEmpleado INTEGER,vManteleria VARCHAR,
						dFlete DECIMAL, iIVA INTEGER,iFlagDescto INTEGER,iMontoDescto INTEGER, iMontoGarantia INTEGER)
  RETURNS BIGINT AS
$BODY$
DECLARE
	iReturn BIGINT DEFAULT 0;
	iSecuencia INTEGER DEFAULT 0;
BEGIN	
	iReturn = iArticulopedidokeyx;
	
	SELECT COALESCE(MAX(secuenciamodificacion),0)::INTEGER INTO iSecuencia FROM track_ctl_pedidos WHERE foliopedido = iReturn;
	
	iSecuencia = COALESCE(MAX(iSecuencia),0)::INTEGER + 1;

	INSERT INTO track_ctl_pedidos (foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
				 notahoraentrega,notahorarecoger,estatuspedido,empleado,manteleria,flete,flag_iva,flag_descuento,porcentajedescuento,garantia,secuenciamodificacion)
	SELECT iReturn,iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
				vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIVA,iFlagDescto,iMontoDescto,iMontoGarantia,iSecuencia;
	IF NOT FOUND THEN
		iReturn = 0;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_trackpedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_trackpedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_trackpedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER,INTEGER,INTEGER,INTEGER) FROM public;


CREATE OR REPLACE FUNCTION fn_pedidostodosmodificados_select()
  RETURNS SETOF typ_pedidospendiente2_modificados AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos_modificados;
	rDatosSalida typ_pedidospendiente2_modificados;
	iColonia 	BIGINT DEFAULT 0;
	iSecuencia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
					fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,
					UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia,secuenciamodificacion
					FROM track_ctl_pedidos ORDER BY  foliopedido,secuenciamodificacion
	LOOP
		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		rDatosSalida.secuenciamodificacion = rDatos.secuenciamodificacion;
			
		SELECT COALESCE(MAX(secuenciamodificacion),0) INTO iSecuencia FROM track_ctl_pedidos WHERE foliopedido = rDatosSalida.foliopedido;
		IF (iSecuencia <= 1) THEN
			CONTINUE;		
		END IF;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,/*UPPER(dir.d_asenta)*/UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		--SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		SELECT COALESCE(SUM(precio),0) INTO rDatosSalida.total FROM track_mae_articulospedidos 
		WHERE foliopedido = rDatos.foliopedido AND secuenciamodificacion = rDatosSalida.secuenciamodificacion;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
		
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		vTexto = '';
		SELECT * FROM fn_pedidosnota_select(rDatos.foliopedido) AS retorno INTO vTexto;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN 	SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM track_mae_articulospedidos 
						WHERE foliopedido = rDatos.foliopedido AND secuenciamodificacion = rDatosSalida.secuenciamodificacion
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidostodosmodificados_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidostodosmodificados_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidostodosmodificados_select() FROM public;



CREATE OR REPLACE FUNCTION fn_pedidosdescartamodificado_delete(bFolioPedido BIGINT,iSecuencia INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	
	iReturn INTEGER DEFAULT 0;
BEGIN
	IF EXISTS (SELECT 1 FROM track_ctl_pedidos WHERE foliopedido = bFolioPedido AND secuenciamodificacion = iSecuencia ) THEN
		DELETE FROM track_ctl_pedidos WHERE foliopedido = bFolioPedido AND secuenciamodificacion = iSecuencia;
		DELETE FROM track_mae_articulospedidos WHERE foliopedido = bFolioPedido AND secuenciamodificacion = iSecuencia;
	
		IF FOUND THEN
			iReturn = 1;
		END IF;
	ELSE
		iReturn = 2;
	END IF;
	
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosdescartamodificado_delete(BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosdescartamodificado_delete(BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosdescartamodificado_delete(BIGINT,INTEGER) FROM public;



--DROP TABLE ctl_cortetda;
CREATE TABLE ctl_cortetda
(
	keyx			BIGSERIAL,
	fechamovimiento	DATE DEFAULT NOW(),
	idproceso		INTEGER,
	numeroabonos 	BIGINT,
	monto			DECIMAL,
	empleado		BIGINT,
	nom_empleado	VARCHAR,
	folios			TEXT
);

--DROP INDEX ctl_cortetda_fecha_movimiento;
CREATE INDEX ctl_cortetda_fecha_movimiento ON ctl_cortetda (fechamovimiento);



CREATE OR REPLACE FUNCTION fn_cortetda_select(iIdproceso INTEGER, dFechaCorte DATE)
  RETURNS SETOF typ_abonospagosdetalle AS
$BODY$
DECLARE
	rDatos typ_abonospagosdetalle;
	rRecord RECORD;
	vFolios TEXT DEFAULT '';
	bDireccion 	BIGINT DEFAULT 0;
	vColonia	VARCHAR DEFAULT '';
BEGIN
	rDatos.numeroabonos = 0;
	rDatos.monto = 0;
	rDatos.empleado = 0;
	rDatos.nom_empleado = '';
	rDatos.folios = '';
	FOR rDatos IN 	SELECT COALESCE(SUM(numeroabonos),0) AS numeroabonos,COALESCE(SUM(monto),0)AS monto ,empleado,nom_empleado,''
					FROM ctl_cortetda 
					WHERE fechamovimiento::DATE = dFechaCorte::DATE --'2016-03-19'
					AND idproceso = iIdproceso
					GROUP BY empleado,nom_empleado
					ORDER BY empleado
	LOOP
		vFolios := '';
		FOR rRecord IN 	SELECT folios 
						FROM ctl_cortetda 
						WHERE fechamovimiento::DATE = dFechaCorte::DATE --'2016-03-19'
						AND idproceso = iIdproceso
						AND empleado = rDatos.empleado
		LOOP
			vFolios = vFolios || rRecord.folios;
		END LOOP;
			rDatos.folios = vFolios;
			
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cortetda_select(INTEGER,DATE)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cortetda_select(INTEGER,DATE) TO postgres;
REVOKE ALL ON FUNCTION fn_cortetda_select(INTEGER,DATE) FROM public;

--DROP TYPE typ_fechascortetda;
CREATE TYPE typ_fechascortetda AS (fecha_corte DATE);

CREATE OR REPLACE FUNCTION fn_fechascortetda_select()
  RETURNS SETOF typ_fechascortetda AS
$BODY$
DECLARE
	rDatos typ_fechascortetda;
BEGIN
	FOR rDatos IN 	SELECT DISTINCT fechamovimiento
					FROM ctl_cortetda 
					ORDER BY fechamovimiento
	LOOP
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_fechascortetda_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_fechascortetda_select() TO postgres;
REVOKE ALL ON FUNCTION fn_fechascortetda_select() FROM public;



-- Function: fn_pedidosdevolverborrado_update
CREATE OR REPLACE FUNCTION fn_pedidosdevolverborrado_update(bFolioPedido BIGINT,iEstatuspedido INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn INTEGER DEFAULT 0;
BEGIN
	UPDATE ctl_pedidos SET estatuspedido = iEstatuspedido
	WHERE foliopedido = bFolioPedido;
	IF FOUND THEN
		
		
		INSERT INTO mae_articulospedidos (keyx,foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado)
		SELECT  keyx,foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado
		FROM mae_articulospedidoshist WHERE foliopedido = bFolioPedido;
		
		DELETE FROM mae_articulospedidoshist WHERE foliopedido = bFolioPedido;
		iReturn = 1;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosdevolverborrado_update(BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosdevolverborrado_update(BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosdevolverborrado_update(BIGINT,INTEGER) FROM public;

-- Function: fn_cat_grupoinventario_select
CREATE OR REPLACE FUNCTION fn_cat_grupoinventario_select()
  RETURNS SETOF typ_cat_grupo AS
$BODY$
DECLARE
	rDatos typ_cat_grupo;
BEGIN
	FOR rDatos IN SELECT id_grupo,nombregrupo,descgrupo FROM cat_grupoinventario ORDER BY id_grupo
	LOOP 
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_grupoinventario_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_grupoinventario_select() TO postgres;
REVOKE ALL ON FUNCTION fn_cat_grupoinventario_select() FROM public;


-- Function: fn_cat_grupoinventario_insert
CREATE OR REPLACE FUNCTION fn_cat_grupoinventario_insert(vNombre VARCHAR,vDesc VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT 1 FROM cat_grupoinventario WHERE nombregrupo = vNombre ) THEN
		INSERT INTO cat_grupoinventario (nombregrupo,descgrupo) SELECT vNombre,vDesc;
		IF FOUND THEN
			iRetorno = 1;
		END IF;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_grupoinventario_insert(VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_grupoinventario_insert(VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_cat_grupoinventario_insert(VARCHAR,VARCHAR) FROM public;


-- Function: fn_cat_grupoinventario_delete
CREATE OR REPLACE FUNCTION fn_cat_grupoinventario_delete(iGrupo BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	DELETE FROM cat_grupoinventario WHERE id_grupo = iGrupo;
	IF FOUND THEN
		iRetorno = 1;
		DELETE FROM ctl_grupoinventario WHERE id_grupo = iGrupo;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_grupoinventario_delete(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_grupoinventario_delete(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_cat_grupoinventario_delete(BIGINT) FROM public;


-- Function: fn_cat_grupoinventario_update
CREATE OR REPLACE FUNCTION fn_cat_grupoinventario_update(iGrupo BIGINT,vNombre VARCHAR, vDescGrupo VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	UPDATE cat_grupoinventario SET nombregrupo = vNombre, descgrupo = vDescGrupo WHERE id_grupo = iGrupo;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_cat_grupoinventario_update(BIGINT,VARCHAR,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cat_grupoinventario_update(BIGINT,VARCHAR,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_cat_grupoinventario_update(BIGINT,VARCHAR,VARCHAR) FROM public;




-- DROP TABLE cat_grupoinventario;
CREATE TABLE cat_grupoinventario(
	id_grupo	 	BIGSERIAL,
	nombregrupo 	VARCHAR,
	descgrupo 		VARCHAR,
	PRIMARY KEY(id_grupo)
);


-- DROP TABLE ctl_grupoinventario;
CREATE TABLE ctl_grupoinventario(
	keyx		BIGSERIAL,
	id_grupo 	BIGINT,
	id_articulo	BIGINT,
	PRIMARY KEY(id_grupo,id_articulo)
);

--DROP INDEX ctl_grupoinventario_id_grupo; 
CREATE INDEX ctl_grupoinventario_id_grupo ON ctl_grupoinventario (id_grupo);
--DROP INDEX ctl_grupoinventario_id_articulo; 
CREATE INDEX ctl_grupoinventario_id_articulo ON ctl_grupoinventario (id_articulo);


-- Function: fn_pedidospendientescobro_select
CREATE OR REPLACE FUNCTION fn_pedidospendientescobro_select()
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,
				UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_pedidos WHERE estatuspedido IN (0,1,2,3)
	LOOP
		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,/*UPPER(dir.d_asenta)*/UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
				
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		IF (rDatosSalida.total > rDatosSalida.abono) OR  (NOT EXISTS (SELECT 1 FROM ctl_cortegarantias WHERE foliopedido = rDatos.foliopedido) AND rDatos.garantia > 0) THEN
		ELSE
			CONTINUE;
		END IF;
		
		vTexto = '';
		SELECT * FROM fn_pedidosnota_select(rDatos.foliopedido) AS retorno INTO vTexto;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN 
					SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidos WHERE foliopedido = rDatos.foliopedido
					UNION ALL
					SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidoshist WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidospendientescobro_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidospendientescobro_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidospendientescobro_select() FROM public;



-- Function: fn_pedidospendientesdevolverdeposito_select
CREATE OR REPLACE FUNCTION fn_pedidospendientesdevolverdeposito_select()
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,
				UPPER(manteleria),flag_iva,flag_descuento,porcentajedescuento,garantia
			FROM ctl_pedidos WHERE estatuspedido IN (0,1,2,3)
	LOOP
		rDatosSalida.fechapedido = rDatos.fechaentregapedido;
		rDatosSalida.fechavueltapedido = rDatos.fechavueltapedido;
		rDatosSalida.foliopedido = rDatos.foliopedido;
		rDatosSalida.notahoraentrega = rDatos.notahoraentrega;
		rDatosSalida.notahorarecoger = rDatos.notahorarecoger;
		rDatosSalida.estatuspedido = rDatos.estatuspedido;
		rDatosSalida.manteleria = rDatos.manteleria;
		rDatosSalida.flete = rDatos.flete::DECIMAL(18);
		rDatosSalida.iva = rDatos.iva;
		rDatosSalida.descuento = rDatos.descuento;
		rDatosSalida.cantidaddescuento = rDatos.cantidaddescuento;
		rDatosSalida.garantia = rDatos.garantia;
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,/*UPPER(dir.d_asenta)*/UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||' - x','-',1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		--rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18);
				
		IF (rDatosSalida.cantidaddescuento > 0) THEN
			rDatosSalida.total = ((rDatosSalida.total * (100 - rDatosSalida.cantidaddescuento))/100)::DECIMAL(18);
		END IF;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		IF (NOT EXISTS (SELECT 1 FROM ctl_cortegarantias WHERE foliopedido = rDatos.foliopedido) AND rDatos.garantia > 0) THEN
		ELSE
			CONTINUE;
		END IF;
		
		vTexto = '';
		SELECT * FROM fn_pedidosnota_select(rDatos.foliopedido) AS retorno INTO vTexto;
		
		IF vTexto != '' THEN
			vTexto:= vTexto || ',';
		END IF;
		
		FOR rRecord IN 
					SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidos WHERE foliopedido = rDatos.foliopedido
					UNION ALL
					SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidoshist WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;

		rDatosSalida.detallepedido = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidospendientesdevolverdeposito_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidospendientesdevolverdeposito_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidospendientesdevolverdeposito_select() FROM public;


-- Function: fn_abonospagosdetalle_select
CREATE OR REPLACE FUNCTION fn_abonospagosdetalle_select(bFolioPedido BIGINT)
  RETURNS SETOF typ_ctl_abonospagos2 AS
$BODY$
DECLARE
	rDatos typ_ctl_abonospagos2;
BEGIN
	FOR rDatos IN 	SELECT foliopedido,monto,fechaabono,montoantesoperacion,recibio,nom_empleado 
			FROM ctl_abonospagos WHERE foliopedido = bFolioPedido 
	LOOP
		IF (TRIM(rDatos.recibio) = '') THEN
			rDatos.recibio = rDatos.usuario;
		END IF;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_abonospagosdetalle_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_abonospagosdetalle_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_abonospagosdetalle_select(BIGINT) FROM public;


CREATE OR REPLACE FUNCTION fn_abonospagosresumedetalleempleados_select()
  RETURNS SETOF typ_abonospagosdetalle AS
$BODY$
DECLARE
	rDatos typ_abonospagosdetalle;
	rRecord RECORD;
	vFolios TEXT DEFAULT '';
	bDireccion 	BIGINT DEFAULT 0;
	vColonia	VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN 	SELECT 0,0,usr.keyx,UPPER(usr.nombre),'' 
					FROM ctl_usuarios AS usr
					ORDER BY usr.keyx
	LOOP
		SELECT COUNT(pago.monto)AS numeroabonos,COALESCE(SUM(pago.monto),0)AS monto 
		INTO rDatos.numeroabonos,rDatos.monto 
		FROM ctl_abonospagos AS pago 
		WHERE empleado = rDatos.empleado 
		AND flag_corte = 0;
		
		vFolios := '';
		FOR rRecord IN 	SELECT foliopedido,SUM(monto)AS monto FROM ctl_abonospagos 
						WHERE empleado = rDatos.empleado AND flag_corte = 0
						GROUP BY foliopedido
						ORDER BY foliopedido 
		LOOP
			SELECT direccionpedidokeyx INTO bDireccion FROM ctl_pedidos WHERE foliopedido = rRecord.foliopedido;
			SELECT UPPER(COALESCE( SPLIT_PART(colonia || '-  x',' - ', 2),'')) INTO vColonia FROM mae_direccionpedidos  WHERE keyx = bDireccion;
			vFolios := vFolios || 'FOLIO: ' || rRecord.foliopedido || ', $'|| rRecord.monto || ', '|| vColonia ||'<br/>';
		END LOOP;
			rDatos.folios = vFolios;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_abonospagosresumedetalleempleados_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_abonospagosresumedetalleempleados_select() TO postgres;
REVOKE ALL ON FUNCTION fn_abonospagosresumedetalleempleados_select() FROM public;

CREATE OR REPLACE FUNCTION fn_pedidosanticiposgarantias_select()
  RETURNS SETOF typ_pedidosanticiposgarantias AS
$BODY$
DECLARE
	rDatos 		typ_pedidosanticiposgarantias;
	rRecordChild 	RECORD;
	vFolios 		TEXT DEFAULT '';
	vColonia	VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN 	SELECT SUM(garantia),empleado
					FROM ctl_pedidos
					WHERE estatuspedido IN (0,1,2,3,4) 
					AND fechamovimiento::DATE = NOW()::DATE 
					AND garantia > 0
					--AND foliopedido NOT IN (SELECT foliopedido FROM ctl_cortegarantias)
					AND flag_corte = 0
					GROUP BY empleado
					ORDER BY empleado
	LOOP
		SELECT UPPER(nombre) INTO rDatos.nom_empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		vFolios := '';
		FOR rRecordChild  IN 	SELECT foliopedido,garantia,direccionpedidokeyx 
								FROM ctl_pedidos 
								WHERE estatuspedido IN (0,1,2,3,4) 
								AND fechamovimiento::DATE = NOW()::DATE 
								AND garantia > 0	
								AND empleado = rDatos.empleado
								--AND foliopedido NOT IN (SELECT foliopedido FROM ctl_cortegarantias)
								AND flag_corte = 0
								GROUP BY foliopedido
								ORDER BY foliopedido 
		LOOP
			SELECT UPPER(COALESCE( SPLIT_PART(colonia || '-  x',' - ', 2),'')) INTO vColonia FROM mae_direccionpedidos  WHERE keyx = rRecordChild.direccionpedidokeyx;
			
			vFolios := vFolios || 'FOLIO: ' || rRecordChild.foliopedido || ', $'|| rRecordChild.garantia || ', '|| vColonia ||'<br/>';
		END LOOP;
			rDatos.folios = vFolios;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosanticiposgarantias_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosanticiposgarantias_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosanticiposgarantias_select() FROM public;


CREATE OR REPLACE FUNCTION fn_pedidosdepositodevueltos_select()
  RETURNS SETOF typ_pedidosanticiposgarantias AS
$BODY$
DECLARE
	rDatos 		typ_pedidosanticiposgarantias;
	rRecordChild 	RECORD;
	vFolios 		TEXT DEFAULT '';
	vColonia	VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN 	SELECT SUM(ped.garantia),gar.empleado
					FROM ctl_cortegarantias AS gar
					INNER JOIN ctl_pedidos AS ped ON (ped.foliopedido = gar.foliopedido)
					WHERE ped.estatuspedido IN (0,1,2,3,4) 
					AND ped.fechamovimiento::DATE <= NOW()::DATE 
					AND gar.fechamovimiento::DATE = NOW()::DATE 
					AND gar.flag_corte = 0
					AND ped.garantia > 0
					GROUP BY gar.empleado
					ORDER BY gar.empleado
	
					/*SELECT SUM(ped.garantia),empleado
					FROM ctl_usuarios AS usr,ctl_pedidos AS ped
					WHERE ped.estatuspedido IN (0,1,2,3,4) 
					AND ped.fechamovimiento::DATE <= NOW()::DATE 
					AND ped.garantia > 0
					AND ped.foliopedido IN (SELECT foliopedido FROM ctl_cortegarantias WHERE fechamovimiento::DATE = NOW()::DATE)
					GROUP BY empleado
					ORDER BY empleado*/
	LOOP
		SELECT UPPER(nombre) INTO rDatos.nom_empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		vFolios := '';
		FOR rRecordChild  IN 	SELECT foliopedido,garantia,direccionpedidokeyx 
								FROM ctl_pedidos 
								WHERE estatuspedido IN (0,1,2,3,4) 
								--AND fechamovimiento::DATE <= NOW()::DATE 
								AND garantia > 0	
								--AND empleado = rDatos.empleado
								AND foliopedido IN (SELECT foliopedido FROM ctl_cortegarantias WHERE empleado = rDatos.empleado AND fechamovimiento::DATE = NOW()::DATE AND flag_corte = 0)
								GROUP BY foliopedido
								ORDER BY foliopedido 
		LOOP
			SELECT UPPER(COALESCE( SPLIT_PART(colonia || '-  x',' - ', 2),'')) INTO vColonia FROM mae_direccionpedidos  WHERE keyx = rRecordChild.direccionpedidokeyx;
			
			vFolios := vFolios || 'FOLIO: ' || rRecordChild.foliopedido || ', $'|| rRecordChild.garantia || ', '|| vColonia ||'<br/>';
		END LOOP;
			rDatos.folios = vFolios;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosdepositodevueltos_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosdepositodevueltos_select() TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosdepositodevueltos_select() FROM public;


CREATE OR REPLACE FUNCTION fn_depositosresumedetalleempleados_select(iEmpleado BIGINT)
  RETURNS SETOF typ_abonospagosdetalle AS
$BODY$
DECLARE
	rDatos typ_abonospagosdetalle;
	rRecord RECORD;
	vFolios TEXT DEFAULT '';
	bDireccion 	BIGINT DEFAULT 0;
	vColonia	VARCHAR DEFAULT '';
BEGIN
	FOR rDatos IN 	SELECT COUNT(foliopedido),SUM(garantia),iEmpleado,'',''
					FROM ctl_pedidos
					WHERE estatuspedido IN (0,1,2,3,4) 
					AND fechamovimiento::DATE = NOW()::DATE 
					AND garantia > 0
					--AND foliopedido NOT IN (SELECT foliopedido FROM ctl_cortegarantias)
					AND empleado = iEmpleado
					AND flag_corte = 0
					
					
	LOOP
		rDatos.numeroabonos = COALESCE(rDatos.numeroabonos,0);
		rDatos.monto = COALESCE(rDatos.monto,0);
		SELECT UPPER(nombre) INTO rDatos.nom_empleado FROM ctl_usuarios WHERE keyx = iEmpleado;
		
		vFolios := '';
		FOR rRecord IN 	SELECT foliopedido,garantia,iEmpleado,'',''
						FROM ctl_pedidos
						WHERE estatuspedido IN (0,1,2,3,4) 
						AND fechamovimiento::DATE = NOW()::DATE 
						AND garantia > 0
						--AND foliopedido NOT IN (SELECT foliopedido FROM ctl_cortegarantias)
						AND empleado = iEmpleado
						AND flag_corte = 0
		LOOP
			
			SELECT direccionpedidokeyx INTO bDireccion FROM ctl_pedidos WHERE foliopedido = rRecord.foliopedido;
			SELECT UPPER(COALESCE( SPLIT_PART(colonia || '-  x',' - ', 2),'')) INTO vColonia FROM mae_direccionpedidos  WHERE keyx = bDireccion;
			vFolios := vFolios || 'FOLIO: ' || rRecord.foliopedido || ', $'|| rRecord.garantia || ', '|| vColonia ||'<br/>';
		END LOOP;
			rDatos.folios = vFolios;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_depositosresumedetalleempleados_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_depositosresumedetalleempleados_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_depositosresumedetalleempleados_select(BIGINT) FROM public;



-- Function: fn_depositodevuelto_select
CREATE OR REPLACE FUNCTION fn_depositodevuelto_select(bFolioPedido BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iReturn INTEGER DEFAULT 0;
BEGIN
	IF EXISTS(SELECT 1 FROM ctl_cortegarantias WHERE foliopedido = bFolioPedido) THEN
		iReturn = 1;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_depositodevuelto_select(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_depositodevuelto_select(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_depositodevuelto_select(BIGINT) FROM public;

-- DROP FUNCTION fn_pedidosnota_update(BIGINT,VARCHAR);
CREATE OR REPLACE FUNCTION fn_pedidosnota_update(bFolioPedido BIGINT,vArtOlvidados VARCHAR)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno INTEGER DEFAULT 0;
BEGIN
	UPDATE ctl_pedidos SET articulospendientes = vArtOlvidados WHERE foliopedido = bFolioPedido;
	IF FOUND THEN
		iRetorno = 1;
	END IF;
	--Con esto cambia el estatus a 4 en caso de ser necesario.
	PERFORM fn_abonospagos_insert(bFolioPedido,0,'');
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosnota_update(BIGINT,VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosnota_update(BIGINT,VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosnota_update(BIGINT,VARCHAR) FROM public;


-- Function: fn_unarticulopedidohist_insert
CREATE OR REPLACE FUNCTION fn_unarticulopedidohist_insert(iFolioPedido BIGINT,iId_articulo BIGINT,iCantidad INTEGER)
  RETURNS INTEGER AS
$BODY$
DECLARE
	rDatos 			typ_mae_articulospedidos;
	iRetorno 		INTEGER DEFAULT 0;
	iDiferencia		INTEGER DEFAULT 0;
	dTotalAbono		DECIMAL DEFAULT 0;
	dTotalPedido 	DECIMAL DEFAULT 0;
	dGarantia	 	DECIMAL DEFAULT 0;
	iArticulosDisponibles 	INTEGER DEFAULT 0;
	iArticulosRegresa	 	INTEGER DEFAULT 0;
	iDescto				 	INTEGER DEFAULT 0;
	
BEGIN
	SELECT foliopedido,id_articulo,descripcion,SUM(cantidad),SUM(precio)/SUM(cantidad)::DECIMAL(18),flag_especial
	INTO rDatos.foliopedido,rDatos.id_articulo,rDatos.descripcion,rDatos.cantidad,rDatos.precio,rDatos.flag_especial
	FROM mae_articulospedidos  WHERE foliopedido = iFolioPedido AND id_articulo = iId_articulo
	GROUP BY foliopedido,id_articulo,descripcion,flag_especial;
	
	-- Articulos disponibles de inventario
	SELECT COALESCE(cantidad,0) INTO iArticulosDisponibles FROM ctl_inventario WHERE id_articulo = iId_articulo;
	
	IF (iCantidad <= rDatos.cantidad) THEN
		iArticulosRegresa = iCantidad;
	ELSE
		iArticulosRegresa = rDatos.cantidad;
	END IF;
	
	IF (rDatos.foliopedido > 0 AND iArticulosDisponibles >= iArticulosRegresa) THEN
		INSERT INTO mae_articulospedidoshist(foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta)
		SELECT rDatos.foliopedido,rDatos.id_articulo,rDatos.descripcion,iCantidad,rDatos.precio * iCantidad::INTEGER,rDatos.flag_especial,rDatos.horasrenta;

		IF FOUND THEN
			DELETE FROM mae_articulospedidos WHERE foliopedido = iFolioPedido AND id_articulo = rDatos.id_articulo;
			iDiferencia = rDatos.cantidad - iCantidad;
			IF iDiferencia > 0 THEN
				INSERT INTO mae_articulospedidos(foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta)
				SELECT rDatos.foliopedido,rDatos.id_articulo,rDatos.descripcion,iDiferencia,rDatos.precio * iDiferencia,rDatos.flag_especial,rDatos.horasrenta;
			END IF;
		END IF;
	END IF;
	
	SELECT SUM(totalpedido)::DECIMAL(18) INTO dTotalPedido FROM 
	(SELECT COALESCE(SUM(precio),0)AS totalpedido FROM mae_articulospedidos WHERE foliopedido = iFolioPedido
	UNION ALL
	SELECT COALESCE(SUM(precio),0) AS totalpedido FROM mae_articulospedidoshist WHERE foliopedido = iFolioPedido
	UNION ALL
	SELECT COALESCE(SUM(flete),0) AS totalpedido FROM ctl_pedidos WHERE foliopedido = iFolioPedido) AS tb2;
	
	SELECT porcentajedescuento,garantia INTO iDescto,dGarantia FROM ctl_pedidos WHERE foliopedido = iFolioPedido;
	
	IF (iDescto > 0 )THEN
		dTotalPedido = ((dTotalPedido * (100 - iDescto))/100)::DECIMAL(18);
	END IF;

	SELECT SUM(monto)::DECIMAL(18) INTO dTotalAbono FROM ctl_abonospagos WHERE foliopedido = iFolioPedido;
	
	IF (dGarantia > 0 AND NOT EXISTS (SELECT 1 FROM ctl_cortegarantias WHERE foliopedido = iFolioPedido)) THEN
		PERFORM fn_pedidos_update(iFolioPedido,3);
		iRetorno = 1;
	ELSEIF ((dTotalAbono >= dTotalPedido) AND (SELECT COUNT(*) FROM mae_articulospedidos WHERE foliopedido = iFolioPedido)= 0) THEN
		RAISE NOTICE '4';
		PERFORM fn_pedidos_update(iFolioPedido,4);
		iRetorno = 1;
	ELSE
		RAISE NOTICE '3';
		PERFORM fn_pedidos_update(iFolioPedido,3);
		iRetorno = 1;
	END IF;
	
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_unarticulopedidohist_insert(BIGINT,BIGINT,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_unarticulopedidohist_insert(BIGINT,BIGINT,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_unarticulopedidohist_insert(BIGINT,BIGINT,INTEGER) FROM public;



-- Function: fn_articulospedidoshist_insert
CREATE OR REPLACE FUNCTION fn_articulospedidoshist_insert(iFolioPedido BIGINT)
  RETURNS SETOF typ_mae_articulospedidos2 AS
$BODY$
DECLARE
	rDatos 	typ_mae_articulospedidos2;
	dTotalAbono		DECIMAL DEFAULT 0;
	dTotalPedido 	DECIMAL DEFAULT 0;
	dGarantia	 	DECIMAL DEFAULT 0;
	iDescto			INTEGER DEFAULT 0;
BEGIN
	FOR rDatos IN  	SELECT foliopedido,id_articulo,descripcion,SUM(cantidad),SUM(precio),flag_especial,horasrenta,flag_rentado
			FROM mae_articulospedidos  WHERE foliopedido = iFolioPedido GROUP BY foliopedido,id_articulo,descripcion,flag_especial,horasrenta,flag_rentado
	LOOP
		INSERT INTO mae_articulospedidoshist(foliopedido,id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,flag_rentado)
		SELECT rDatos.foliopedido,rDatos.id_articulo,rDatos.descripcion,rDatos.cantidad,rDatos.precio,rDatos.flag_especial,rDatos.horasrenta,rDatos.flag_rentado;

		--IF FOUND THEN
		--	UPDATE ctl_inventario SET cantidad = cantidad + rDatos.cantidad WHERE id_articulo = rDatos.id_articulo;
		
		IF FOUND THEN
			DELETE FROM mae_articulospedidos WHERE foliopedido = iFolioPedido AND id_articulo = rDatos.id_articulo;
			--PERFORM fn_pedidos_update(iFolioPedido,4);
			
			RETURN NEXT rDatos;
		END IF;

		
		--END IF;		
	END LOOP;

	SELECT SUM(totalpedido)::DECIMAL(18) INTO dTotalPedido FROM 
	(SELECT COALESCE(SUM(precio),0)AS totalpedido FROM mae_articulospedidos WHERE foliopedido = iFolioPedido
	UNION ALL
	SELECT COALESCE(SUM(precio),0) AS totalpedido FROM mae_articulospedidoshist WHERE foliopedido = iFolioPedido
	UNION ALL
	SELECT COALESCE(SUM(flete),0) AS totalpedido FROM ctl_pedidos WHERE foliopedido = iFolioPedido) AS tb2;
	
	SELECT porcentajedescuento,garantia INTO iDescto,dGarantia FROM ctl_pedidos WHERE foliopedido = iFolioPedido;
	
	IF (iDescto > 0 )THEN
		dTotalPedido = ((dTotalPedido * (100 - iDescto))/100)::DECIMAL(18);
	END IF;
	
	SELECT SUM(monto)::DECIMAL(18) INTO dTotalAbono FROM ctl_abonospagos WHERE foliopedido = iFolioPedido;
	
	IF (dGarantia > 0 AND NOT EXISTS (SELECT 1 FROM ctl_cortegarantias WHERE foliopedido = iFolioPedido)) THEN
		PERFORM fn_pedidos_update(iFolioPedido,3);
	ELSEIF ((dTotalAbono >= dTotalPedido) AND (SELECT COUNT(*) FROM mae_articulospedidos WHERE foliopedido = iFolioPedido)= 0) THEN
		RAISE NOTICE '4';
		PERFORM fn_pedidos_update(iFolioPedido,4);
		--iRetorno = 1;
	ELSE
		RAISE NOTICE '3';
		PERFORM fn_pedidos_update(iFolioPedido,3);
		--iRetorno = 1;
	END IF;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articulospedidoshist_insert(BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articulospedidoshist_insert(BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_articulospedidoshist_insert(BIGINT) FROM public;


--DROP TYPE typ_inventario2;
CREATE TYPE typ_inventario2 AS (
	id_articulo bigint,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta INTEGER,
	nom_grupo	VARCHAR
);


-- Function: fn_invent_select
--DROP FUNCTION fn_invent_select(SMALLINT);
CREATE OR REPLACE FUNCTION fn_invent_select(vFlagRentado SMALLINT)
  RETURNS SETOF typ_inventario2 AS
$BODY$
DECLARE
	rDatos typ_inventario2;
	iArticulosRentados INTEGER DEFAULT 0;
	iGrupo BIGINT DEFAULT 0;
BEGIN
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,'' FROM ctl_inventario 
	LOOP
		SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
		WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido::DATE = NOW()::DATE) 
		AND id_articulo = rDatos.id_articulo
		AND flag_rentado = vFlagRentado::INTEGER;
		
		rDatos.cantidad = rDatos.cantidad - iArticulosRentados;
		
		IF (rDatos.cantidad <= 0) THEN
			rDatos.cantidad = 0;
		END IF;
		
		SELECT COALESCE(id_grupo,0) INTO iGrupo FROM ctl_grupoinventario WHERE id_articulo = rDatos.id_articulo;
		iGrupo = COALESCE(iGrupo,0);
		IF (iGrupo > 0) THEN
			SELECT COALESCE(nombregrupo,'') INTO rDatos.nom_grupo FROM cat_grupoinventario WHERE id_grupo = iGrupo;
		END IF;
		
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_invent_select(SMALLINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_invent_select(SMALLINT) TO postgres;
REVOKE ALL ON FUNCTION fn_invent_select(SMALLINT) FROM public;


-- Function: fn_invent_select
--DROP FUNCTION fn_invent_select();
CREATE OR REPLACE FUNCTION fn_invent_select()
  RETURNS SETOF typ_inventario2 AS
$BODY$
DECLARE
	rDatos typ_inventario2;
	iGrupo BIGINT DEFAULT 0;
BEGIN
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta,'' FROM ctl_inventario 
	LOOP
		SELECT COALESCE(id_grupo,0) INTO iGrupo FROM ctl_grupoinventario WHERE id_articulo = rDatos.id_articulo;
		iGrupo = COALESCE(iGrupo,0);
		IF (iGrupo > 0) THEN
			SELECT COALESCE(nombregrupo,'') INTO rDatos.nom_grupo FROM cat_grupoinventario WHERE id_grupo = iGrupo;
		END IF;
		RETURN NEXT rDatos;
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_invent_select()
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_invent_select() TO postgres;
REVOKE ALL ON FUNCTION fn_invent_select() FROM public;


-- Function: fn_ctl_grupoinventario_insert
CREATE OR REPLACE FUNCTION fn_ctl_grupoinventario_insert(idArticulo BIGINT,idGrupo BIGINT)
  RETURNS INTEGER AS
$BODY$
DECLARE
	iRetorno 	INTEGER DEFAULT 0;
BEGIN
	IF NOT EXISTS (SELECT 1 FROM ctl_grupoinventario WHERE id_articulo = idArticulo ) THEN
		INSERT INTO ctl_grupoinventario (id_articulo,id_grupo) 
		SELECT idArticulo,idGrupo;
		IF FOUND THEN
			iRetorno = 1;
		END IF;
	ELSE
		UPDATE ctl_grupoinventario SET id_articulo = idArticulo,id_grupo = idGrupo 
		WHERE id_articulo = idArticulo;
		IF FOUND THEN
			iRetorno = 1;
		END IF;
	END IF;
	RETURN iRetorno;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_ctl_grupoinventario_insert(BIGINT,BIGINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_ctl_grupoinventario_insert(BIGINT,BIGINT) TO postgres;
REVOKE ALL ON FUNCTION fn_ctl_grupoinventario_insert(BIGINT,BIGINT) FROM public;



--DROP TYPE typ_reportegrupoinventario;
CREATE TYPE typ_reportegrupoinventario AS 
(	
foliopedido	BIGINT,
descripcion VARCHAR
);

CREATE OR REPLACE FUNCTION fn_articulosdegrupoinventario_select(dFechaInicio DATE,dFechaFin DATE)
  RETURNS SETOF typ_reportegrupoinventario AS
$BODY$
DECLARE
	iRetorno 		INTEGER DEFAULT 0;
	bFolioPedido 	BIGINT 	DEFAULT 0;
	vTexto	 	TEXT 	DEFAULT '';
	rRecord		VARCHAR DEFAULT '';
	rDatosSalida typ_reportegrupoinventario;
BEGIN
	FOR bFolioPedido IN SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido BETWEEN dFechaInicio AND dFechaFin
	
	LOOP
		vTexto = '';
		FOR rRecord IN 	SELECT cantidad|| ' ' ||UPPER(descripcion) || ' ' || COALESCE(UPPER(trim(horasrenta)),'') FROM mae_articulospedidos AS pedido
						INNER JOIN ctl_grupoinventario AS gpo ON (pedido.id_articulo = gpo.id_articulo)
						WHERE foliopedido = bFolioPedido 
						AND gpo.id_grupo > 0
		LOOP
			vTexto := vTexto ||' '|| rRecord::VARCHAR ||','; 
		END LOOP;
		
		IF vTexto = '' THEN
			CONTINUE;
		END IF;
		
		rDatosSalida.foliopedido = bFolioPedido;
		rDatosSalida.descripcion = UPPER(substring(vTexto,0,length(vTexto)));
		
		RETURN NEXT rDatosSalida;
		
	END LOOP;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_articulosdegrupoinventario_select(DATE,DATE)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_articulosdegrupoinventario_select(DATE,DATE) TO postgres;
REVOKE ALL ON FUNCTION fn_articulosdegrupoinventario_select(DATE,DATE) FROM public;
