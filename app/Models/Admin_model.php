<?php namespace App\Models;

use CodeIgniter\Model;
/**
* This model is for special functions for Master user
*/
class Admin_model extends Model {

  var $db;

  public function __construct()  {
        parent::__construct();
  }

/**
* Gets user types and puts them into csv file
*/
public function put_user_types() {
  $db      = \Config\Database::connect();
  $builder = $db->table('user_types');
  $res = $builder->get()->getResult();
  $types_str = "id,type code,description,code string,controller\n";
  foreach($res as $type) {
    $types_str .= $type->id_user_types.",".$type->type_code.",".$type->description.",".$type->code_str.",".$type->controller."\n";
  }
  file_put_contents('files/user_types.csv', $types_str);
  $db->close();
}

/**
* Gets users and puts them into csv file
*/
  public function put_users() {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $res = $builder->get()->getResult();
    $users_str = "id,type code,role,username,authorized,active\n";
    foreach($res as $user) {
      $users_str .= $user->id_user.",".$user->type_code.",".$user->role.",".$user->username.",".$user->authorized.",".$user->active."\n";
    }
    file_put_contents('files/users.csv', $users_str);
    $db->close();
  }
  public function search($search) {
    $retarr['mems'] = array();
    $retarr['msg'] = NULL;
    $staff_mod = new \App\Models\Staff_model();
    if(strlen($search) > 0) {
      $db      = \Config\Database::connect();
      $builder = $db->table('tMembers');
      $builder->like('lname', $search);
      $builder->orLike('fname', $search);
      $builder->orLike('callsign', $search);
      $builder->orLike('cur_year', $search);
      $builder->orLike('email', $search);
      $builder->orLike('id_members', strval($search));
      $cnt = $builder->countAllResults();
      if($cnt > 0) {
        $builder->resetQuery();
        $builder->like('lname', $search);
        $builder->orLike('fname', $search);
        $builder->orLike('callsign', $search);
        $builder->orLike('cur_year', $search);
        $builder->orLike('email', $search);
        $builder->orLike('id_members', strval($search));
        $res = $builder->get()->getResult();
        foreach ($res as $key => $mem) {
          $mem_arr = $staff_mod->get_mem($mem->id_members);
          array_push($retarr['mems'], $mem_arr);
        }
      }
    }
    return $retarr;
  }

  /**
  * Gets data for displaying master_view
  * @return string array $retval
  */
  public function get_users_data() {
    $retarr = array();
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $res = $builder->get()->getResult();

//user types are from admin_types table
    $usr_types = $this->get_user_types();
    $users = array();
    foreach($res as $user) {

      if($user->type_code != 99) {
        $usr_arr = array(
          'id' => $user->id_user,
          'id_type_code' => $user->type_code,
          'id_user_type' => $user->id_user_type,
          'fname' => $user->fname,
          'lname' => $user->lname,
          'callsign' => $user->callsign,
          'active' => $user->active,
          'authorized' => $user->authorized,
          'usr_types' => $usr_types,
          'street' =>$user->street,
          'city' => $user->city,
          'state' => $user->state_cd,
          'zip' => $user->zip_cd,
          'phone' => $user->phone,
          'email' => $user->email
        );
        $user->username != NULL ? $usr_arr['username'] = $user->username : $usr_arr['username'] = 'Not Set!';
        $user->id_user_type != 0 ? $usr_arr['type_desc'] = $usr_types[$user->id_user_type] : $usr_arr['type_desc'] = $usr_types[$user->id_user_type];
        $user->comment == NULL ? $usr_arr['comment'] = '' : $usr_arr['comment'] = $user->comment;
        $user->facebook == NULL ? $usr_arr['facebook'] = '' : $usr_arr['facebook'] = $user->facebook;
        $user->twitter == NULL ? $usr_arr['twitter'] = '' : $usr_arr['twitter'] = $user->twitter;
        $user->linkedin == NULL ? $usr_arr['linkedin'] = '' : $usr_arr['linkedin'] = $user->linkedin;
        $user->comment == NULL ? $usr_arr['comment'] = '' : $usr_arr['comment'] = $user->comment;
        $user->city == NULL ? $usr_arr['city'] = '' : $usr_arr['city'] = $user->city;
        $user->zip_cd == NULL ? $usr_arr['zip'] = '' : $usr_arr['zip'] = $user->zip_cd;
        array_push($users, $usr_arr);
      }
      
    }
    $db->close();
    $retarr['usr_types'] = $usr_types;
    $retarr['users'] = $users;
    return $retarr;
  }

