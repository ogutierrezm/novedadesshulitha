<?PHP

$vQuery = '
/*ALTER TABLE ctl_abonospagos ADD COLUMN recibio VARCHAR DEFAULT "";
ALTER TABLE ctl_pedidos ADD COLUMN manteleria VARCHAR DEFAULT "";
ALTER TABLE ctl_pedidos ADD COLUMN flete DECIMAL(18) DEFAULT 0;
ALTER TABLE ctl_pedidos ADD COLUMN flag_iva INTEGER DEFAULT 0;
ALTER TABLE mae_articulospedidos ADD COLUMN flag_rentado INTEGER DEFAULT 0;
ALTER TABLE mae_articulospedidoshist ADD COLUMN flag_rentado INTEGER DEFAULT 0;
ALTER TABLE cat_direcciones ADD COLUMN keyx BIGSERIAL;
*/


DROP FUNCTION fn_user_insert(INTEGER,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION fn_user_update(INTEGER,INTEGER,VARCHAR,VARCHAR,VARCHAR);
--DROP FUNCTION fn_user_delete(VARCHAR);
DROP FUNCTION fn_user_select(INTEGER);
DROP FUNCTION fn_user_select();
DROP FUNCTION fn_user_select(VARCHAR,VARCHAR,INTEGER);
DROP FUNCTION fn_cat_user_select();
DROP FUNCTION fn_ctl_regiones_insert(BIGINT,BIGINT);
DROP FUNCTION fn_ctl_regionunazona_delete(BIGINT);
DROP FUNCTION fn_ctl_regiones_delete(BIGINT);
DROP FUNCTION fn_ctl_regiones_update(BIGINT,BIGINT);
DROP FUNCTION fn_ctl_regiones_update(BIGINT,BIGINT,BIGINT);
DROP FUNCTION fn_ctl_regiones_select();
DROP FUNCTION fn_cat_regiones_insert(VARCHAR,VARCHAR);
DROP FUNCTION fn_cat_regiones_delete(BIGINT);
DROP FUNCTION fn_cat_regiones_update(BIGINT,VARCHAR,VARCHAR);
--DROP FUNCTION fn_cat_regiones_select();
DROP FUNCTION fn_cat_regiones_select();
--DROP FUNCTION fn_cat_regiones_update(BIGINT,VARCHAR);
--DROP FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL);
DROP FUNCTION fn_abonospagos_insert(BIGINT,DECIMAL,VARCHAR);
DROP FUNCTION fn_abonospagos_select(BIGINT);
DROP FUNCTION fn_pedidos_update(BIGINT,BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER);
DROP FUNCTION fn_pedidos_update(BIGINT,INTEGER);
--DROP FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER);
--DROP FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL);
DROP FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER);
--DROP FUNCTION fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL);
DROP FUNCTION fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER);
DROP FUNCTION fn_pedidospendientesmes_select();
DROP FUNCTION fn_pedidos_delete(BIGINT);
DROP FUNCTION fn_pedidosarticulospendientes_select(BIGINT);
DROP FUNCTION fn_pedidosabonado_select();
DROP FUNCTION fn_pedidospendientes_select(bFolioPedido BIGINT);
DROP FUNCTION fn_pedidospendientes_select();
DROP FUNCTION fn_pedidos_select(BIGINT);
DROP FUNCTION fn_importepedido_select(BIGINT);
DROP FUNCTION fn_articulospedidos_select(BIGINT);
DROP FUNCTION fn_articulospedidosrentado_insert(BIGINT,BIGINT,INTEGER,VARCHAR,INTEGER);
DROP FUNCTION fn_articulospedidos_insert(BIGINT,BIGINT,INTEGER,VARCHAR);
DROP FUNCTION fn_articulospedidoshist_insert(BIGINT,BIGINT,INTEGER);
DROP FUNCTION fn_articulospedidoshist_insert(BIGINT);
DROP FUNCTION fn_articulosxmodificacion_delete(BIGINT);
DROP FUNCTION fn_unarticulopedidohist_insert(BIGINT,BIGINT,INTEGER);
DROP FUNCTION fn_inventespecial_select(BIGINT);
DROP FUNCTION fn_invent_delete(BIGINT);
DROP FUNCTION fn_invent_update(BIGINT,VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER);
DROP FUNCTION fn_invent_insert(VARCHAR,INTEGER,DECIMAL,INTEGER,INTEGER);
DROP FUNCTION fn_invent_select(SMALLINT);
DROP FUNCTION fn_invent_select();
DROP FUNCTION fn_inventrentadopordia_select(BIGINT,INTEGER,DATE,BIGINT);
DROP FUNCTION fn_inventrentadopordia_select(BIGINT,INTEGER,DATE);
DROP FUNCTION fn_inventrentado_select(BIGINT,INTEGER);
DROP FUNCTION fn_invent_select(BIGINT);
DROP FUNCTION fn_invent_select(VARCHAR);
DROP FUNCTION fn_direccionpedidoscliente_select(BIGINT);
DROP FUNCTION fn_direccionpedidos_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR,INTEGER,VARCHAR,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION fn_direccionpedidos_select(BIGINT);
DROP FUNCTION fn_dir_select(INTEGER,bigint);
DROP FUNCTION fn_dir_select(INTEGER,VARCHAR);
DROP FUNCTION fn_cte_delete(BIGINT);
DROP FUNCTION fn_cte_insert(VARCHAR,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION fn_cte_update(BIGINT,VARCHAR,VARCHAR,VARCHAR,VARCHAR);
DROP FUNCTION fn_cte_select(VARCHAR);
DROP FUNCTION fn_cte_select(BIGINT);


DROP TYPE typ_pedidospendiente;
DROP TYPE typ_foliosmes;
DROP TYPE typ_pedidospendiente2;
DROP TYPE typ_ctl_pedidos;
DROP TYPE typ_mae_articulospedidos;
DROP TYPE typ_mae_articulospedidos2;
DROP TYPE typ_inventespecial;
DROP TYPE typ_mae_direccionpedidos;
DROP TYPE typ_direcciones;
DROP TYPE typ_cat_regiones;
DROP TYPE typ_ctl_regiones;
DROP TYPE typ_mae_clientes;
DROP TYPE typ_cat_usuarios;
DROP TYPE typ_usuario;



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
	iva					INTEGER
);
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
	iva					INTEGER
);
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

CREATE OR REPLACE FUNCTION fn_abonospagos_insert(bFolioPedido BIGINT,dMonto DECIMAL,vRecibio VARCHAR)
  RETURNS DECIMAL AS
$BODY$
DECLARE
	iReturn 	DECIMAL DEFAULT 0; --DEVUELVE LA FERIA DEL CLIENTE
	dTotal	 	DECIMAL DEFAULT 0;
	dIVA	 	DECIMAL DEFAULT 0;
	dMontoAbonado 	DECIMAL DEFAULT 0;
BEGIN
	SELECT COALESCE(SUM(flete),0),flag_iva INTO dTotal,dIVA FROM ctl_pedidos WHERE foliopedido = bFolioPedido;
	SELECT COALESCE(SUM(precio),0)+ dTotal INTO dTotal FROM mae_articulospedidos WHERE foliopedido = bFolioPedido;
	SELECT COALESCE(SUM(precio),0)+ dTotal INTO dTotal FROM mae_articulospedidoshist WHERE foliopedido = bFolioPedido;
	SELECT COALESCE(SUM(monto),0)+ dMonto INTO dMontoAbonado FROM ctl_abonospagos WHERE foliopedido = bFolioPedido;
	
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
	IF (SELECT COUNT(1) FROM mae_articulospedidos WHERE foliopedido = bFolioPedido) > 0 THEN
		PERFORM fn_pedidos_update(bFolioPedido,3);
	ELSEIF (dMontoAbonado >= dTotal) THEN
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

CREATE OR REPLACE FUNCTION fn_pedidos_insert(	iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT,iArticulopedidokeyx BIGINT,
						tFechaentregapedido DATE,tFechavueltapedido DATE,iFlag_recogermismodia INTEGER,
						vNotahoraentrega VARCHAR,vNotahorarecoger VARCHAR,iEstatuspedido INTEGER,iEmpleado INTEGER,vManteleria VARCHAR,dFlete DECIMAL, iIVA INTEGER)
  RETURNS BIGINT AS
$BODY$
DECLARE
	iReturn BIGINT DEFAULT 0;
