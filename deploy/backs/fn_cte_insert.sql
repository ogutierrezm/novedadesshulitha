-- Function: fn_cte_insert(character varying, character varying, character varying, character varying)

-- DROP FUNCTION fn_cte_insert(character varying, character varying, character varying, character varying);

CREATE OR REPLACE FUNCTION fn_cte_insert(vnombres character varying, vapellidos character varying, vtelefonocasa character varying, vtelefonocelular character varying)
  RETURNS integer AS
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
ALTER FUNCTION fn_cte_insert(character varying, character varying, character varying, character varying)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION fn_cte_insert(character varying, character varying, character varying, character varying) TO postgres;
REVOKE ALL ON FUNCTION fn_cte_insert(character varying, character varying, character varying, character varying) FROM public;
