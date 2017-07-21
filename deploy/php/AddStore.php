<?php
	//require_once("inc/init.php"); 
	include('../conx/constant.php');
	include('Query.php');
	set_time_limit(0);
	$dbconn = pg_pconnect("host=".BD_HOST_TDA." port=".BD_PORT_TDA." dbname=".BD_TDA." user=".BD_USER_TDA." password=".BD_PASSWORD_TDA); //connectionstring
	if (!$dbconn) {
		echo "Can't connect.\n";
		exit;
	}
	print_r($vQuery);
	$res = pg_query($vQuery);
	print_r($res);
/*
$action  = "Export";
$ficheiro=APP_URL.BACKUP_FILE;
switch ($action) {
  case "Export":
  $dbname = BD_TDA; //database name
  $dbconn = pg_pconnect("host=".BD_HOST_TDA." port=".BD_PORT_TDA." dbname=".BD_TDA." user=".BD_USER_TDA." password=".BD_PASSWORD_TDA); //connectionstring
  if (!$dbconn) {
    echo "Can't connect.\n";
  exit;
  }
  date_default_timezone_set("America/Mazatlan");
  $fecha = date("Y.m.d.H.i.s");
  $fileBackup = "./backs/$dbname.$fecha.sql";
  $back = fopen("$fileBackup","w");
  $res = pg_query(" select relname as tablename
                    from pg_class where relkind in ('r')
                    and relname not like 'pg_%' and relname not like 
'sql_%' order by tablename");
  $str="";
  while($row = pg_fetch_row($res))
  {
    $table = $row[0];
    $str .= "\n--\n";
    $str .= "-- Estrutura da tabela '$table'";
    $str .= "\n--\n";
    $str .= "\nDROP TABLE $table CASCADE;";
    $str .= "\nCREATE TABLE $table (";
    $res2 = pg_query("
    SELECT  attnum,attname , typname , atttypmod-4 , attnotnull 
,atthasdef ,adsrc AS def
    FROM pg_attribute, pg_class, pg_type, pg_attrdef WHERE 
pg_class.oid=attrelid
    AND pg_type.oid=atttypid AND attnum>0 AND pg_class.oid=adrelid AND 
adnum=attnum
    AND atthasdef='t' AND lower(relname)='$table' UNION
    SELECT attnum,attname , typname , atttypmod-4 , attnotnull , 
atthasdef ,'' AS def
    FROM pg_attribute, pg_class, pg_type WHERE pg_class.oid=attrelid
    AND pg_type.oid=atttypid AND attnum>0 AND atthasdef='f' AND 
lower(relname)='$table' ");                                             
    while($r = pg_fetch_row($res2))
    {
    $str .= "\n" . $r[1]. " " . $r[2];
     if ($r[2]=="varchar")
    {
    $str .= "(".$r[3] .")";
    }
    if ($r[4]=="t")
    {
    $str .= " NOT NULL";
    }
    if ($r[5]=="t")
    {
    $str .= " DEFAULT ".$r[6];
    }
    $str .= ",";
    }
    $str=rtrim($str, ",");  
    $str .= "\n);\n";
    $str .= "\n--\n";
    $str .= "-- Creating data for '$table'";
    $str .= "\n--\n\n";

    
    $res3 = pg_query("SELECT * FROM $table");
    while($r = pg_fetch_row($res3))
    {
      $sql = "INSERT INTO $table VALUES ('";
      $sql .= utf8_decode(implode("','",$r));
      $sql .= "');";
      $str = str_replace("''","NULL",$str);
      $str .= $sql;  
      $str .= "\n";
    }
    
     $res1 = pg_query("SELECT pg_index.indisprimary,
            pg_catalog.pg_get_indexdef(pg_index.indexrelid)
        FROM pg_catalog.pg_class c, pg_catalog.pg_class c2,
            pg_catalog.pg_index AS pg_index
        WHERE c.relname = '$table'
            AND c.oid = pg_index.indrelid
            AND pg_index.indexrelid = c2.oid
            AND pg_index.indisprimary");
    while($r = pg_fetch_row($res1))
    {
    $str .= "\n\n--\n";
    $str .= "-- Creating index for '$table'";
    $str .= "\n--\n\n";
    $t = str_replace("CREATE UNIQUE INDEX", "", $r[1]);
    $t = str_replace("USING btree", "|", $t);
    // Next Line Can be improved!!!
    $t = str_replace("ON", "|", $t);
    $Temparray = explode("|", $t);
    $str .= "ALTER TABLE ONLY ". $Temparray[1] . " ADD CONSTRAINT " . 
$Temparray[0] . " PRIMARY KEY " . $Temparray[2] .";\n";
    }   
  }
  $res = pg_query(" SELECT
  cl.relname AS tabela,ct.conname,
   pg_get_constraintdef(ct.oid)
   FROM pg_catalog.pg_attribute a
   JOIN pg_catalog.pg_class cl ON (a.attrelid = cl.oid AND cl.relkind = 'r')
   JOIN pg_catalog.pg_namespace n ON (n.oid = cl.relnamespace)
   JOIN pg_catalog.pg_constraint ct ON (a.attrelid = ct.conrelid AND
   ct.confrelid != 0 AND ct.conkey[1] = a.attnum)
   JOIN pg_catalog.pg_class clf ON (ct.confrelid = clf.oid AND 
clf.relkind = 'r')
   JOIN pg_catalog.pg_namespace nf ON (nf.oid = clf.relnamespace)
   JOIN pg_catalog.pg_attribute af ON (af.attrelid = ct.confrelid AND
   af.attnum = ct.confkey[1]) order by cl.relname ");
  while($row = pg_fetch_row($res))
  {
    $str .= "\n\n--\n";
    $str .= "-- Creating relacionships for '".$row[0]."'";
    $str .= "\n--\n\n";
    $str .= "ALTER TABLE ONLY ".$row[0] . " ADD CONSTRAINT " . $row[1] . 
" " . $row[2] . ";";
  }       
  fwrite($back,$str);
  fclose($back);
  /*
  try{
	 // if (enviarMail($fileBackup)){
	 if (enviarMail('postgres.2016.01.14.20.46.43.sql')){
		echo "enviado";
	  }else{
		echo "No enviado";
		
	  }
	}catch (Exception $ex) {
		echo $ex;
	}
	echo "<script lenguaje='javascript' type='text/javascript'> 
		window.open('login.php','_self').close();
		</script>";
  //break;
}
*/


