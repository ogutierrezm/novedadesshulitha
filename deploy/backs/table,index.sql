
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


-- DROP TABLE ctl_abonospagos;
CREATE TABLE ctl_abonospagos(
	foliopedido 	BIGINT,
	monto		DECIMAL,
	fechaabono	TIMESTAMP DEFAULT NOW(),
	montoantesoperacion	DECIMAL
);

--DROP INDEX ctl_abonospagos_foliopedido;
CREATE INDEX ctl_abonospagos_foliopedido ON ctl_abonospagos(foliopedido);


--DROP TYPE typ_ctl_abonospagos;
CREATE TYPE typ_ctl_abonospagos AS (
	foliopedido 	BIGINT,
	monto		DECIMAL,
	fechaabono	TIMESTAMP,
	montoantesoperacion	DECIMAL
);

-- DROP TABLE cat_estatuspedido;
CREATE TABLE cat_estatuspedido(
	keyx 		serial,
	descripcion 	VARCHAR,
	PRIMARY KEY (keyx)
);

INSERT INTO cat_estatuspedido (descripcion) SELECT 'TOMADO';
INSERT INTO cat_estatuspedido (descripcion) SELECT 'SURTIDO';
INSERT INTO cat_estatuspedido (descripcion) SELECT 'ALGO PENDIENTE';
INSERT INTO cat_estatuspedido (descripcion) SELECT 'FINALIZADO';
INSERT INTO cat_estatuspedido SELECT 99,'ELIMINADO';


-- DROP TABLE mae_articulospedidos;
CREATE TABLE mae_articulospedidos(
	keyx bigserial NOT NULL,
	foliopedido bigint,
	id_articulo bigint,
	descripcion character varying,
	cantidad integer,
	precio numeric,
	flag_especial integer,
	horasrenta character varying,
	flag_rentado integer DEFAULT 0
);

--DROP INDEX mae_articulospedidos_keyx;
CREATE INDEX mae_articulospedidos_keyx ON mae_articulospedidos(keyx);

--DROP INDEX mae_articulospedidos_foliopedido;
CREATE INDEX mae_articulospedidos_foliopedido ON mae_articulospedidos(foliopedido);

--DROP INDEX mae_articulospedidos_id_articulo ON mae_articulospedidos(id_articulo);
CREATE INDEX mae_articulospedidos_id_articulo ON mae_articulospedidos(id_articulo);

-- DROP TABLE mae_articulospedidoshist;
CREATE TABLE mae_articulospedidoshist(
	keyx 		BIGSERIAL,
	foliopedido 	BIGINT,
	id_articulo	BIGINT,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta VARCHAR
);


--DROP INDEX mae_articulospedidoshist_id_articulo ON mae_articulospedidoshist(id_articulo);
CREATE INDEX mae_articulospedidoshist_id_articulo ON mae_articulospedidoshist(id_articulo);

--DROP INDEX mae_articulospedidoshist_keyx;
CREATE INDEX mae_articulospedidoshist_keyx ON mae_articulospedidoshist(keyx);

--DROP INDEX mae_articulospedidoshist_foliopedido;
CREATE INDEX mae_articulospedidoshist_foliopedido ON mae_articulospedidoshist(foliopedido);

--DROP TABLE ctl_inventario;
CREATE TABLE ctl_inventario(
	id_articulo BIGSERIAL,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta INTEGER
);

--DROP INDEX ctl_inventario_id_articulo;
CREATE INDEX ctl_inventario_id_articulo ON ctl_inventario(id_articulo);


--DROP INDEX ctl_inventario_descripcion;
CREATE INDEX ctl_inventario_descripcion ON ctl_inventario(descripcion);


--DROP TYPE typ_inventario;
CREATE TYPE typ_inventario AS (
	id_articulo bigint,
	descripcion VARCHAR,
	cantidad INTEGER,
	precio DECIMAL,
	flag_especial INTEGER,
	horasrenta INTEGER
);

-- DROP TABLE mae_direccionpedidos;
CREATE TABLE mae_direccionpedidos(
	keyx 		BIGSERIAL,
	calle		VARCHAR,
	numinterior	VARCHAR,
	numexterior	VARCHAR,
	colonia		VARCHAR,
	codigopostal	INTEGER,
	entrecalles	VARCHAR,
	observaciones	VARCHAR,
	estado		VARCHAR,
	ciudad		VARCHAR,
	PRIMARY KEY (keyx)
);
--DROP TABLE cat_direcciones;
CREATE TABLE cat_direcciones(
	d_codigo 	INTEGER,
	d_asenta 	VARCHAR,
	d_tipo_asenta	VARCHAR,
	d_mnpio		VARCHAR,
	d_estado	VARCHAR,
	d_ciudad	VARCHAR,
	d_CP		INTEGER,
	c_estado	INTEGER,
	c_oficina	INTEGER,
	c_tipo_asenta	INTEGER,
	c_mnpio		INTEGER,
	id_asenta_cpcons INTEGER,
	d_zona		VARCHAR,
	c_cve_ciudad	VARCHAR,
	c_CP		VARCHAR
);

