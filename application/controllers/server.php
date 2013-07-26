<?php
if( !defined('BASEPATH') ){ die("Access Not Alowed"); }

class Server extends Controller 
{
	var $nusoap_server;
	var $ns = "http://localhost/server/";
	
	function Server()
	{
		parent::Controller();
		//require_once( APPPATH."libraries/nusoap/lib/nusoap.php");
		$this->load->library('Nusoap_lib');
		$this->load->helper('map');
		
		$this->nusoap_server = new soap_server();
		$this->nusoap_server->configureWSDL("SoapWSDL", $this->ns);
		$this->nusoap_server->wsdl->ports = array('SoapWSDLPort'=> array(
			"binding" => "SoapWSDLBinding",
			"location" => $this->ns,
			"bindingType"=> "http://schemas.xmlsoap.org/wsdl/soap/"
		));
		
		
		# GET DATA PERSON BERDASARKAN ID PERSON
		$this->nusoap_server->register("getSOAPPersonById",array('person_id' => 'xsd:integer'),	array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data person");
		
		# GET DATA PERSON BERDASARKAN ID KECAMATAN
		$this->nusoap_server->register("getSOAPPersonByKecamatan",array('kec_id' => 'xsd:integer'),	array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data person");
		
		# INSERT DATA PERSON
		$this->nusoap_server->register("getSOAPInsertPerson",array('data' => 'xsd:string'),	array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Tambah data person");
			
		# UPDATE DATA PERSON
		$this->nusoap_server->register("getSOAPUpdatePerson",array('id'=>'xsd:integer','data' => 'xsd:string'),	array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Ubah data person");
		
		# DELETE DATA PERSON
		$this->nusoap_server->register("getSOAPDeletePerson",array('id' => 'xsd:integer'),	array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Hapus data person");
		
		# GET DATA KECAMATAN
		$this->nusoap_server->register("getSOAPKecamatan",array(),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data kecamatan");
		
		# GET DATA AGAMA
		$this->nusoap_server->register("getSOAPAgama",array(),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data agama");
		
		# GET DATA AGAMA
		$this->nusoap_server->register("getSOAPGolonganDarah",array(),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data golongan darah");	
		
		# GET DATA PEKERJAAN
		$this->nusoap_server->register("getSOAPPekerjaan",array(),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data pekerjaan");
			
		# GET DATA PENDIDIKAN
		$this->nusoap_server->register("getSOAPPendidikan",array(),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data pendidikan");
			
		# GET DATA PENYANDANG CACAT
		$this->nusoap_server->register("getSOAPPenyandangCacat",array(),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data penyandang cacat");
			
		# GET DATA STATUS PERKAWINAN
		$this->nusoap_server->register("getSOAPStatusPerkawinan",array(),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data status perkawinan");
			
		# REQUEST LOGIN
		$this->nusoap_server->register("getSOAPLogin",array('username' => 'xsd:string','password' => 'xsd:string'),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data login");
			
		# REQUEST CEK DATA
		$this->nusoap_server->register("getSOAPCekData",array('id' => 'xsd:string','field' => 'xsd:string'),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Cek data tabel person");	
			
		# GET DATA SPASIAL
		$this->nusoap_server->register("getSOAPSpasial",array('kecamatan_id' => 'xsd:integer'),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data spasial");
			
		# GET DATA POTENSI
		$this->nusoap_server->register("getSOAPPotensi",array('combo' => 'xsd:string'),array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data potensi");
			
		# DELETE DATA SPASIAL
		$this->nusoap_server->register("getSOAPDeleteSpasial",array('id' => 'xsd:integer'),	array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Hapus data spasial");
			
		# GET DATA MARKE
		$this->nusoap_server->register("getSOAPGetMarker",array('id' => 'xsd:integer'),	array("return"=>"xsd:string"),
			"urn:SoapWSDL","urn:".$this->ns."/server","rpc","encoded","Get data marker");
			
	}
	
	function index()
	{		
		$this->nusoap_server->service(file_get_contents("php://input"));		
	}	
	
}


/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */