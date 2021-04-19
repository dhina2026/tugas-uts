<?php
defined ('BASEPATH') OR exit ('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kelas extends REST_Controller {

	function __construct($config = 'rest') {
		parent::__construct($config);
	}

	//Menampilkan data
	public function index_get() {

		$id = $this->get('id');
		if ($id == '') {
			$this->db->join('kelas','kelas.id_jurusan=jurusan.id_jurusan');

			$data = $this->db->get('jurusan')->result();
		}else {
			$this->db->where('id_kelas', $id);
			$this->db->join('kelas','kelas.id_jurusan=jurusan.id_jurusan');

			$data = $this->db->get('jurusan')->result();
		}
		$result = [
				"took"=>$_SERVER ["REQUEST_TIME_FLOAT"],
				"code"=>200,
				"message"=>"Response successfully",
				"data"=>$data];
		$this->response ($result, 200);
		}
//menambahkan data
public function index_post () {
	$data = array (
					'id_jurusan' => $this->post ('id_jurusan'),
					'nama_jurusan' => $this->post('nama_jurusan'));
	$insert = $this->db->insert('jurusan', $data );
	if ($insert){
		//$this ->response ($data, 200);
		$result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
			"code"=>201,
			"message"=>"Data has successfully added",
			"data"=>$data];
		$this->response($result,201);
	}else{
		$result =["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
			"code"=>502,
			"message"=>"failed adding data",
			"data"=>$null];
		$this->response($result,502);
	}
}

//memperbarui data yang telah ada
public function index_put (){ 
	$id = $this->put('id');
	$data = array (
		'nama_jurusan' => $this->put('nama_jurusan'));
$this->db->where ('id_jurusan',$id);
$update = $this->db->update('jurusan',$data);
	if ($update) {
		$this->response($data, 200);
	} else {
		$this->response(array ('status' => 'fail', 502));
	}
}	

//menghapus data jurusan
public function index_delete () {
	$id = $this->delete('id');
	$this ->db->where('id_jurusan', $id);
	$delete = $this->db->delete('jurusan');
	if ($delete) {
		$this ->response (array ('status' => 'success'), 201);
	}else{
		$this->response(array('status' => 'fail', 502));
	}
}
}
?>

