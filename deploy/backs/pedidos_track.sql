-- Table: track_ctl_pedidos
-- DROP TABLE track_ctl_pedidos;
CREATE TABLE track_ctl_pedidos
(
  foliopedido bigserial NOT NULL,
  clientekeyx bigint,
  direccionpedidokeyx bigint,
  articulopedidokeyx bigint,
  fechamovimiento timestamp without time zone DEFAULT now(),
  fechaentregapedido date DEFAULT (now())::date,
  fechavueltapedido date DEFAULT (now())::date,
  flag_recogermismodia integer,
  notahoraentrega character varying,
  notahorarecoger character varying,
  estatuspedido integer,
  empleado integer,
  manteleria character varying DEFAULT ''::character varying,
  flete numeric(18,0) DEFAULT 0,
  flag_iva integer DEFAULT 0,
  flag_descuento integer DEFAULT 0,
  porcentajedescuento integer DEFAULT 0,
  articulospendientes character varying DEFAULT ''::character varying,
  garantia integer DEFAULT 0,
  secuenciamodificacion	INTEGER DEFAULT 0,
  CONSTRAINT track_ctl_pedidos_foliopedido_secuenciamodificacion PRIMARY KEY (foliopedido,secuenciamodificacion)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE track_ctl_pedidos
  OWNER TO postgres;

--DROP INDEX track_ctl_pedidos_foliopedido;
CREATE INDEX track_ctl_pedidos_foliopedido ON track_ctl_pedidos(foliopedido);  
  
-- DROP TABLE track_mae_articulospedidos;
CREATE TABLE track_mae_articulospedidos(
	keyx bigserial NOT NULL,
	foliopedido bigint,
	id_articulo bigint,
	descripcion character varying,
	cantidad integer,
	precio numeric,
	flag_especial integer,
	horasrenta character varying,
	flag_rentado integer DEFAULT 0,
	secuenciamodificacion INTEGER DEFAULT 0
);

--DROP INDEX track_mae_articulospedidos_keyx;
CREATE INDEX track_mae_articulospedidos_keyx ON track_mae_articulospedidos(keyx);

--DROP INDEX track_mae_articulospedidos_foliopedido;
CREATE INDEX track_mae_articulospedidos_foliopedido ON track_mae_articulospedidos(foliopedido);

--DROP INDEX track_mae_articulospedidos_id_articulo ON mae_articulospedidos(id_articulo);
CREATE INDEX track_mae_articulospedidos_id_articulo ON track_mae_articulospedidos(id_articulo);

--DROP INDEX track_mae_articulospedidos_foliopedido_secuenciamodificacion;
CREATE INDEX track_mae_articulospedidos_foliopedido_secuenciamodificacion ON track_mae_articulospedidos(foliopedido,secuenciamodificacion);


--Graba el pedido que se va a trackear.
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
	
	SELECT COUNT(1) + 1 INTO iSecuencia FROM track_ctl_pedidos WHERE foliopedido = iReturn;

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


--DROP TYPE typ_ctl_pedidos_modificados;
CREATE TYPE typ_ctl_pedidos_modificados AS(
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
	garantia			INTEGER,
	secuenciamodificacion INTEGER
);

--DROP TYPE typ_pedidospendiente2_modificados;
CREATE TYPE typ_pedidospendiente2_modificados AS(
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
	garantia			INTEGER,
	secuenciamodificacion INTEGER
);


-- Function: fn_pedidostodosmodificados_select
-- DROP FUNCTION fn_pedidostodosmodificados_select();

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