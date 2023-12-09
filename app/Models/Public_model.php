<?php namespace App\Models;

use CodeIgniter\Model;

class Public_model extends Model {

  var $db;

  public function __construct()  {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function contact() {
      
    }


}
