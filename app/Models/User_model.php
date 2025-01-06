<?php namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model {

  var $db;

  public function __construct()  {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

  public function register($param) {
    //echo '<br><br><br><br> email: ' . $param['email'];
    $retarr = array();
    $retarr['flag'] = TRUE;
    $db  = \Config\Database::connect();
    $bldr = $db->table('users');
//check for duplicate email
    $bldr->resetQuery();
    $bldr->where('email', $param['email']);
    $cnt_email = $bldr->countAllResults();
//check for duplicate fname and lname
    $bldr->resetQuery();
    $bldr = $this->db->table('users');
    $bldr->where('fname', $param['fname']);
    $bldr->where('lname', $param['lname']);
    $cnt_name = $bldr->countAllResults();

    if(!$this->is_member($param['email'])) {
      $retarr['flag'] = FALSE;
    }

    if(($cnt_email == 0) && ($cnt_name == 0) && $retarr['flag']) {
      $rand_str = bin2hex(openssl_random_pseudo_bytes(12));
      $param['verifystr'] = base_url() . '/index.php/set-pass/' . $rand_str;
	    $param['email_key'] = $rand_str;

// as default the user type will always be the MDARC Member
      $param['id_user_type'] = 2;
      $param['type_code'] = 2;
      $bldr->resetQuery();
      $bldr->insert($param);

      $recipient = 'jkulisek.us@gmail.com';
      $subject = 'MDARC New User Registration';
      $message = $param['fname'] . ' ' . $param['lname'] . "\n\n".
 	        $param['street'] . "\n\n" .$param['city'] . ' ' . $param['state_cd'] . $param['zip_cd'] . "\n\n".
 	        ' Phone: ' . $param['phone'] . ' | Email: ' . $param['email'] . "\n\n" .
          $param['verifystr'];
      $headers = array('From' => 'mdarc-memberships@arrleb.org', 'Reply-To' => 'mdarc-memberships@arrleb.org' );

 	    mail($recipient, $subject, $message, $headers);

      $recipient = $param['email'];
      $subject = 'MDARC Member Portal User Registration';

      $message = 'To finish your registration for MDARC Membership Portal click on the following link or copy paste in the browser: ' . $param['verifystr'] . "\n\n";
      $message .= 'You must do so within 72 hours otherwise you login information may be deactivated.
                  Thank you for your interest in Mount Diablo Amateur Radio Club!';
	   	mail($recipient, $subject, $message, $headers);
    }
    else {
      $retarr['flag'] = FALSE;
      $retarr['msg'] = 'There was an error in your data: ';
      if($cnt_email > 0 && $cnt_name == 0) {
        $retarr['msg'] .= 'the email you entered is already in the database. Please, use a different email.';
      }
      elseif($cnt_email == 0 && $cnt_name > 0) {
        $retarr['msg'] .= 'first and last name is already in the database. Please, use the lost username and password utility.';
      }
      elseif($cnt_email > 0 && $cnt_name > 0) {
        $retarr['msg'] .= 'email including first and last name is already in the database. Please, use the lost username and password utility.';
      }
      else {
        $retarr['msg'] .= 'most likely you are not an MDARC member or you entered a different email than you use for your MDARC membership. This portal is for MDARC members only.';
      }
    }
    $db->close;
    return $retarr;
  }

  public function is_member($email) {
    $retval = FALSE;
    $db  = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('email', $email);
    if($builder->countAllResults() > 0) {
      $retval = TRUE;
    }
    return $retval;
  }

/**
* Retrieves user data per the verify string when the user clicks the user verification URL in his/her email
* @param string $verifystr
* @return array retarr[]
*/
  public function get_user_to_reg($verifystr) {
    $db  = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->where('email_key', $verifystr);
    $row = $builder->get()->getRow();
    $retarr['fname'] = $row->fname;
    $retarr['lname'] = $row->lname;
    $retarr['id_user'] = $row->id_user;
    $retarr['username'] = '';
    $retarr['msg'] = '';
    return $retarr;
  }

/**
* Retrieve user class properties and copy into array
* @param class $user
* @return array retarr[]
*/
  public function get_user_arr($user) {
    $retarr = array();
    $retarr['id_user'] = $user->id_user;
    $retarr['fname'] = $user->fname;
    $retarr['lname'] = $user->lname;
    $retarr['email'] = $user->email;
    $retarr['phone'] = $user->phone;
    $retarr['street'] = $user->street;
    $retarr['city'] = $user->city;
    $retarr['state'] = $user->state_cd;
    $retarr['zip'] = $user->zip_cd;
    $retarr['role'] = $user->type_code;
    $retarr['username'] = $user->username;
    $retarr['authorized'] = $user->authorized;
    $retarr['active'] = $user->active;
//this is legacy
    $retarr['level'] = $user->type_code;
//this is current
    $retarr['type_code'] = $this->get_user_types[$user->id_user_type];

//get the controller for the user type
    $db = \Config\Database::connect();
    $builder = $db->table('user_types');
    $builder->where('type_code', $retarr['type_code']);
    $retarr['controller'] = $builder->get()->getRow()->controller;
    $builder->resetQuery();

//get the position name on staff
    $builder = $db->table('staff');
    $builder->where('id_user', $user->id_user);
    if($builder->countAllResults() > 0) {
      $retarr['pos_name'] = $builder->get()->getRow()->position_name;
    }
    else {
      $retarr['pos_name'] = '';
    }
    $db->close();
    return $retarr;
  }

  public function get_id_email_key($email_key) {
    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->where('email_key', $email_key);
    $retval = 0;
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder->where('email_key', $email_key);
      $retval = $builder->get()->getRow()->id_user;
    }
    $db->close();
    return $retval;
  }

  /**
  * Validates user and password inspired by:
  * https://stackoverflow.com/questions/11873990/create-preg-match-for-password-validation-allowing
  */
  public function set_user($param) {

    $retarr['pass_match'] = TRUE;
    $retarr['pass_comp'] = TRUE;
    $retarr['flag'] = TRUE;
    $retarr['usr_dup'] = FALSE;
    $retarr['flag'] = $param['flag'];

//check password complexity
    if(!preg_match('/^(?=(.*[a-z]){2,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-_+.]){2,}).{8,}$/', $param['pass'])) {
      $retarr['pass_comp'] = FALSE;
      $retarr['flag'] = FALSE;
    }

//check if passwords match
    if($param['pass'] != $param['pass2']) {
      $retarr['pass_match'] = FALSE;
      $retarr['flag'] = FALSE;
    }

//and then also check for duplicate username
    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $db->close();
    $builder->where('username', $param['username']);
    if($builder->countAllResults() > 0) {
      $retarr['usr_dup'] = TRUE;
      $retarr['flag'] = FALSE;
    }

//get email key from db and compare
    $builder->resetQuery();
    $builder->where('email_key', $param['email_key']);
    if ($builder->countAllResults() > 0) {
//get id_user
      $retarr['id_user'] = $this->get_id_email_key($param['email_key']);
      $retarr['email_key'] = $param['email_key'];
    }
    else {
      $retarr['flag'] = FALSE;
      $retarr['id_user'] = 0;
    }

//if not flagged and all good then update username and password
    if($retarr['flag']) {
      $builder->resetQuery();
      $db = \Config\Database::connect();
      $builder = $db->table('users');
      $db->close();
      $param['pass'] = password_hash($param['pass'], PASSWORD_BCRYPT, array('cost' => 12));
      $update = array('pass' => $param['pass'], 'username' => $param['username'], 'active' => 1, 'email_key' => 'key used');
      $builder->update($update, ['id_user' => $retarr['id_user']]);
    }

    return $retarr;
  }

  public function change_user_pass($param) {

    $retarr['usr_chk'] = TRUE;
    $retarr['flag'] = TRUE;
    $retarr['usr_dup'] = FALSE;
    $retarr['flag'] = $param['flag'];
    $retarr['email_key'] = $param['email_key'];

    $pass_flags = $this->check_pass($param);
    $retarr['pass_comp'] = $pass_flags['pass_comp'];
    $retarr['pass_match'] = $pass_flags['pass_match'];

    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->where('username', $param['username']);
    $builder->where('email_key', $param['email_key']);

    $retarr['id_user'] = 99999;
    if ($builder->countAllResults() > 0) {
//get id_user
      $retarr['id_user'] = $this->get_id_email_key($param['email_key']);
      $retarr['email_key'] = $param['email_key'];
    }
    else {
      $retarr['flag'] = FALSE;
      $retarr['usr_chk'] = FALSE;
    }

//if not flagged and all good then update username and password
    if($retarr['flag']) {
      $builder->resetQuery();
      $builder = $db->table('users');
      $usrname = $param['username'];
      unset($param['username']);
      $param['pass'] = password_hash($param['pass'], PASSWORD_BCRYPT, array('cost' => 12));
      $update = array('pass' => $param['pass'], 'username' => $usrname, 'active' => 1, 'email_key' => 'key used');
      $builder->update($update, ['id_user' => $retarr['id_user']]);
    }
    $db->close();
    return $retarr;
  }

  public function load_password($param) {
    $retarr['flag'] = TRUE;
    $retarr['db_flag'] = TRUE;
    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->where('email', $param['email']);

    if($builder->countAllResults() > 0) {

//generate random key for email verification
      $rand_str = bin2hex(openssl_random_pseudo_bytes(12));
      $param['verifystr'] = base_url() . '/index.php/change-pass/' . $rand_str;
      $param['email_key'] = $rand_str;

//update email key in db
      $this->db->transStart();
      $builder->resetQuery();
      $builder = $db->table('users');
      $builder->where('email', $param['email']);
      $update_str = array('email_key' => $param['email_key'], 'active' => 0);
      $builder->update($update_str, ['email' => $param['email']]);
      $this->db->transComplete();

      if ($this->db->transStatus() === FALSE) {
          $retarr['db_flag'] = FALSE;
      }

//setup email

      $email = service('email');

      $config['protocol'] = 'smtp';
      $config['SMTPHost'] = 'smtp.ionos.com';
      $config['SMTPUser'] = 'mdarc-memberships@arrleb.org';
      $config['SMTPPass'] = 'CKPrb56yg!4Q$vC';
      $config['SMTPPort'] = 587;
      $config['mailType'] = 'html';

      $email->initialize($config);

      $email->setFrom('mdarc-memberships@arrleb.org', 'MDARC Membership Chair');

//send email to user with verification string
      $email->setTo($param['email']);
      $email->setSubject('MDARC Member Password Change');
      $message = 'To change your password for MDARC Membership Portal click on the following link or copy paste in the browser: ' . $param['verifystr'] . "\n\n";
      $message .= 'Thank you for being a loyal MDARC Member!';
      $email->setMessage($message);
      $email->setFrom('mdarc-memberships@arrleb.org', 'MDARC Membership Chair');

      if(!$email->send()) {
        echo 'in send to user';
        $retarr['flag'] = FALSE;
      }

//send email to user with verification string
      $email->setTo('jkulisek.us@gmail.com');
      $email->setFrom('mdarc-memberships@arrleb.org', 'MDARC Membership Chair');
      $email->setSubject('MDARC Member Password Change to Admin');
      $message = 'From: ' . $param['email'] . "\n\n";
      $message .= 'To change your password for MDARC Membership Portal click on the following link or copy paste in the browser: ' . $param['verifystr'] . "\n\n";
      $email->setMessage($message);

      if(!$email->send()) {
        echo 'in send to admin';
        $retarr['flag'] = FALSE;
      }
    }
    else {
      $retarr['flag'] = FALSE;
    }
    return $retarr;
  }

public function load_password2($param) {
  $retarr['pass_match'] = TRUE;
  $retarr['pass_comp'] = TRUE;
  $retarr['flag'] = TRUE;
  $retarr['usr_dup'] = FALSE;
  $retarr['flag'] = $param['flag'];

//check password complexity
  if(!preg_match('/^(?=(.*[a-z]){2,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-_+.]){2,}).{8,}$/', $param['pass'])) {
    $retarr['pass_comp'] = FALSE;
    $retarr['flag'] = FALSE;
  }

//check if passwords match
  if($param['pass'] != $param['pass2']) {
    $retarr['pass_match'] = FALSE;
    $retarr['flag'] = FALSE;
  }

//get id_user
  $retarr['id_user'] = $this->get_user_id($param['username']);
  if($retarr['id_user'] == 0) $retarr['flag'] = FALSE;


//if not flagged and all good then update username and password
  if($retarr['flag']) {

    $rand_str = bin2hex(openssl_random_pseudo_bytes(12));
    $ver_str = base_url() . '/index.php/set-pass/' . $rand_str;
    $ver_email = $rand_str;

    $ver_arr = array('verify_str' => $ver_str, 'email_key' => $ver_email);

    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $param['pass'] = password_hash($param['pass'], PASSWORD_BCRYPT, array('cost' => 12));
    $update = array('pass' => $param['pass'], 'username' => $param['username'], 'active' => 1);
    $builder->update($update, ['id_user' => $retarr['id_user']]);
    $builder->resetQuery();
    $builder->update($ver_arr, ['id_user' => $retarr['id_user']]);
    $builder->resetQuery();
    $builder->where('id_user', $retarr['id_user']);
    $usr = $builder->get()->getRow();
    $db->close();

    $recipient = 'jank@jlkconsulting.info';
    $subject = 'MDARC Password Reset';
    $message = $usr->fname . ' ' . $usr->lname . "\n\n" . $ver_str;
        $param['verifystr'];

    mail($recipient, $subject, $message);

    $recipient = $usr->email;
    $subject = 'MDARC Member Portal Password Reset';

    $message = 'To finish your password reset for MDARC Membership Portal click on the following link or copy paste in the browser: ' . $param['verifystr'] . "\n\n";
    $message .= 'Thank you for your interest in Mount Diablo Amateur Radio Club!';
    mail($recipient, $subject, $message);
}

return $retarr;
}
  private function get_user_id($username) {
    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->where('username', $username);
    $retval = 0;
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder->where('username', $username);
      $retval = $builder->get()->getRow()->id_user;
    }
    return $retval;
  }

  public function get_user_types() {
    $db      = \Config\Database::connect();
    $builder = $db->table('admin_types');
    $res = $builder->get()->getResult();
    $types_arr = array();
    foreach($res as $type) {
        if($type->id_user_types > 1) $types_arr[$type->id_user_types] = $type->description;
      }
      return $types_arr;
    }

    public function lost_username($email) {
      $db = \Config\Database::connect();
      $builder = $db->table('users');
      $builder->where('email', $email);
      $retval = FALSE;
      if($builder->countAllResults() > 0) {
        $builder->resetQuery();
        $builder = $db->table('users');
        $builder->where('email', $email);
        $username = $builder->get()->getRow()->username;
        $subject = 'MDARC Members Portal Username Recovered';
        $message = 'Your MDARC Username: ' . $username . "\n\n";
        $message .= 'Login to MDARC Members Portal: ' . base_url() . "\n\n" . 'Thank you!';
        mail($email, $subject, $message);
        $retval = TRUE;
      }
      return $retval;
    }

    public function get_id_by_email($email) {
      $db = \Config\Database::connect();
      $builder = $db->table('users');
      $builder->where('email', $email);
      $retval = 0;
      if($builder->countAllResults() > 0) {
        $builder->resetQuery();
        $builder = $db->table('users');
        $builder->where('email', $email);
        $retval = $builder->get()->getRow()->id_user;
      }
      return $retval;
    }

    public function check_username($param) {
      $db = \Config\Database::connect();
      $builder = $db->table('users');
      $builder->where('id_user !=', $param['id']);
      $builder->where('username', $param['username']);
      $retarr = array();
      $retarr['usr_flag'] = TRUE;
      $builder->countAllResults() > 0 ? $retarr['usr_flag'] = FALSE : $retarr['usr_flag'] = TRUE;
      return $retarr;
    }

    private function check_pass($param) {
      $retarr = array();
      $retarr['pass_comp'] = TRUE;
      $retarr['flag'] = TRUE;
      $retarr['pass_match'] = TRUE;
      if(!preg_match('/^(?=(.*[a-z]){2,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-_+.]){2,}).{12,}$/', $param['pass'])) {
        $retarr['pass_comp'] = FALSE;
        $retarr['flag'] = FALSE;
      }
  //check if passwords match
      if($param['pass'] != $param['pass2']) {
        $retarr['pass_match'] = FALSE;
        $retarr['flag'] = FALSE;
      }
      return $retarr;
    }

    public function do_update($param) {
      $retarr = array();
      $pass_flags = $this->check_pass($param);
      $retarr['username'] = TRUE;
      $retarr['pass_comp'] = TRUE;
      $retarr['pass_match'] = TRUE;
      $retarr['flag'] = TRUE;
      if(!($this->check_username($param)['usr_flag'] && $pass_flags['flag'])) {
      //if(!(TRUE && $pass_flags['flag'])) {
        if($param['username'] != $param['cur_username']) $retarr['username'] = FALSE;
        $retarr['pass_comp'] = $pass_flags['pass_comp'];
        $retarr['pass_match'] = $pass_flags['pass_match'];
        $retarr['flag'] = FALSE;
      }

      if($retarr['flag']) {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id_user', $param['id']);
        $pass = password_hash($param['pass'], PASSWORD_BCRYPT, array('cost' => 12));
        $update = array('pass' => $pass, 'username' => $param['username']);
        $builder->update($update, ['id_user' => $param['id']]);
        $db->close();
      }

      return $retarr;
    }

    public function check_email($email) {
      $retval = false;
      $db = \Config\Database::connect();
      $builder = $db->table('users');
      $builder->where('email', $email);
      if($builder->countAllResults() > 0) {
        $retval = true;
      }

      return $retval;
    }

}