--DROP INDEX cat_direcciones_d_codigo;
CREATE INDEX cat_direcciones_d_codigo ON cat_direcciones(d_codigo);
--DROP INDEX cat_direcciones_d_asenta;
CREATE INDEX cat_direcciones_d_asenta ON cat_direcciones(d_asenta);




-- DROP TABLE cat_regiones;
CREATE TABLE cat_regiones(
	id_region 	BIGSERIAL,
	nombreregion 	VARCHAR,
	descregion 	VARCHAR,
	PRIMARY KEY(id_region)
);

--DROP INDEX cat_regiones_id_region; 
CREATE INDEX cat_regiones_id_region ON cat_regiones (id_region);

--DROP INDEX cat_regiones_nombreregion; 
CREATE INDEX cat_regiones_nombreregion ON cat_regiones (nombreregion);

-- DROP TABLE ctl_regiones;
CREATE TABLE ctl_regiones(
	keyx		BIGSERIAL,
	id_region 	BIGINT,
	keyxdir		BIGINT,
	PRIMARY KEY(id_region,keyxdir)
);

--DROP INDEX ctl_regiones_id_region; 
CREATE INDEX ctl_regiones_id_region ON ctl_regiones (id_region);
--DROP INDEX ctl_regiones_keyx; 
CREATE INDEX ctl_regiones_keyx ON ctl_regiones (keyx);


CREATE TABLE mae_clientes(
	keyx 		BIGSERIAL,
	nombres		VARCHAR,
	apellidos	VARCHAR,
	telcasa		VARCHAR,
	telcelular	VARCHAR,
	PRIMARY KEY (keyx,nombres,apellidos,telcasa,telcelular)
);
ALTER TABLE mae_clientes  DROP CONSTRAINT mae_clientes_pkey;
ALTER TABLE mae_clientes  ADD PRIMARY KEY (keyx,nombres,apellidos,telcasa,telcelular);

--DROP INDEX mae_clientes_telcasa;
CREATE INDEX mae_clientes_telcasa ON mae_clientes(telcasa);

--DROP INDEX mae_clientes_telcelular;
CREATE INDEX mae_clientes_telcelular ON mae_clientes(telcelular);

--DROP INDEX mae_clientes_keyx;
CREATE INDEX mae_clientes_keyx ON mae_clientes(keyx);


--DROP TABLE cat_usuarios;
CREATE TABLE cat_usuarios(
	id_puesto serial,
	puesto VARCHAR,
	permisos VARCHAR
);

CREATE INDEX cat_usuarios_id_puesto ON cat_usuarios (id_puesto); 

INSERT INTO cat_usuarios (puesto,permisos)  SELECT 'administrador','1,2,3,4,5,6';
INSERT INTO cat_usuarios (puesto,permisos)  SELECT 'empleado','1,2,3,4';


--DROP TABLE ctl_usuarios;
CREATE TABLE ctl_usuarios(
	id_puesto integer,
	keyx serial,
	usuario VARCHAR,
	pwd VARCHAR,
	nombre VARCHAR
);
-- DROP INDEX ctl_usuarios_id_puesto;
CREATE INDEX ctl_usuarios_id_puesto ON ctl_usuarios (id_puesto); 

-- DROP INDEX ctl_usuarios_id_puesto_keyx;
CREATE INDEX ctl_usuarios_id_puesto_keyx ON ctl_usuarios (id_puesto,keyx); 

INSERT INTO ctl_usuarios SELECT 1,1,'antonio',MD5('antonio'),'jesus antonio bastidas lopez';
INSERT INTO ctl_usuarios SELECT 2,2,'fernando',MD5('antonio'),'fernando garza de la garza';

ALTER SEQUENCE ctl_usuarios_keyx_seq RESTART WITH 3;


-- Table: ctl_pedidos
-- DROP TABLE ctl_pedidos;
CREATE TABLE ctl_pedidos
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
  CONSTRAINT ctl_pedidos_pkey PRIMARY KEY (foliopedido)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ctl_pedidos
  OWNER TO postgres;

--DROP INDEX ctl_pedidos_foliopedido_fechamovimiento;
CREATE INDEX ctl_pedidos_foliopedido_fechamovimiento ON ctl_pedidos (foliopedido,fechamovimiento);
  
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
  CONSTRAINT track_ctl_pedidos_pkey PRIMARY KEY (foliopedido)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE track_ctl_pedidos
  OWNER TO postgres;

  
  
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