  public function get_payments($dates) {

    $date_from = strtotime($dates['date_from']);

    $date_to = strtotime('+1 days', strtotime($dates['date_to']));
    $date_to = $date_to - 1;

    $db      = \Config\Database::connect();
    $builder = $db->table('mem_payments');
    $builder->where('result', 'success');
    $builder->where('paydate >=', $date_from);
    $builder->where('paydate <=', $date_to);
    $builder->orderBy('id_payment', 'ASC');

    $res = $builder->get()->getResult();
    
    //echo '<br><br><br><br>cnt: ' . count($res);
    $retarr = array();
    $retarr['payments'] = array();
    $fname = '';
    $lname = '';
    $total = 0;

    // save data in .csv file
    $data_str = "ID-Payments, ID-Member, ID-Transaction, First-Name, Last-Name, Payment-Date, Pay-Action, Method, Amount, Fee, Note\n";
    $fee_total_amt = 0;
    $got_trans = false;
    $id_trans = -1;
    foreach($res as $payment) {
      $trans_amt = 0;
      $fee_total = 0;
      if($payment->id_transaction != 0) {
        if($id_trans != $payment->id_transaction) {
          $id_trans = $payment->id_transaction;
          $builder->resetQuery();
          $builder = $db->table('transactions');
          $builder->resetQuery();
          $builder->where('id_transactions', $id_trans);
          $trans_amt = $builder->get()->getRow()->fee_amt;
          $fee_total += $trans_amt;
        }
      }
      
    // get member  
      $id_mem = $payment->id_member;
      if($id_mem != 0) {
        $builder->resetQuery();
        $builder = $db->table('tMembers');
        $builder->resetQuery();
        $builder->where('id_members', $id_mem);
        $mem_obj = $builder->get()->getRow();
        if($mem_obj != null) {
          $fname = $mem_obj->fname;
          $lname = $mem_obj->lname;
        }
        else {
          $lname = 'anonymous';
        }
      }
      else {
        $lname = 'anonymous';
      }    
    // get payaction
      $builder->resetQuery();
      $builder = $db->table('payactions');
      $builder->resetQuery();
      $builder->where('id_payaction', $payment->id_payaction);
      $payaction = $builder->get()->getRow()->description;
      //if($payment->id_payaction == 7 || $payment->id_payaction == 5) $payaction = substr($payaction, 0, 8);
      $pay_amt = '$' . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $payment->amount)), 2);
      $mode = 'via CC';
      if($payment->val_string == 'man-payment') {
        $mode = 'manual';
      }

      $rep_amt = 0;
      if($payment->flag == 0) $rep_amt = $payment->amount;

      $data_str .= strval($payment->id_payment).",".strval($payment->id_member).",".strval($payment->id_transaction).",".$fname.",".$lname.",".date("Y-m-d", $payment->paydate).",".$payaction.",".$mode.",".$rep_amt."," .$trans_amt. ",".$payment->note ."\n";

      $fee_total_amt += $trans_amt;

      if($got_trans) {
        
      }
      $rec_arr = array(
        'id_payments' => $payment->id_payment,
        'id_trans' => $payment->id_transaction,
        'id_member' => $id_mem,
        'fname' => $fname,
        'lname' => $lname,
        'payaction' => $payaction,
        'amount' => $pay_amt,
        'paydate' => $payment->paydate,
        'mode' => $mode,
        'fee' => $trans_amt,
        'flag' => $payment->flag,
        'note' => $payment->note
      );
      if($payment->flag == 0) $total += $payment->amount;
      array_push($retarr['payments'], $rec_arr);
    }
    // get transactions
    $this->get_fees($date_from, $date_to);

    $db->close();
    file_put_contents('files/paym_rep.csv', $data_str);
    $total_fomatted = "$" . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $total)), 2);

    $retarr['dates'] = $dates;
    $retarr['total'] = $total_fomatted;
    $retarr['total_fee'] = "$" . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $fee_total_amt)), 2);

    return $retarr;
  }

  private function get_fees($date_from, $date_to) {
    $db      = \Config\Database::connect();    
    $builder = $db->table('transactions');
    $builder->where('date >=', $date_from);
    $builder->where('date <=', $date_to);
    $res = $builder->get()->getResult();
    $data_str = "ID-Transaction, ID-Member, First-Name, Last-Name, Payment-Date, Total, Fee\n";
    
    foreach($res as $trans) {
      $id_mem = $trans->id_member;
      $fname = "";
      $lname = "";
      if($id_mem != 0) {
        $builder->resetQuery();
        $builder = $db->table('tMembers');
        $builder->resetQuery();
        $builder->where('id_members', $id_mem);
        $mem_obj = $builder->get()->getRow();
        if($mem_obj != null) {
          $fname = $mem_obj->fname;
          $lname = $mem_obj->lname;
        }
        else {
          $lname = 'anonymous';
        }
      }
      else {
        $lname = 'anonymous';
      } 
      $data_str .= strval($trans->id_transactions).",".strval($trans->id_member).",".$mem_obj->fname.",".$mem_obj->lname.",".date("Y-m-d", $trans->date).",".strval($trans->total_amt).",".strval($trans->fee_amt) ."\n";
    }
    $db->close();
    file_put_contents('files/transactions.csv', $data_str);
  }

  public function get_mem_cost() {
    $db      = \Config\Database::connect();    
    $builder = $db->table('payactions');
    $builder->where('id_payaction', 1);
    return $builder->get()->getRow()->amount;
  }

  public function update_payment($param) {
    $db      = \Config\Database::connect();    
    $builder = $db->table('mem_payments');
    $builder->where('id_payment', $param['id_payment']);
    $builder->update(array('flag' => $param['flag'], 'note' => $param['note']), ['id_payment' => $param['id_payment']]);
    $db->close();
  }

  public function man_payment($param) {
    $retval = true;
    
    $pay_data = array();
    $pay_data['id_payaction'] = 1;

    $pay_data['id_member'] = $param['id_member'];
    $pay_data['id_entity'] = 2;
    $pay_data['amount'] = floatval($param['amount']);
    $pay_data['paydate'] = strtotime($param['paydate']);
    $pay_data['result'] = 'success';
    $pay_data['val_string'] = 'man-payment';
    $pay_data['flag'] = 0;
    $pay_data['id_transaction'] = 0;
    $pay_data['fee_amt'] = 0;
    
    $donation = floatval($param['donation']);
    $don_rep = floatval($param['don_rep']);
    unset($param['donation']);
    unset($param['don_rep']);

    $carrier = 'false';
    $car_val = $param['carrier'];
    unset($param['carrier']);

    if($car_val == 'carrier') {
      $carrier = 'true';
    }

  // get current year for the member
    $mem_year = 0;
    $db      = \Config\Database::connect();    
    $builder = $db->table('tMembers');
    $builder->where('id_members', $param['id_member']);
      
    $yearToday = strval(date('Y'));
    $monthToday = strval(date('m'));
    
    $test_year = $builder->get()->getRow()->cur_year;
    $mem_year = 0;
    if($test_year < $yearToday) {
      if($monthToday > 9) {
        $mem_year = $yearToday + 1;
      }
      else {
        $mem_year = $yearToday;
      }
    }
    else {
      $mem_year = $test_year + 1;
    }

    if($pay_data['amount'] > 0) {
      $builder->resetQuery();
      $builder = $db->table('tMembers');
      $builder->resetQuery();
      $builder->update(array('cur_year' => $mem_year, 'paym_date' => $pay_data['paydate'], 'hard_news' => $carrier), ['id_members' => $pay_data['id_member']]);
      $builder->update(array('cur_year' => $mem_year, 'paym_date' => $pay_data['paydate'], 'hard_news' => $carrier), ['parent_primary' => $pay_data['id_member']]);
      $pay_data['for_year'] = $mem_year;

      $builder->resetQuery();
      $builder = $db->table('mem_payments');
      $this->db->transStart();
      $builder->insert($pay_data);
      $this->db->transComplete();
    }     

    if($donation >= 5) {
      $pay_data['id_payaction'] = 7;
      $pay_data['amount'] = $donation;
      $builder->resetQuery();
      $builder = $db->table('mem_payments');
      $this->db->transStart();
      $builder->insert($pay_data);
      $this->db->transComplete();
    }

    if($don_rep >= 5) {
      $pay_data['id_payaction'] = 5;
      $pay_data['amount'] = $don_rep;
      $builder->resetQuery();
      $builder = $db->table('mem_payments');
      $this->db->transStart();
      $builder->insert($pay_data);
      $this->db->transComplete();
    }

    if($car_val == 'carrier') {
      $builder->resetQuery();
      $builder = $db->table('payactions');
      $builder->where('id_payaction', 10);
      $pay_data['amount'] = $builder->get()->getRow()->amount;

      $builder->resetQuery();
      $pay_data['id_payaction'] = 10;      
      $builder = $db->table('mem_payments');
      $this->db->transStart();
      $builder->insert($pay_data);
      $this->db->transComplete();
    }

    if ($this->db->transStatus() === false) {
      $retval = false;
    }

    return $retval;
  }

  private function get_user_types() {
    $db      = \Config\Database::connect();
    $builder = $db->table('admin_types');
    $res = $builder->get()->getResult();
    $arr_desc = array();
    $arr_keys = array();
    $types_arr = array();
    foreach($res as $key => $type) {
        $types_arr[$type->id_user_types] = $type->description;
    }
    return $types_arr;
  }

  private function get_user_type($id) {
    $id != 0 ? $retval = $id : $retval = 4;
    return $retval;
  }

  public function delete_user($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $db->close();
    $builder->delete(['id_user' => $id]);
  }

  public function load_admin($param) {
    $id = $param['id_user'];
    unset($param['id_user']);
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->resetQuery();
    $builder->update($param, ['id_user' => $id]);
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('id_users', $id);
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $arr = array('fname' => $param['fname'],
        'lname' => $param['lname'],
        'callsign' => $param['callsign']);
      $builder->update($arr, ['id_users' => $id]);
    }
    $db->close();
  }

  public function activate($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $db->close();
    $builder->where('id_user', $id);
    $flag = $builder->get()->getRow()->active;
    if($flag == 1) {
      $builder->resetQuery();
      $builder->update(array('active' => 0), ['id_user' => $id]);
    }
    else {
      $builder->resetQuery();
      $builder->update(array('active' => 1), ['id_user' => $id]);
    }
  }

  public function authorize($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->where('id_user', $id);
    $usr = $builder->get()->getRow();
    $flag = $usr->authorized;
    if($flag == 1) {
      $builder->resetQuery();
      $builder->update(array('authorized' => 0), ['id_user' => $id]);
    }
    else {
      $builder->resetQuery();
      $builder->update(array('authorized' => 1), ['id_user' => $id]);

      $subject = 'MDARC Portal: You Are Now Authorized Access';
      $message = $usr->fname . ' ' . $usr->lname . "\n\n".
 	        'You are now authorized to access MDARC membership portal at ' . base_url() . '. Thank you!';
           $headers = array('From' => 'mdarc-memberships@arrleb.org', 'Reply-To' => 'mdarc-memberships@arrleb.org' );
 	    mail($usr->email, $subject, $message, $headers);

      $subject = 'MDARC Portal: User Authorization';
      $message = $usr->fname . ' ' . $usr->lname . "\n\n".
 	        'Was just authorized to use MDARC membership portal.';
      mail('jkulisek.us@gmail.com', $subject, $message, $headers);
    }
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('email', $usr->email);
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder = $db->table('tMembers');
      $builder->where('email', $usr->email);
      $id_mem = $builder->get()->getRow()->id_members;
      $builder->resetQuery();
      $builder = $db->table('tMembers');
      $builder->update(array('id_users' => $id), ['id_members' => $id_mem]);
    }
    $db->close();
  }

  public function reset_user($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $db->close();

    $retarr = array();

    $retarr['pass_match'] = TRUE;
    $retarr['pass_comp'] = TRUE;
    $retarr['flag'] = TRUE;
    $retarr['usr_dup'] = FALSE;

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

//if not flagged and all good then update username and password
    if($retarr['flag']) {
      $param['username'] = strtolower($param['username'] ?? '');
      $param['pass'] = password_hash($param['pass'], PASSWORD_BCRYPT, array('cost' => 12));
      $update = array('pass' => $param['pass'], 'username' => $param['username'], 'active' => 1);
      $builder->update($update, ['id_user' => $param['id_user']]);
    }

    return $retarr;
  }

