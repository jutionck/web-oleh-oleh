<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backup extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->dbutil();
    $this->redirect = 'backoffice/backup-database';
  }

  public function index()
  {
    $data = [
      'title'         => 'Backoffice | Backup Database',
      'cardTitle'     => 'Backup Database',
      'redirect'      => $this->redirect,
    ];
    $page = '/backoffice/admin/backup/index';
    pageBackend($page, $data);
  }

  public function create()
  {
    $tables = array();
    $query = $this->db->query("SHOW FULL TABLES WHERE Table_Type = 'BASE TABLE'");
    foreach ($query->result_array() as $row) {
      $tables[] = $row['Tables_in_' . $this->db->database];
    }

    $datetime = date('Y-m-d_H-i-s');
    $backupName = 'pithogsi16_' . $datetime;
    $prefs = array(
      'tables'      => $tables,
      'format'      => 'zip',
      'filename'    => $backupName . '.sql'
    );

    $backup = $this->dbutil->backup($prefs);
    $filepath = 'assets/backup/' . $backupName . '.zip';
    if (!is_dir(FCPATH . 'assets/backup/')) {
      mkdir(FCPATH . 'assets/backup/', 0755, true);
    }
    write_file(FCPATH . $filepath, $backup);

    // Kembalikan URL file backup
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(['url' => base_url($filepath)]));
  }
}