BEGIN
	iReturn = iArticulopedidokeyx;
	INSERT INTO ctl_pedidos (foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
				 notahoraentrega,notahorarecoger,estatuspedido,empleado,manteleria,flete,flag_iva)
	SELECT iReturn,iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
				vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIVA;
	IF NOT FOUND THEN
		iReturn = 0;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidos_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER) FROM public;

CREATE OR REPLACE FUNCTION fn_pedidosmodificados_insert(	iClientekeyx BIGINT,iDireccionpedidokeyx BIGINT,iArticulopedidokeyx BIGINT,
						tFechaentregapedido DATE,tFechavueltapedido DATE,iFlag_recogermismodia INTEGER,
						vNotahoraentrega VARCHAR,vNotahorarecoger VARCHAR,iEstatuspedido INTEGER,iEmpleado INTEGER,vManteleria VARCHAR,dFlete DECIMAL,iIva INTEGER)
  RETURNS BIGINT AS
$BODY$
DECLARE
	iReturn BIGINT DEFAULT 0;
BEGIN
	iReturn = iArticulopedidokeyx;
	
	DELETE FROM ctl_pedidos WHERE foliopedido = iReturn;
	
	IF FOUND THEN
		INSERT INTO ctl_pedidos (foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechaentregapedido,fechavueltapedido,flag_recogermismodia,
					 notahoraentrega,notahorarecoger,estatuspedido,empleado,manteleria,flete,flag_iva)
		SELECT iReturn,iClientekeyx,iDireccionpedidokeyx,iArticulopedidokeyx,tFechaentregapedido,tFechavueltapedido,iFlag_recogermismodia,
					vNotahoraentrega,vNotahorarecoger,iEstatuspedido,iEmpleado,vManteleria,dFlete,iIva;
		IF NOT FOUND THEN
			iReturn = 0;
		END IF;
	END IF;
	RETURN iReturn;
END;	
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;
ALTER FUNCTION fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER) TO postgres;
REVOKE ALL ON FUNCTION fn_pedidosmodificados_insert(BIGINT,BIGINT,BIGINT,DATE,DATE,INTEGER,VARCHAR,VARCHAR,INTEGER,INTEGER,VARCHAR,DECIMAL,INTEGER) FROM public;


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


-- Function: fn_pedidos_select
CREATE OR REPLACE FUNCTION fn_pedidos_select(bClienteKeyx BIGINT)
  RETURNS SETOF typ_ctl_pedidos AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,notahoraentrega,notahorarecoger,estatuspedido,empleado,flete,UPPER(manteleria),flag_iva
			FROM ctl_pedidos WHERE clientekeyx = bClienteKeyx
	LOOP
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


-- Function: fn_pedidospendientes_select 
CREATE OR REPLACE FUNCTION fn_pedidospendientes_select()
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT '."''".';
	rRecord		VARCHAR DEFAULT  '."''".';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,UPPER(manteleria),flag_iva
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
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||" - x","-",1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||" - x","-",1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		
		vTexto =  '."''".';
		FOR rRecord IN SELECT COALESCE(UPPER(trim(horasrenta)), '."''".')||  '."' '".' || cantidad||  '."' '".' ||UPPER(descripcion) FROM mae_articulospedidos WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto || '."' '".'|| rRecord::VARCHAR || '."','".'; 
		END LOOP;

		rDatosSalida.detallepedido = substring(vTexto,0,length(vTexto));
		
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

-- Function: fn_pedidospendientes_select
CREATE OR REPLACE FUNCTION fn_pedidospendientes_select(bFolioPedido BIGINT)
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT  '."''".';
	--rRecord		VARCHAR DEFAULT "";
BEGIN
		SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,fechavueltapedido,flag_recogermismodia,notahoraentrega,notahorarecoger,estatuspedido,empleado,flete,UPPER(manteleria),flag_iva
		INTO 	rDatos.foliopedido,rDatos.clientekeyx,rDatos.direccionpedidokeyx,rDatos.articulopedidokeyx,rDatos.fechamovimiento,rDatos.fechaentregapedido,rDatos.fechavueltapedido,rDatos.flag_recogermismodia,rDatos.notahoraentrega,rDatos.notahorarecoger,rDatos.estatuspedido,rDatos.empleado,rDatos.flete,rDatos.manteleria,rDatos.iva
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
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,UPPER(mae.colonia),UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||" - x","-",1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||" - x","-",1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
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