//only one time run to populate mem type
  public function set_mem_type() {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMemTypes');
    $builder->orderBy('id_mem_types', 'ASC');
    $types = $builder->get()->getResult();
    $types_arr = array();
    $i = 1;
    foreach($types as $type) {
      $types_arr[$i] = $type->description;
      $i++;
    }
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $mems = $builder->get()->getResult();
    $builder->resetQuery();
    foreach($mems as $mem) {
      for($i = 1; $i < count($types_arr) + 1; $i++) {
        if($types_arr[$i] == $mem->mem_type) {
          $update = array('id_mem_types' => $i);
          $builder->update($update, ['id_members' => $mem->id_members]);
        }
      }
    }
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $mems = $builder->get()->getResult();
    foreach($mems as $mem) {
      if($mem->id_mem_types == 0) {
        $update = array('id_mem_types' => 1);
        $builder->update($update, ['id_members' => $mem->id_members]);
      }
    }
    $db->close();
  }

  public function get_member_types() {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMemTypes');
    $builder->orderBy('id_mem_types', 'DESC');
    $types = $builder->get()->getResult();
    $retarr = array();
    foreach($types as $type) {
      $type_arr= array('id' => $type->id_mem_types, 'description' => $type->description);
      array_push($retarr, $type_arr);
    }
    $db->close();
    return $retarr;
  }

  /**
  * Combining prefix and suffix into call sign in legacy tables
  * now using test db
  */
  public function convert_to_callsign($table) {
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    $mems = $builder->get()->getResult();
    foreach($mems as $mem) {
      $update = array('callsign' => $mem->Prefix . $mem->Suffix);
      $builder->resetQuery();
      $builder->update($update, ['id' => $mem->id]);
    }
    $db->close();
  }

