
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('backoffice/Authentication_model', 'Auth');
		$this->load->model('backoffice/General_model', 'GM');
	}

	public function index()
	{
		$data = [
			'title'	=> 'Backoffice | Login',
		];

		$page = '/backoffice/auth/index';
		pageAuth($page, $data);
	}

	public function login()
	{
		$username   = $this->input->post('username');
		$password   = $this->input->post('password');
		$ceKemail   = $this->Auth->userCheck($username);
		if ($ceKemail->num_rows() > 0) {
			$dataUser    =  $ceKemail->row();
			if (password_verify($password, $dataUser->password)) {
				$this->session->set_userdata('username', $dataUser);
				$this->session->set_userdata('role', $dataUser->role);
				$this->session->set_userdata('user', $dataUser->username);
				$redirect_url = $this->session->userdata('redirect_back') ? $this->session->userdata('redirect_back') : 'backoffice/dashboard';
				redirect($redirect_url);

				switch ($dataUser->role) {
					case 'admin':
						return redirect('backoffice/dashboard');
						break;
					default:
						return redirect('backoffice');
						break;
				}
			} else {
				$this->session->set_flashdata('errorusername', 'username atau password anda salah!');
				redirect('backoffice');
			}
		} else {
			$this->session->set_flashdata('errorusername', 'username atau password anda salah!');
			redirect('backoffice');
		}
	}

	public function retrieve()
	{
		$data = [
			'title'     => 'Backoffice | User',
			'cardTitle' => 'Data User',
			'users' 		=> $this->Auth->getUser()->result()
		];
		$page = '/backoffice/admin/user/index';
		pageBackend($page, $data);
	}

	public function add()
	{
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();
			$setValue = [
				'name'      => $data['name'],
				'username'	=> $data['username'],
				'password'  => password_hash($data['password'], PASSWORD_DEFAULT),
				'role'  		=> 'operator',
			];
			$save = $this->GM->save('users', $setValue);
			if ($save) {
				$this->session->set_flashdata('success', '<b>Tambah data berhasil</b>');
				echo json_encode(array('success' => true, 'message' => 'Data berhasil ditambah'));
			} else {
				$this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
				echo json_encode(array('success' => false, 'message' => 'Gagal menambah data.'));
			}
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal memproses data.'));
		}
	}

	public function edit()
	{
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();
			$setValue = [
				'id'        => $data['id'],
				'name'      => $data['name'],
				'username'  => $data['username'],
				'is_active' => $data['is_active'],
			];

			if (!empty($data['password'])) {
				$setValue['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			}

			$save = $this->GM->save('users', $setValue);
			if ($save) {
				$this->session->set_flashdata('success', '<b>Ubah data berhasil</b>');
				echo json_encode(array('success' => true, 'message' => 'Data berhasil dirubah'));
			} else {
				$this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
				echo json_encode(array('success' => false, 'message' => 'Gagal merubah data.'));
			}
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal memproses data.'));
		}
	}

	public function delete($id)
	{
		$data = $this->Auth->getUser($id)->row();
		if ($data) {
			if ($this->isUserReferenced($id)) {
				$this->session->set_flashdata('error', 'User tidak dapat dihapus karena sedang digunakan di tabel lain.');
			} else {
				$delete = $this->GM->delete('users', ['id' => $id]);
				if ($delete > 0) {
					$this->session->set_flashdata('success', 'Data berhasil dihapus');
				} else {
					$this->session->set_flashdata('error', 'Server data sedang sibuk, silahkan coba lagi');
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Data yang anda masukan tidak ada');
		}
		redirect('backoffice/users');
	}

	private function isUserReferenced($id)
	{
		$tablesToCheck = [
			'workshop_rereg_certificate' => 'user_id',
			// Add more tables as needed
		];

		foreach ($tablesToCheck as $table => $column) {
			// Reset query to avoid conflicts
			$this->db->reset_query();

			// Check if table exists
			if ($this->db->table_exists($table)) {
				$this->db->from($table);
				$this->db->where($column, $id);
				$count = $this->db->count_all_results();
				if ($count > 0) {
					return true;
				}
			} else {
				log_message('error', 'Table ' . $table . ' does not exist.');
			}
		}
		return false;
	}


	public function logout()
	{
		date_default_timezone_set("ASIA/JAKARTA");
		$date = array('last_login' => date('Y-m-d H:i:s'));
		$username = $this->session->userdata('user');
		$this->Auth->logout($date, $username);
		$this->session->unset_userdata('redirect_back');
		$this->session->sess_destroy();
		redirect(base_url('backoffice'));
	}
}