-- Function: fn_pedidosabonado_select
CREATE OR REPLACE FUNCTION fn_pedidosabonado_select()
  RETURNS SETOF typ_pedidospendiente2 AS
$BODY$
DECLARE
	rDatos typ_ctl_pedidos;
	rDatosSalida typ_pedidospendiente2;
	iColonia 	BIGINT DEFAULT 0;
	vTexto 		TEXT DEFAULT  '."''".';
	rRecord		VARCHAR DEFAULT  '."''".';
BEGIN
	FOR rDatos IN  	SELECT 	foliopedido,clientekeyx,direccionpedidokeyx,articulopedidokeyx,fechamovimiento,fechaentregapedido,
				fechavueltapedido,flag_recogermismodia,UPPER(notahoraentrega),UPPER(notahorarecoger),estatuspedido,empleado,flete,UPPER(manteleria),flag_iva
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
		
		SELECT UPPER(nombres),UPPER(apellidos),telcasa,telcelular INTO rDatosSalida.nombrecte,rDatosSalida.apellidocte,rDatosSalida.telefonocasa,rDatosSalida.telefonocelular 
		FROM mae_clientes  where keyx =rDatos.clientekeyx;
		
		SELECT UPPER(mae.calle),UPPER(mae.numinterior),UPPER(mae.numexterior),UPPER(mae.observaciones),dir.d_codigo,UPPER(dir.d_asenta)/*UPPER(mae.colonia) */,UPPER(dir.d_mnpio),UPPER(dir.d_estado),UPPER((SPLIT_PART(mae.colonia::VARCHAR||" - x","-",1)))::BIGINT 
		INTO rDatosSalida.calle,rDatosSalida.numint,rDatosSalida.numext,rDatosSalida.referencias,rDatosSalida.codigopostal,rDatosSalida.colonia,rDatosSalida.ciudad,rDatosSalida.estado,iColonia
		FROM mae_direccionpedidos AS mae INNER JOIN cat_direcciones AS dir ON((SPLIT_PART(mae.colonia::VARCHAR||" - x","-",1))::BIGINT = dir.keyx)
		where mae.keyx  = rDatos.direccionpedidokeyx;
		
		SELECT UPPER(nombreregion) INTO rDatosSalida.region FROM ctl_regiones AS ctl INNER JOIN cat_regiones AS cat ON (ctl.id_region = cat.id_region)
		WHERE ctl.keyxdir = iColonia;

		SELECT UPPER(nombre) INTO rDatosSalida.empleado FROM ctl_usuarios WHERE keyx = rDatos.empleado;
		
		SELECT COALESCE(SUM(monto),0)::DECIMAL(18) INTO rDatosSalida.abono FROM ctl_abonospagos WHERE foliopedido = rDatos.foliopedido;

		SELECT * FROM fn_importepedido_select(rDatos.foliopedido) AS retorno INTO rDatosSalida.total;
		
		rDatosSalida.total = rDatosSalida.total::DECIMAL(18) + rDatos.flete::DECIMAL(18);
		
		IF (rDatosSalida.iva = 1) THEN
			rDatosSalida.total = (rDatosSalida.total * 1.16)::DECIMAL(18);
		END IF;
		
		vTexto =  '."''".';
		FOR rRecord IN SELECT COALESCE(UPPER(trim(horasrenta)), '."''".')||  '."' '".' || cantidad||  '."' '".' ||UPPER(descripcion) FROM mae_articulospedidos WHERE foliopedido = rDatos.foliopedido
		LOOP
			vTexto := vTexto || '."' '".'|| rRecord::VARCHAR || '."','".'; 
		END LOOP;

		rDatosSalida.detallepedido = substring(vTexto,0,length(vTexto));
		
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
	dFechaEntregaPedido 	DATE DEFAULT "1900-01-01";
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
	iArticulosDisponibles 	INTEGER DEFAULT 0;
	iArticulosRegresa	 	INTEGER DEFAULT 0;
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

	SELECT SUM(monto)::DECIMAL(18) INTO dTotalAbono FROM ctl_abonospagos WHERE foliopedido = iFolioPedido;
	
	IF ((dTotalAbono >= dTotalPedido) AND (SELECT COUNT(*) FROM mae_articulospedidos WHERE foliopedido = iFolioPedido)= 0) THEN
		PERFORM fn_pedidos_update(iFolioPedido,4);
		iRetorno = 1;
	ELSE
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

	SELECT SUM(monto)::DECIMAL(18) INTO dTotalAbono FROM ctl_abonospagos WHERE foliopedido = iFolioPedido;
	
	IF ((dTotalAbono >= dTotalPedido) AND (SELECT COUNT(*) FROM mae_articulospedidos WHERE foliopedido = iFolioPedido)= 0) THEN
		PERFORM fn_pedidos_update(iFolioPedido,4);
		--iRetorno = 1;
	ELSE
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
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM ctl_inventario WHERE descripcion like vDescripcion ||"%"
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
	FOR rDatos IN 	SELECT inv.id_articulo,inv.descripcion,inv.cantidad,inv.precio,inv.flag_especial,("folio: "|| mae.foliopedido||", "|| mae.horasrenta ||", fecha: " || ped.fechaentregapedido) AS horasrentadas 
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