function enviarMail($fileBackup){
	//ini_set('display_errors', 'On');
	//error_reporting(E_ALL);
	$ToName = "Antonio Bastidas";
	$ToMail = "jbastidas86@gmail.com";
	$ToReply = "tonyalfaro_234@hotmail.com";
	$ToSubject = "BackUp $fileBackup";
	$ToMsg = "FYI, contiene backup dia";
	//return mail_attachment($fileBackup,'','jbastidas86@gmail.com',$ToMail,$ToName,$ToReply,$ToSubject,$ToMsg,'','');
	$header = "From: ".$ToName." <".$ToMail.">\r\n";
    $header .= "Reply-To: ".$ToReply."\r\n";
	//return mail($ToMail, $ToSubject, $ToMsg, $header);
	print_r(mail($ToMail, $ToSubject, $ToMsg, $header));
}

function mail_attachment($file, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message, $cc, $bcc) 
{
    $uid = md5(uniqid(time()));
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    //$header .= "cc : < $cc > \r\n" ;  // comma saparated emails
    //$header .= "Bcc :  < $bcc >\r\n"; // comma saparated emails
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    
	/*$file = $path.$file; // path should be document root path.
	$name = basename($file);
	$file_size = filesize($file);
	$handle = fopen($file, "r");
	$content = fread($handle, $file_size);
	fclose($handle);
	$content = chunk_split(base64_encode($content));

	$header .= "--".$uid."\r\n";
	$header .= "Content-Type: application/octet-stream; name=\"".$file."\"\r\n"; // use different content types here
	$header .= "Content-Transfer-Encoding: base64\r\n";
	$header .= "Content-Disposition: attachment; filename=\"".$file."\"\r\n\r\n";
	$header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";*/
    return mail($mailto, $subject, "", $header);
}

?>