/**
* Converts number string into phone format
* Inspired by: https://www.geeksforgeeks.org/how-to-format-phone-numbers-in-php/
*/
  public function do_phone($phone) {

    $retarr = array();
    $retarr['flag'] = TRUE;

    // Pass phone number in preg_match function
    if(preg_match('/^\+[0-9]([0-9]{3})([0-9]{3})([0-9]{4})$/', $phone, $value)) {
        // Store value in format variable
        $format = $value[1] . '-' . $value[2] . '-' . $value[3];
    }
    else {
        // If given number is invalid
        $retarr['flag'] = FALSE;
    }
    $retarr['phone'] = $format;
    // Print the given format
    //echo("$format" . "<br>");
    return $retarr;
  }

  public function regex($instr) {
    $retval = "OK";
    if(!preg_match('/^(?=(.*[a-z]){2,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-__+.]){2,}).{12,}$/', $instr)) {
      $retval = "Not OK";
    }
    return $retval;
  }

  public function carr_check() {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $res = $builder->get()->getResult();
    foreach ($res as $key => $mem) {
      $update = array('hard_dir' => strtolower($mem->hard_dir ?? ''), 'hard_news' => strtolower($mem->hard_news ?? ''), 'arrl_mem' => strtolower($mem->arrl_mem ?? ''), 'ok_mem_dir' => strtolower($mem->ok_mem_dir ?? ''), 'mem_card' => strtolower($mem->mem_card ?? ''));
      $builder->resetQuery();
      $builder->update($update, ['id_members' => $mem->id_members]);
    }
    return 'Carrier check done!';
  }

}