-- Function: fn_invent_select
CREATE OR REPLACE FUNCTION fn_invent_select()
  RETURNS SETOF typ_inventario AS
$BODY$
DECLARE
	rDatos typ_inventario;
BEGIN
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM ctl_inventario 
	LOOP
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


-- Function: fn_invent_select
CREATE OR REPLACE FUNCTION fn_invent_select(vFlagRentado SMALLINT)
  RETURNS SETOF typ_inventario AS
$BODY$
DECLARE
	rDatos typ_inventario;
	iArticulosRentados INTEGER DEFAULT 0;
BEGIN
	FOR rDatos IN SELECT id_articulo,descripcion,cantidad,precio,flag_especial,horasrenta FROM ctl_inventario 
	LOOP
		SELECT COALESCE(SUM(cantidad),0) INTO iArticulosRentados FROM mae_articulospedidos 
		WHERE foliopedido IN (SELECT foliopedido FROM ctl_pedidos WHERE fechaentregapedido::DATE = NOW()::DATE) 
		AND id_articulo = rDatos.id_articulo
		AND flag_rentado = vFlagRentado::INTEGER;
		
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
ALTER FUNCTION fn_invent_select(SMALLINT)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_invent_select(SMALLINT) TO postgres;
REVOKE ALL ON FUNCTION fn_invent_select(SMALLINT) FROM public;

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
	DELETE FROM ctl_inventario WHERE id_articulo = iId_articulo;

	IF FOUND THEN 
		iReturn = 1;
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
	iColonia = REGEXP_REPLACE(SPLIT_PART(vColonia::VARCHAR||" - x","-",1),"[^0-9]*","0");
	
	IF NOT EXISTS (SELECT 1 FROM cat_direcciones WHERE keyx  = iColonia) THEN
		SELECT NEXTVAL("cat_direcciones_keyx_seq") AS retorno INTO iKeyxCatDir;
				
		INSERT INTO cat_direcciones(d_codigo,d_asenta,d_tipo_asenta,d_mnpio,d_estado,d_ciudad,d_cp,c_estado,c_oficina,c_tipo_asenta,c_mnpio,id_asenta_cpcons,d_zona,c_cve_ciudad,c_cp,keyx)
		SELECT iCodigoPostal,vColonia,'."'AGREGADA POR SISTEMA'".','."'NO ESPECIFICADO'".','."'SINALOA'".','."'NO ESPECIFICADO'".',0,25,0,0,0,0,'."'POR SISTEMA'".','."'02'".','."''".',iKeyxCatDir;
		
		vColonia = iKeyxCatDir || " - " || vColonia || " - " || vCiudad;
	END IF;
	
	SELECT keyx INTO iReturn FROM mae_direccionpedidos WHERE calle = vCalle AND numinterior = vInterior AND numexterior = vExterior
			AND colonia = vColonia AND codigopostal = iCodigoPostal AND estado = vEstado AND ciudad = vCiudad;
			--AND entrecalles = vEntreCalles AND observaciones = vObservaciones
	
	IF (iReturn IS NULL) THEN
		INSERT INTO mae_direccionpedidos (calle,numinterior,numexterior,colonia,codigopostal,entrecalles,observaciones,estado,ciudad)
		SELECT vCalle,vInterior,vExterior,vColonia,iCodigoPostal,vEntreCalles,vObservaciones,vEstado,vCiudad;

		IF FOUND THEN
			 SELECT (CASE WHEN Last_value = 1 THEN (SELECT COUNT (1) FROM mae_direccionpedidos) ELSE Last_value END)::BIGINT INTO iReturn FROM  mae_direccionpedidos_keyx_seq;
		END IF;
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
BEGIN
	FOR bKeyx IN SELECT direccionpedidokeyx FROM fn_pedidos_select(iCliente) GROUP BY direccionpedidokeyx
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
	tSql = '."'SELECT keyx,d_codigo,INITCAP(d_asenta),INITCAP(d_mnpio) FROM cat_direcciones '".';
	IF iCodigo != 0 AND  vColonia != '."''".' THEN
		tSql = tSql || '."'WHERE d_codigo = '".'|| iCodigo ||'."' AND UPPER(d_asenta) LIKE '".' ||vColonia || '.'%"'.';
	ELSIF iCodigo != 0 THEN
		tSql =  tSql || '."'WHERE d_codigo = '".'|| iCodigo;
	ELSIF vColonia != '."''".' THEN
		tSql = tSql || '."'WHERE UPPER(d_asenta) LIKE '".'||vColonia || '.'%"'.';
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
	FOR rDatos IN  SELECT keyx,nombres,apellidos,telcasa,telcelular FROM mae_clientes WHERE (telcasa = vTelefono OR telcelular = vTelefono)
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
	IF NOT EXISTS (SELECT 1 FROM mae_clientes WHERE telcasa = vTelefonoCasa AND telcelular = vTelefonoCelular) THEN
		INSERT INTO mae_clientes(nombres,apellidos,telcasa,telcelular)
		SELECT vNombres,vApellidos,vTelefonoCasa,vTelefonoCelular ;
		IF FOUND THEN
			SELECT (CASE WHEN Last_value = 1 THEN (SELECT COUNT (1) FROM mae_clientes) ELSE Last_value END)::BIGINT INTO iRetorno FROM  mae_clientes_keyx_seq;
		END IF;
	ELSE
		SELECT keyx INTO iRetorno FROM mae_clientes WHERE telcasa = vTelefonoCasa AND telcelular = vTelefonoCelular;
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

