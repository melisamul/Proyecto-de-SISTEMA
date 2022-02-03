<?php 
//include("conexion.php");
class competencia_DAO
{
public function listar() //devuelve un arreglo de objetos
		{
			//conexion a base de datos

			$dds_db=mysql_connect("localhost","root","");
			mysql_select_db("mydb");
 	
			// se realiza la consulta
			$Sql="SELECT DISTINCT * FROM competencia";
			$resultado=mysql_query($Sql, $dds_db);
			

			$lista = array();

			while($row=mysql_fetch_array($resultado)){
				
				$competencia = new competencia();
				$competencia->constructor($row["codigo"],$row["nombre"],$row["descripcion"]);
				array_push($lista, $competencia);
				//$lista[] = $empresa;
			}

			return $lista;

		}

}
class competencia
	{
		public $codigo;
		public $nombre;
		public $descripcion;
		
	public function constructor($cod,$nom,$des){
		$this->codigo = $cod;
		$this->nombre=$nom;
		$this->descripcion=$des;
		
	}

	function listarNombres()
		{
			$listacomp= array();
			$competencia = new competencia_DAO();
			$var=$competencia->listar();
			foreach ($var as $res) {
				array_push($listacomp, $res->nombre);
			}
			return $listacomp;
		}

}
class empresa_DAO
	{
		public function listar() //devuelve un arreglo de objetos
		{
			//conexion a base de datos

			$dds_db=mysql_connect("localhost","root","");
			mysql_select_db("mydb");
 	
			// se realiza la consulta
			$Sql="SELECT DISTINCT * FROM empresa";
			$resultado=mysql_query($Sql, $dds_db);
			

			$lista = array();

			while($row=mysql_fetch_array($resultado)){
				
				$empresa = new empresa();
				$empresa->constructor($row["nombre"],$row["telefono"],$row["contacto"],$row["direccion"]);
				array_push($lista, $empresa);
				//$lista[] = $empresa;
			}

			return $lista;

	}	
	}
class empresa
	{
		public $nombre;
		public $telefono;
		public $contacto;
		public $direccion;

	public function constructor($nom,$tel,$cont,$direc){
		$this->nombre = $nom;
		$this->telefono=$tel;
		$this->contacto=$cont;
		$this->direccion=$direc;
	}
		

		function listarNombres()
		{
			$listaemp= array();
			$empresa = new empresa_DAO();
			$var=$empresa->listar();
			foreach ($var as $res) {
				array_push($listaemp, $res->nombre);
			}
			return $listaemp;
		}


	}
	class puesto {
		public $codigo;
		public $nombre;
		public $descripcion;
	
	public function constructor ($cod, $nom, $desc){
		$this->codigo = $cod;
		$this->nombre=$nom;
		$this->descripcion=$desc;
		} 

	public function buscarPuestos($data){
		$listapuestos= array();
		$resultado= new puestoDAO();
		$resultado2=$resultado->listarPuestos($data);
		foreach($resultado2 as $res){
			array_push($listapuestos, $res);
		}
		//echo $listapuestos;

		return $listapuestos; //ME PARECE QUE PODEMOS DEVOLVER $RESULTADO2 YA QUE ES UN ARREGLO COMO QUE EL DEVOLVEMOS
	}
}
	class puestoDAO{

		public function listarPuestos($condicion) //devuelve un arreglo de objetos
		{
			//conexion a base de datos

			$dds_db=mysql_connect("localhost","root","");
			mysql_select_db("mydb");
			// se realiza la consulta
			$Sql="SELECT  p.codigo, p.nombre, e.nombre FROM puesto p JOIN empresa e ON(p.Empresa_idEmpresa=e.idEmpresa) WHERE ".$condicion;
			$resultado=mysql_query($Sql, $dds_db);
			
			$lista = array();
			while($row=mysql_fetch_array($resultado)){
				array_push($lista, $row);
			}

			return $lista;
	}

}

	//$var = new empresa_DAO();
	//$var->listar();
	//if (is_object($var)){
	//	echo "yes";}
	//print_r($var->listar());
	//$var2 = new puesto();
	//print_r($var2->buscarPuestos());
?>