<?php
class connection{
	var $hostname = array();
 	var $username = array();
 	var $password = array();
 	var $database = array();
 	var $url = array();
	private $connection;
	
 
 	/* G 29/12/12 */
	function __construct() {	
	
		$this->hostname['remoto'] = "localhost";
		$this->username['remoto'] = "larednew_semm";
		$this->password['remoto'] = "CiiD9OPC";
		$this->database['remoto'] = "larednew_semm";
		$this->url['remoto'] = "http://www.lared.com.uy/cms/";	
	
		$this->hostname['local'] = "localhost";	
		$this->username['local'] = "root";
		$this->password['local'] = "";
		$this->database['local'] = "cv_medicos_semm";
		$this->url['local'] = "http://localhost/semm/";
	
		$this->mySqlConnect();
	} 	
	
	/* G 26/12/12 */
	function mySqlConnect () {
		
		if ( strstr($_SERVER['DOCUMENT_ROOT'], "C:") ) {
			$i = 'local';
		} else {
			$i = 'remoto';
		}
		
		$this->connection = mysqli_connect ($this->hostname[$i], $this->username[$i], $this->password[$i]);
		//$connection = mysql_connect ($this->hostname[$i], $this->username[$i], $this->password[$i]) or die (mysql_error());
		$db = mysqli_select_db ($this->connection, $this->database[$i]);
		//$db = mysql_select_db ($this->database[$i], $connection) or die (mysql_error());
		
	}

	function consulta( $consulta){
		$resultado = mysql_query($consulta);
		if(!$resultado){ 
			echo 'MySQL Error: ' . mysql_error();
			exit;
		}
		return $resultado;
	}
	
	function safe_query( $query="" ){
		if (empty($query)) {return FALSE;}
                $result =  mysqli_query($this->connection, $query);
                /*$result = mysql_query($query)
                        or die("Consulta fallida"
                                ."<br />errno = ".mysql_errno()
                                ."<br />error = ".mysql_error()
                                ."<br />query = ".$query
                        );*/
		return $result;
	}
	
	//Devuelve el numero de filas de la consulta.
	function NumFilas($result) {
		$this -> numfilas = mysqli_num_rows( $result );
		//$this -> numfilas = mysql_num_rows( $result );
		if( !$this -> numfilas ) {
			$this -> error = mysql_error();
			return( false );        	
		} else {
			return( $this -> numfilas );
		}
	}
	
	//lee una fila de la consulta
	function f_array($result){
                return mysqli_fetch_array($result, MYSQLI_ASSOC);
                //return mysql_fetch_array($result, MYSQL_ASSOC);
	}
	
	//devuelve el id de la fila afectada
	function id_result(){
		return mysql_insert_id();
	}
	
	//cierra la conexion
	function close(){
		//mysql_close();
                mysqli_close($this->connection);
	}
	
}

?>