-- Function: fn_user_select
CREATE OR REPLACE FUNCTION fn_user_select(cUser VARCHAR,cPwd VARCHAR,cOpcion INTEGER)
  RETURNS SETOF typ_usuario AS
$BODY$
DECLARE
	rDatos typ_usuario;
BEGIN
	SELECT a.keyx,a.id_puesto,a.usuario,a.pwd,a.nombre INTO rDatos.keyx,rDatos.id_puesto,rDatos.usuario,rDatos.pwd,rDatos.nombre 
	FROM ctl_usuarios AS a
	WHERE a.usuario = cUser AND a.pwd = MD5(cPwd);

	SELECT permisos,puesto INTO rDatos.permisos,rDatos.descripcionempleado 
	FROM cat_usuarios 
	WHERE id_puesto = rDatos.id_puesto ;--AND cOpcion = ANY (permisos::int[]);
	
	IF (rDatos.permisos::VARCHAR = '."''".' OR rDatos.permisos::VARCHAR = null ) THEN
		rDatos.permisos = '."''".';
	END IF;
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
	
	FOR rDatos IN 	SELECT a.keyx,a.id_puesto,a.usuario,a.pwd,a.nombre FROM ctl_usuarios AS a ORDER BY a.keyx
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
	
	FOR rDatos IN 	SELECT a.keyx,a.id_puesto,a.usuario,a.pwd,a.nombre FROM ctl_usuarios AS a WHERE a.keyx = iKeyx
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
CREATE OR REPLACE FUNCTION fn_user_delete(iKeyx integer)
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
ALTER FUNCTION fn_user_delete(VARCHAR)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_user_delete(VARCHAR) TO postgres;
REVOKE ALL ON FUNCTION fn_user_delete(VARCHAR) FROM public;

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
';
?>