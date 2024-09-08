<?php namespace App\Models;

use CodeIgniter\Model;

class Staff_model extends Model {

  var $db;

  public function __construct()  {
        parent::__construct();
        $this->mem_mod = new \App\Models\Member_model();
  }

/**
* Collect all the data needed by MDARC Staff to be displayed on the portal and for file downloads
*/
  public function get_mems($param) {
    $mem_types = $this->get_mem_types();
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    if($param['page'] == 0) {
      $builder->like('lname', 'A', 'after');
      $builder->orLike('lname', 'B', 'after');
      $builder->orLike('lname', 'C', 'after');
      $builder->orLike('lname', 'D', 'after');
      $builder->orLike('lname', 'E', 'after');
      $builder->orWhere('hard_news', 'True');
      $builder->orWhere('hard_news', 'TRUE');
      $builder->orWhere('hard_news', 'true');

    }
    elseif($param['page'] == 1) {
      $builder->like('lname', 'F', 'after');
      $builder->orLike('lname', 'G', 'after');
      $builder->orLike('lname', 'H', 'after');
      $builder->orLike('lname', 'I', 'after');
      $builder->orLike('lname', 'J', 'after');
      $builder->orWhere('hard_news', 'True');
      $builder->orWhere('hard_news', 'TRUE');
      $builder->orWhere('hard_news', 'true');
    }
    elseif($param['page'] == 2) {
      $builder->like('lname', 'K', 'after');
      $builder->orLike('lname', 'L', 'after');
      $builder->orLike('lname', 'M', 'after');
      $builder->orLike('lname', 'N', 'after');
      $builder->orLike('lname', 'O', 'after');
      $builder->orWhere('hard_news', 'True');
      $builder->orWhere('hard_news', 'TRUE');
      $builder->orWhere('hard_news', 'true');
    }
    elseif($param['page'] == 3) {
      $builder->like('lname', 'P', 'after');
      $builder->orLike('lname', 'R', 'after');
      $builder->orLike('lname', 'S', 'after');
      $builder->orWhere('hard_news', 'True');
      $builder->orWhere('hard_news', 'TRUE');
      $builder->orWhere('hard_news', 'true');
    }
    elseif($param['page'] == 4) {
      $builder->like('lname', 'U', 'after');
      $builder->orLike('lname', 'T', 'after');
      $builder->orLike('lname', 'V', 'after');
      $builder->orLike('lname', 'W', 'after');
      $builder->orLike('lname', 'X', 'after');
      $builder->orLike('lname', 'Y', 'after');
      $builder->orLike('lname', 'Z', 'after');
      $builder->orWhere('hard_news', 'True');
      $builder->orWhere('hard_news', 'TRUE');
      $builder->orWhere('hard_news', 'true');
    }
    else {
      $builder->like('lname', 'A', 'after');
      $builder->orLike('lname', 'B', 'after');
      $builder->orLike('lname', 'C', 'after');
      $builder->orLike('lname', 'D', 'after');
      $builder->orLike('lname', 'E', 'after');
      $builder->orWhere('hard_news', 'True');
      $builder->orWhere('hard_news', 'TRUE');
      $builder->orWhere('hard_news', 'true');
    }
    $db->close();
    $res = $builder->get()->getResult();

//members current on their dues either Individual or Primary
    $cur_members = array();
    $cur_emails = array();

//all current members including Individual and Primary with Spouses and Additional members
    $all_cur_members = array();
    $all_cur_emails = array();

//array of members owing dues
    $pay_due = array();

//email string and array of emails for the member owing dues
    $due_emails = '';
    $due_emails_arr = array();

//array for deleted members
    $del_members = array();
    $silent_keys = array();

//The monster loop harvesting all the members data
    foreach($res as $member) {
      $elem = array();
      $elem['id'] = $member->id_members;

//get family members from member model
      $fam_mems = $this->get_fam_mems($elem['id']);
      $elem['fam_mems'] = $fam_mems['fam_mems'];
      $elem['fam_flag'] = $fam_mems['fam_flag'];

//set the true or false values for boolean db entries
      $elem['carrier'] = trim(strtoupper($member->hard_news));
      $elem['dir'] = trim(strtoupper($member->hard_dir));
      $elem['arrl'] = trim(strtoupper($member->arrl_mem));
      $elem['mem_card'] = trim(strtoupper($member->mem_card));
      $member->h_phone == NULL ? $elem['h_phone'] = '000-000-0000' : $elem['h_phone'] = $member->h_phone;
      $member->w_phone == NULL ? $elem['w_phone'] = '000-000-0000' : $elem['w_phone'] = $member->w_phone;
      $member->comment == NULL ? $elem['comment'] = '' : $elem['comment'] = $member->comment;
      $elem['phone_unlisted'] = $member->h_phone_unlisted;
      $elem['cell_unlisted'] = $member->w_phone_unlisted;
      $elem['email_unlisted'] = $member->email_unlisted;
      $elem['fname'] = $member->fname;
      $elem['lname'] = $member->lname;
      $elem['mem_types'] = $mem_types;
      $member->address == NULL ? $elem['address'] = 'N/A' : $elem['address'] = $member->address;
      $member->city == NULL ? $elem['city'] = 'N/A' : $elem['city'] = $member->city;
      $member->state == NULL ? $elem['state'] = 'CA' : $elem['state'] = $member->state;
      $member->zip == NULL ? $elem['zip'] = '00000' : $elem['zip'] = $member->zip;
      $elem['active'] = $member->active;
      $member->cur_year == NULL ? $elem['cur_year'] = 'N/A' : $elem['cur_year'] = $member->cur_year;
      $elem['mem_type'] = $mem_types[$member->id_mem_types];
      $elem['id_mem_types'] = $member->id_mem_types;
      $elem['callsign'] = $member->callsign;
      $elem['license'] = $member->license;
      $elem['hard_news'] = strtoupper($member->hard_news);
      $elem['spouse_name'] = $member->spouse_name;
      $elem['spouse_call'] = $member->spouse_call;
      $elem['pay_date'] = date('Y-m-d', $member->paym_date);
      $elem['pay_date_file'] = date('Y/m/d', $member->paym_date);
      if($member->silent_date > 0) {
        $elem['silent_date'] = date('Y-m-d', $member->silent_date);
      }
      else {
        $elem['silent_date'] = 0;
      }
      $member->mem_since == NULL ? $elem['mem_since'] = 'N/A' : $elem['mem_since'] = $member->mem_since;
      $member->email == NULL ? $elem['email'] = 'N/A' : $elem['email'] = $member->email;
      $elem['ok_mem_dir'] = $member->ok_mem_dir;
      $cur_yr = date('Y', time());
      //$cur_yr = date('Y', time()-(60*60*24*30*12));
      //$member->silent_date > 1 ? $elem['silent_date'] = date('Y-m-d', $member->silent_date) : $elem['silent_date'] = 'No Date';
      $elem['silent_year'] = $member->silent_year;
      $member->usr_type == 98 ? $elem['silent'] = TRUE : $elem['silent'] = FALSE;
      $member->cur_year == 99 ? array_push($del_members, $elem) : FALSE;


//Push all the current members including voting members (Spouse and Additional types)
      if(($member->cur_year >= $cur_yr  && $member->silent_date == 0)) {
        array_push($all_cur_members, $elem);
      }

//Push all the paying members, which are primary and individual
      if(($member->cur_year >= $cur_yr  && $member->silent_date == 0) &&
        ($member->mem_type == 'Primary' || $member->mem_type == 'Individual')) {
        array_push($cur_members, $elem);
      }

//Collect the data of the member who didn't pay dues for current year
      elseif(($member->cur_year == (intval($cur_yr) - 1) && $member->silent_date == 0) && ($member->mem_type == 'Primary' || $member->mem_type == 'Individual')) {

        array_push($pay_due, $elem);
      }

//Get the silent keys
      elseif($member->silent_year > 0) {
        array_push($silent_keys, $elem);
      }
    }
//sort the arrays for displaying
    array_multisort(array_column($cur_members, 'lname'), SORT_ASC, $cur_members);
    array_multisort(array_column($all_cur_members, 'lname'), SORT_ASC, $all_cur_members);
    array_multisort(array_column($pay_due, 'lname'), SORT_ASC, $pay_due);
    array_multisort(array_column($silent_keys, 'lname'), SORT_ASC, $silent_keys);

    $retarr = array();

//get new members for last 30 days
    $from = time() - (60 * 60 * 24 * 30);
    $to = time();
    $retarr['cnt_new'] = count($this->get_new_mems($from, $to));
//get new members for current year
    $from = strtotime("1 January " . date('Y', time()));
    $to = time();
    $retarr['cnt_new_yr'] = count($this->get_new_mems($from, $to));
//get renewals for current year
    $from = strtotime("1 January " . date('Y', time()));
    $to = time();
    $retarr['cnt_renew'] = count($this->get_renewals($from, $to));
//get renewals for last 30 days
    $from = time() - (60 * 60 * 24 * 30);
    $to = time();
    $retarr['cnt_renew_30'] = count($this->get_renewals($from, $to));
    $retarr['lic'] = $param['lic'];
    $retarr['states'] = $param['states'];
    $retarr['cur_members'] = $cur_members;
    $retarr['dir'] = $all_cur_members;
    $retarr['dir_cnt'] = count($all_cur_members);
    $retarr['cnt_cur'] = count($cur_members);
    $retarr['carrier'] = $this->get_carrier();
    $retarr['cnt_pay'] = count($pay_due);
    $retarr['pay_due'] = $pay_due;

//deleted members are actually inactive members still in db
    $retarr['del_mems'] = $del_members;
    $retarr['cnt_del'] = count($del_members);
    $retarr['silent_keys'] = $silent_keys;
    $retarr['cnt_silents'] = count($silent_keys);
    $retarr['mem_types'] = $mem_types;
    $retarr['page'] = $param['page'];
//$retarr['all_mems'] = $this->get_mem_list();
    $this->put_files();

    return $retarr;
  }

  /**
  * Gets directory data
  */
  public function get_dir_data($cur_yr) {
    $mem_types = $this->get_mem_types();
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $res = $builder->get()->getResult();
    $all_cur_members = array();
    //The monster loop harvesting all the members data
        foreach($res as $member) {
          $elem = array();
          $elem['id'] = $member->id_members;

    //get family members from member model
          $fam_mems = $this->get_fam_mems($elem['id']);
          $elem['fam_mems'] = $fam_mems['fam_mems'];
          $elem['fam_flag'] = $fam_mems['fam_flag'];

    //set the true or false values for boolean db entries
          $member->h_phone == NULL ? $elem['h_phone'] = '000-000-0000' : $elem['h_phone'] = $member->h_phone;
          $member->w_phone == NULL ? $elem['w_phone'] = '000-000-0000' : $elem['w_phone'] = $member->w_phone;
          $elem['phone_unlisted'] = $member->h_phone_unlisted;
          $elem['cell_unlisted'] = $member->w_phone_unlisted;
          $elem['email_unlisted'] = $member->email_unlisted;
          $elem['fname'] = $member->fname;
          $elem['lname'] = $member->lname;
          $member->address == NULL ? $elem['address'] = 'N/A' : $elem['address'] = $member->address;
          $member->city == NULL ? $elem['city'] = 'N/A' : $elem['city'] = $member->city;
          $member->state == NULL ? $elem['state'] = 'CA' : $elem['state'] = $member->state;
          $member->zip == NULL ? $elem['zip'] = '00000' : $elem['zip'] = $member->zip;
          $elem['id_mem_types'] = $member->id_mem_types;
          $elem['callsign'] = $member->callsign;
          $elem['license'] = $member->license;
          $elem['spouse_name'] = $member->spouse_name;
          $elem['spouse_call'] = $member->spouse_call;
          $member->email == NULL ? $elem['email'] = 'N/A' : $elem['email'] = $member->email;
          $elem['ok_mem_dir'] = $member->ok_mem_dir;
          $date_from = strtotime(strval(intval($cur_yr-1)) . '-10-01');
          $date_to = strtotime(strval($cur_yr) . '-12-31');
          $member->silent_date > 1 ? $elem['silent_date'] = date('Y-m-d', $member->silent_date) : $elem['silent_date'] = 'No Date';
          $elem['silent_year'] = $member->silent_year;
          $member->usr_type == 98 ? $elem['silent'] = TRUE : $elem['silent'] = FALSE;
    //Push all the current members including voting members (Spouse and Additional types)
          if(($member->cur_year >= $cur_yr  && $member->silent_date == 0 && strtolower($member->ok_mem_dir ?? '') == 'true')) {
            array_push($all_cur_members, $elem);
          }
        }
        array_multisort(array_column($all_cur_members, 'lname'), SORT_ASC, $all_cur_members);
        $retarr['dir'] = $all_cur_members;

        array_multisort(array_column($all_cur_members, 'callsign'), SORT_ASC, $all_cur_members);
        $retarr['callsigns'] = $all_cur_members;

        $param['date_start'] = time() - (60 * 60 * 24 * 30);
				$param['date_stop'] = time();

        $retarr['dir_cnt'] = $this->get_rep($param)['dir_cnt'];

        return $retarr;
  }

/**
* Puts data to csv and text files to download
*/
  private function put_files() {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $res = $builder->get()->getResult();

// put all members in csv
    $mem_str = "id,fname,lname,phone,cell phone,address,city,state,zip,email,mem type,callsign,license,cur yr,pay date,mem since,hard news,arrl,silent_date,comment\n";
    foreach ($res as $key => $mem) {
      if($mem->silent_date > 0) {
        $sil_date = date('Y/m/d', $mem->silent_date);
      }
      else {
        $sil_date = 0;
      }
      $mem_str .= $mem->id_members.",".$mem->fname.",".$mem->lname.",".$mem->h_phone.",".$mem->w_phone.","
                  .str_replace(","," ", $mem->address).",".$mem->city.",".$mem->state.",".$mem->zip.",".$mem->email.
                      ",".$mem->id_mem_types.",".$mem->callsign.",".$mem->license.",".$mem->cur_year.",".date('Y/m/d', $mem->paym_date).",".$mem->mem_since.",".
                      $mem->hard_news.",".$mem->arrl_mem.",".$sil_date."," . str_replace(","," ", $mem->comment) . "\n";
    }
    file_put_contents('files/all_members.csv', $mem_str);

// put members with one year overdue payments in csv and emails in txt
    $builder->resetQuery();
    $builder->where('cur_year', (date('Y', time())-1));
    $builder->where('silent_date', 0);
    $builder->orderBy('email', 'ASC');
    $res = $builder->get()->getResult();
    $emails = '';
    $mem_str = "id,fname,lname,phone,cell phone,address,city,state,zip,email,mem type,callsign,license,cur yr,pay date,mem since,hard news,arrl,comment\n";
    foreach ($res as $key => $mem) {
      if($mem->email != '') { $emails .= strtolower($mem->email ?? '') . ', '; }

      $mem_str .= $mem->id_members.",".$mem->fname.",".$mem->lname.",".$mem->h_phone.",".$mem->w_phone.","
                  .str_replace(","," ", $mem->address).",".$mem->city.",".$mem->state.",".$mem->zip.",".$mem->email.
                      ",".$mem->id_mem_types.",".$mem->callsign.",".$mem->license.",".$mem->cur_year.",".date('Y/m/d', $mem->paym_date).",".$mem->mem_since.",".
                      $mem->hard_news.",".$mem->arrl_mem.",". str_replace(","," ", $mem->comment) . "\n";

    }
    file_put_contents('files/pay_due.csv', $mem_str);
    file_put_contents('files/due-emails.txt', $emails);

//put emails of members who are two years behind emails in txt
    $builder->resetQuery();
    $builder->where('cur_year', (date('Y', time())-2));
    $builder->where('silent_date', 0);
    $builder->orderBy('email', 'ASC');
    $res = $builder->get()->getResult();
    $emails = '';
    foreach ($res as $key => $mem) {
      if($mem->email != '') { $emails .= strtolower($mem->email ?? '') . ', '; }
    }
    file_put_contents('files/due-emails-2.txt', $emails);

// all emails of current members
    $builder->resetQuery();
    $builder->where('cur_year >=', date('Y', time()));
    $builder->orderBy('email', 'ASC');
    $builder->where('silent_date', 0);
    $res = $builder->get()->getResult();
    $emails = '';
    foreach ($res as $key => $mem) {
      if($mem->email != '') { $emails .= strtolower($mem->email ?? '') . ', '; }
    }
    file_put_contents('files/cur-emails.txt', $emails);

// emails of current members to pay next year
    $builder->resetQuery();
    $builder->where('cur_year', date('Y', time()));
    $builder->where('silent_date', 0);
    $builder->orderBy('email', 'ASC');
    $res = $builder->get()->getResult();
    $emails = '';
    foreach ($res as $key => $mem) {
      if($mem->email != '') { $emails .= strtolower($mem->email ?? '') . ', '; }
    }
    file_put_contents('files/pay-next-emails.txt', $emails);
    $db->close();
  }

  public function get_mem($id) {
    $mem_types = $this->get_mem_types();
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_members', $id);
    $member = $builder->get()->getRow();
    $elem = array();
    if($member->parent_primary > 0) {
      $builder->resetQuery();
      $elem['id_parent'] = $member->parent_primary;
      $builder->where('id_members', $elem['id_parent']);
      $parent = $builder->get()->getRow();
      $elem['parent_fname'] = $parent->fname;
      $elem['parent_lname'] = $parent->lname;
    }
    else {
      $elem['id_parent'] = 0;
      $elem['parent_fname'] = '';
      $elem['parent_lname'] = '';
    }
    $db->close();
    $data_mod = new \App\Models\Data_model();
    $master_mod = new \App\Models\Master_model();
    $param['lic'] = $data_mod->get_lic();
    $param['mem_types'] = $master_mod->get_member_types();

    $elem['id'] = $member->id_members;
    $fam_mems = $this->get_fam_mems($elem['id']);
    $elem['fam_mems'] = $fam_mems['fam_mems'];
    $elem['fam_flag'] = $fam_mems['fam_flag'];

    $elem['carrier'] = trim(strtoupper($member->hard_news));
    $elem['dir'] = trim(strtoupper($member->hard_dir));
    $elem['arrl'] = trim(strtoupper($member->arrl_mem));
    $elem['mem_card'] = trim(strtoupper($member->mem_card));
    $member->h_phone == NULL ? $elem['h_phone'] = '000-000-0000' : $elem['h_phone'] = $member->h_phone;
    $member->w_phone == NULL ? $elem['w_phone'] = '000-000-0000' : $elem['w_phone'] = $member->w_phone;
    $member->comment == NULL ? $elem['comment'] = '' : $elem['comment'] = $member->comment;
    $elem['phone_unlisted'] = $member->h_phone_unlisted;
    $elem['cell_unlisted'] = $member->w_phone_unlisted;
    $elem['email_unlisted'] = $member->email_unlisted;
    $elem['fname'] = $member->fname;
    $elem['lname'] = $member->lname;
    $elem['mem_types'] = $mem_types;
    $member->address == NULL ? $elem['address'] = 'N/A' : $elem['address'] = $member->address;
    $member->city == NULL ? $elem['city'] = 'N/A' : $elem['city'] = $member->city;
    $member->state == NULL ? $elem['state'] = 'CA' : $elem['state'] = $member->state;
    $member->zip == NULL ? $elem['zip'] = '00000' : $elem['zip'] = $member->zip;
    $elem['active'] = $member->active;
    $member->cur_year == NULL ? $elem['cur_year'] = 'N/A' : $elem['cur_year'] = $member->cur_year;
    $elem['mem_type'] = $mem_types[$member->id_mem_types];
    $elem['id_mem_types'] = $member->id_mem_types;
    $elem['callsign'] = $member->callsign;
    $elem['license'] = $member->license;
    $elem['hard_news'] = strtoupper($member->hard_news);
    $elem['spouse_name'] = $member->spouse_name;
    $elem['spouse_call'] = $member->spouse_call;
    $elem['pay_date'] = date('Y-m-d', $member->paym_date);
    $elem['pay_date_file'] = date('Y/m/d', $member->paym_date);
    if($member->silent_date > 0 || $member->silent_year > 0) {
      $elem['silent_date'] = date('Y-m-d', $member->silent_date);  
      if($member->silent_date == 0) $elem['silent_date'] = $member->silent_year;    
    }
    else {
      $elem['silent_date'] = 0;
    }
    $member->mem_since == NULL ? $elem['mem_since'] = 'N/A' : $elem['mem_since'] = $member->mem_since;
    $member->email == NULL ? $elem['email'] = 'N/A' : $elem['email'] = $member->email;
    $elem['ok_mem_dir'] = $member->ok_mem_dir;
    //$member->silent_date > 1 ? $elem['silent_date'] = date('Y-m-d', $member->silent_date) : $elem['silent_date'] = 'No Date';
    $elem['silent_year'] = $member->silent_year;
    $member->usr_type == 98 ? $elem['silent'] = TRUE : $elem['silent'] = FALSE;

    return $elem;
  }

  private function get_mem_list() {
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('cur_year >', 99);
    $builder->where('silent_year', 0);
    $res = $builder->get()->getResult();
    $mem_types = $this->get_mem_types();
    $retarr = array();
    foreach ($res as $key => $member) {
      $elem = array();
      $elem['id'] = $member->id_members;

//get family members from member model
      $fam_mems = $this->get_fam_mems($elem['id']);
      $elem['fam_mems'] = $fam_mems['fam_mems'];
      $elem['fam_flag'] = $fam_mems['fam_flag'];

//set the true or false values for boolean db entries
      $elem['carrier'] = trim(strtoupper($member->hard_news));
      $elem['dir'] = trim(strtoupper($member->hard_dir));
      $elem['arrl'] = trim(strtoupper($member->arrl_mem));
      $elem['mem_card'] = trim(strtoupper($member->mem_card));
      $member->h_phone == NULL ? $elem['h_phone'] = '000-000-0000' : $elem['h_phone'] = $member->h_phone;
      $member->w_phone == NULL ? $elem['w_phone'] = '000-000-0000' : $elem['w_phone'] = $member->w_phone;
      $member->comment == NULL ? $elem['comment'] = '' : $elem['comment'] = $member->comment;
      $elem['phone_unlisted'] = $member->h_phone_unlisted;
      $elem['cell_unlisted'] = $member->w_phone_unlisted;
      $elem['email_unlisted'] = $member->email_unlisted;
      $elem['fname'] = $member->fname;
      $elem['lname'] = $member->lname;
      $elem['mem_types'] = $mem_types;
      $member->address == NULL ? $elem['address'] = 'N/A' : $elem['address'] = $member->address;
      $member->city == NULL ? $elem['city'] = 'N/A' : $elem['city'] = $member->city;
      $member->state == NULL ? $elem['state'] = 'CA' : $elem['state'] = $member->state;
      $member->zip == NULL ? $elem['zip'] = '00000' : $elem['zip'] = $member->zip;
      $elem['active'] = $member->active;
      $member->cur_year == NULL ? $elem['cur_year'] = 'N/A' : $elem['cur_year'] = $member->cur_year;
      $elem['mem_type'] = $mem_types[$member->id_mem_types];
      $elem['id_mem_types'] = $member->id_mem_types;
      $elem['callsign'] = $member->callsign;
      $elem['license'] = $member->license;
      $elem['hard_news'] = strtoupper($member->hard_news);
      $elem['spouse_name'] = $member->spouse_name;
      $elem['spouse_call'] = $member->spouse_call;
      $elem['pay_date'] = date('Y-m-d', $member->paym_date);
      $elem['pay_date_file'] = date('Y/m/d', $member->paym_date);
      $elem['silent_date'] = date('Y-m-d', $member->silent_date);
      $member->mem_since == NULL ? $elem['mem_since'] = 'N/A' : $elem['mem_since'] = $member->mem_since;
      $member->email == NULL ? $elem['email'] = 'N/A' : $elem['email'] = $member->email;
      $elem['ok_mem_dir'] = $member->ok_mem_dir;
      if($member->id_mem_types == 1 || $member->id_mem_types == 2) { array_push($retarr, $elem);}
    }
    array_multisort(array_column($retarr, 'lname'), SORT_ASC, $retarr);
    return $retarr;
  }

  public function update_cur_yr() {
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $res = $builder->get()->getResult();
    foreach($res as $mem) {
      $builder->resetQuery();
      $cur_yr = trim($mem->cur_year);
      if($cur_yr == '9999') {
        $cur_yr = '2035';
      }
      $builder->update(array('c_year' => strtotime(trim($cur_yr) . '/01/01')), ['id_members' => $mem->id_members]);
    }
    $db->close();
  }

/**
* Adds or edits a member
* @param mixed $param[] for db insert and update
* @return bool $retval whether or not the email param was ok
*/
  public function edit_mem($param) {
    $param['mem_type'] = $this->get_mem_type($param['id_mem_types']);
    $retval = TRUE;
    $id = $param['id'];
    unset($param['id']);
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('email', $param['email']);
    $builder->where('callsign', $param['callsign']);
    $builder->where('lname', $param['lname']);
    $builder->where('fname', $param['fname']);
    if($id != NULL) {
      $builder->resetQuery();
      $builder->update($param, ['id_members' => $id]);

  //must figure if primary member and update the family members as well
      $builder->resetQuery();
      $up_arr = array('paym_date' => $param['paym_date'],
                      'cur_year' => $param['cur_year']);
      $builder->update($up_arr, ['parent_primary' => $id]);

    }
    elseif(($builder->countAllResults() == 0) && $this->check_dups($param)) {
          $param['update_type'] = 'Initial insert';
          $param['mem_type'] = 'Individual';
          $param['mem_since'] = date('Y', time());
          $param['cur_year'] = date('Y', time());
          $param['ok_mem_dir'] = true;
          if(date('m', $param['paym_date']) > 9) $param['cur_year']++;
          $builder->resetQuery();
          $builder->insert($param);
        }
    else {
        $retval = FALSE;
      }
    $db->close();

    return $retval;
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
* Check for duplicate members within 5 years
*/
  private function check_dups($param) {
    $retval = TRUE;
    $db      = \Config\Database::connect();
    $builder = $db->table('old_mems_2020');
    $res = $builder->get()->getResult();
    foreach($res as $mem) {
      if(($param['email'] == $mem->email) && ((date('Y', time()) - 5) > $mem->cur_year)) {
          $retval = FALSE;
          break;
        }
    }
    return $retval;
  }

/**
* This doesn't delete a member, only inactivates by setting current year to 99
* @param int as id_members
*/
  public function delete_mem($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');

//must also inactivate the family members for primaries

    $builder->resetQuery();
    $builder->update(array('cur_year' => 99), ['id_members' => $id]);
    $builder->resetQuery();
    $builder->update(array('cur_year' => 99), ['parent_primary' => $id]);
  }

  /**
  * This re-instates member by setting the current year to this year
  * @param int as id_members
  */
  public function un_delete_mem($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->resetQuery();
    $builder->update(array('cur_year' => date('Y', time())), ['id_members' => $id]);
    $builder->resetQuery();
    $builder->update(array('cur_year' => date('Y', time())), ['parent_primary' => $id]);
  }

/**
* This copies the data with silent keys to the main table. Only temporary one time script
*/
  public function set_silents() {
    $db      = \Config\Database::connect();
    $builder = $db->table('tSilentKeys');
    $silents = $builder->get()->getResult();
    $db->close();
    $db      = \Config\Database::connect();
    $builder = $db->table('tSilentKeys');
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $mems = $builder->get()->getResult();
    foreach($silents as $silent) {
      $sil_callsign = $silent->cCallPrefix . $silent->cCallSuffix;
      foreach($mems as $mem) {
        if($sil_callsign == $mem->callsign) {
          $builder->resetQuery();
          $mem_arr = array(
            'callsign' => $sil_callsign
          );
          $builder->where('id_members', $mem->id_members);
          $builder->update($mem_arr);
        }
      }
    }
    $db->close();
  }

/**
* Set silent key if the member passed
*/
  public function set_silent($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $id = $param['id'];
    unset($param['id']);
    $builder->resetQuery();
    $builder->update($param, ['id_members' => $id]);
    $db->close();
  }

/**
* Unset silent key in case of mistake was made
*/
  public function unset_silent($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->resetQuery();
    $builder->update(array('usr_type' => 0, 'silent_date' => 0,
    'silent_year' => 0), ['id_members' => $id]);
    $db->close();
  }

  /**
	* Temporary routine to verify payments
  * To do: should return some data how many records was corrected
	*/
  public function verify_payment() {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $mem_rec = $builder->get()->getResult();
    $builder->resetQuery();
    $builder = $db->table('paid_2021');
    $paid_rec = $builder->get()->getResult();
    $retarr = array();
    foreach($mem_rec as $mem) {
      foreach($paid_rec as $paid) {
        $name_arr = explode(",", $paid->Name);
        $paid_fname = trim($name_arr[1]);
        $paid_lname = trim($name_arr[0]);
        if(($mem->fname == $paid_fname && $mem->lname == $paid_lname) && $mem->cur_year < date('Y', time())) {
          $pay_date = strtotime($paid->Date);
          $builder = $db->table('tMembers');
          $builder->resetQuery();
          $builder->update(array('cur_year' => date('Y', time()), 'paym_date' => $pay_date), ['id_members' => $mem->id_members]);
          $paid_arr =array();
          $paid_arr['fname'] = $paid_fname;
          $paid_arr['lname'] = $paid_lname;
          $paid_arr['pay_date'] = $paid->Date . ' | ' . $pay_date;
          array_push($retarr, $paid_arr);
        }
      }
    }
    $db->close();
    return $retarr;
  }

	public function get_mem_types() {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMemTypes');
    $builder->orderBy('id_mem_types', 'DESC');
    $types = $builder->get()->getResult();
    $retarr = array();
    foreach($types as $type) {
      $retarr[$type->id_mem_types] = $type->description;
    }
    $db->close();
    return $retarr;
	}

/**
* Returns the type description
*/
  public function get_mem_type($type) {
    $types = $this->get_mem_types();
    return $types[$type];
  }

  /**
  * Returns the new members for a given period
  * @param int from date via unix timestamp
  * @param int to date via unix timestamp
  * @return array the member data
  */
  public function get_new_mems($from, $to) {
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    //$builder->where('paym_date >', $from);
    //$builder->where('paym_date <', $to);
    //$builder->where('mem_since', date('Y', time()));
    //echo '<br><br><br><br>to: ' . $to;
    $builder->where('mem_since', date('Y', $to));
    $db->close;
    $res = $builder->get()->getResult();
    $retarr = array();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    return $retarr;
  }

/**
* Returns renewals for a given period
* @param int from date via unix timestamp
* @param int to date via unix timestamp
* @return array the member data
*/
  public function get_renewals($from, $to) {
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('paym_date >', $from);
    $builder->where('paym_date <', $to);
    $builder->where('mem_since <', date('Y', $to));
    //$builder->where('id_mem_types', 1);
    //$builder->orWhere('id_mem_types', 2);
    //echo '<br><br><br> this yr: ' . date('Y', $to);
    //echo '<br>from: ' . $from . ' / ' . date('Y-m-d', $from);
    //echo '<br>to: ' . $to . ' / ' . date('Y-m-d', $to);
    $db->close;
    $res = $builder->get()->getResult();
    $retarr = array();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    return $retarr;
  }

  public function get_renewals_year($to) {
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('paym_date >', $to);
    $builder->where('mem_since <', $to);
    $builder->where('cur_year', date('Y', $to));
    $builder->where('id_mem_types', 1);
    $db->close;
    $res = $builder->get()->getResult();
    $retarr = array();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('paym_date >', $to);
    $builder->where('mem_since <', $to);
    $builder->where('cur_year', date('Y', $to));
    $builder->where('id_mem_types', 2);
    $db->close;
    $res = $builder->get()->getResult();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    $db->close;
    return $retarr;
  }

  public function get_rep($param) {
    $this->data_mod = new \App\Models\Data_model();
    //$retarr['dir_cnt'] = count($this->get_cur_mems($param));
    $retarr['dir_cnt'] = count($this->get_all_mems($param['date_stop']));
    $retarr['cnt_cur'] = count($this->get_paying_mems($param));
		$param['states'] = $this->data_mod->get_states_array();
    $retarr['date_start'] = date('Y-m-d', intval($param['date_start']));
    $retarr['date_stop'] = date('Y-m-d', intval($param['date_stop']));
    $retarr['renewals_period'] = count($this->get_renewals($param['date_start'], $param['date_stop']));
    $retarr['new_mems_period'] = count($this->get_new_mems($param['date_start'], $param['date_stop']));
    $retarr['cnt_renew'] = count($this->get_renewals_year($param['date_stop']));
    $retarr['cnt_pay'] = count($this->get_pay_dues($param['date_stop']));
    $retarr['cnt_hons'] = count($this->get_hon_mems());
    $new_mems_arr = $this->new_mems($param);
    $retarr['new_mems'] = $new_mems_arr['new_mems'];
    $retarr['renewals'] = $new_mems_arr['renewals'];
    return $retarr;
  }

  public function purge_mem($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('parent_primary', $id);

// we must also purge the family members for the primary member
    $res = $builder->get()->getResult();
    foreach($res as $child) {
      $builder->resetQuery();
      $builder->delete(['id_members' => $child->id_members]);
    }

    $builder->resetQuery();
    $builder->delete(['id_members' => $id]);
  }

  private function get_all_mems($to) {
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $cur_yr = date('Y', $to);
    $builder->where('cur_year >=', $cur_yr);
    $builder->where('cur_year <', 9999);
    $res = $builder->get()->getResult();
    $retarr = array();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    return $retarr;
  }

  private function get_pay_dues($to) {
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_mem_types', 1);
    $builder->where('cur_year', (date('Y', $to)-1));
    $res = $builder->get()->getResult();
    $retarr = array();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }

    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('id_mem_types', 2);
    $builder->where('cur_year', (date('Y', time())-1));
    $res = $builder->get()->getResult();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }

    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('id_mem_types', 5);
    $builder->where('cur_year', (date('Y', time())-1));
    $res = $builder->get()->getResult();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    $db->close;
    return $retarr;
  }

  private function get_cur_mems($param) {
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('cur_year', date('Y', $param['date_stop']));
    $res = $builder->get()->getResult();
    $retarr = array();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    $db->close;
    return $retarr;
  }

  private function get_hon_mems() {
    $this->data_mod = new \App\Models\Data_model();
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('cur_year', 9999);
    $res = $builder->get()->getResult();
    $retarr = array();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    return $retarr;
  }

  private function get_paying_mems($param) {

    $this->data_mod = new \App\Models\Data_model();
    $db = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_mem_types', 1);
    $builder->where('cur_year >=', date('Y', $param['date_stop']));
    $builder->where('cur_year <', 9999);

    $res = $builder->get()->getResult();
    $retarr = array();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }

    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('id_mem_types', 2);
    $builder->where('cur_year >=', date('Y', $param['date_stop']));
    $builder->where('cur_year <', 9999);
    $res = $builder->get()->getResult();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }

    $db->close;
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('id_mem_types', 5);
    $builder->where('cur_year >=', date('Y', $param['date_stop']));
    $builder->where('cur_year <', 9999);
    $res = $builder->get()->getResult();
    foreach($res as $mem) {
      $mem_arr = array(
        'id' => $mem->id_members,
        'fname' => $mem->fname,
        'lname' => $mem->lname,
        'callsign' => $mem->callsign,
        'license' => $mem->license,
        'payment_date' => $mem->paym_date
      );
      array_push($retarr, $mem_arr);
    }
    $db->close;
    return $retarr;
  }

    public function get_fam_mems($id) {
      $db      = \Config\Database::connect();
      $builder = $db->table('tMembers');
      $db->close();
      $builder->where('parent_primary', $id);
      $retarr = array();
      $retarr['fam_mems'] = array();
      if($builder->countAllResults() > 0) {
        $builder->resetQuery();
        $builder->where('parent_primary', $id);
        $res = $builder->get()->getResult();
        foreach($res as $mem) {
          $fam_mem = $this->get_fam_mem($mem->id_members);
          array_push($retarr['fam_mems'], $this->get_fam_mem($mem->id_members));
        }
      }
      count($retarr['fam_mems']) > 0 ? $retarr['fam_flag'] = TRUE : $retarr['fam_flag'] = FALSE;
      return $retarr;
    }

    public function get_fam_mem($id) {
      $db      = \Config\Database::connect();
      $builder = $db->table('tMembers');
      $builder->where('id_members', $id);
      $db->close();
      $elem = array();
      if($builder->countAllResults() > 0) {
        $builder->resetQuery();
        $builder->where('id_members', $id);
        $member = $builder->get()->getRow();
        $elem['id_members'] = $id;

    //set the true or false values for boolean db entries
        $elem['carrier'] = trim(strtoupper($member->hard_news));
        $elem['dir'] = trim(strtoupper($member->hard_dir));
        $elem['arrl'] =  trim(strtoupper($member->arrl_mem));
        $elem['mem_card'] = trim(strtoupper($member->mem_card));
        $member->h_phone == NULL ? $elem['h_phone'] = '000-000-0000' : $elem['h_phone'] = $member->h_phone;
        $member->w_phone == NULL ? $elem['w_phone'] = '000-000-0000' : $elem['w_phone'] = $member->w_phone;
        $member->comment == NULL ? $elem['comment'] = '' : $elem['comment'] = $member->comment;
        $elem['phone_unlisted'] = $member->h_phone_unlisted;
        $elem['cell_unlisted'] = $member->w_phone_unlisted;
        $elem['email_unlisted'] = $member->email_unlisted;
        $elem['fname'] = $member->fname;
        $elem['lname'] = $member->lname;
        $member->address == NULL ? $elem['address'] = 'N/A' : $elem['address'] = $member->address;
        $member->city == NULL ? $elem['city'] = 'N/A' : $elem['city'] = $member->city;
        $member->state == NULL ? $elem['state'] = 'CA' : $elem['state'] = $member->state;
        $member->zip == NULL ? $elem['zip'] = '00000' : $elem['zip'] = $member->zip;
        $elem['active'] = $member->active;
        $member->cur_year == NULL ? $elem['cur_year'] = 'N/A' : $elem['cur_year'] = $member->cur_year;
        $elem['mem_type'] = $member->mem_type;
        $elem['callsign'] = $member->callsign;
        $elem['license'] = $member->license;
        $elem['cur_year'] = $member->cur_year;
        $elem['hard_news'] = $member->hard_news;
        $elem['spouse_name'] = $member->spouse_name;
        $elem['spouse_call'] = $member->spouse_call;
        $elem['pay_date'] = date('Y-m-d', $member->paym_date);
        $elem['pay_date_file'] = date('Y/m/d', $member->paym_date);
        $elem['silent_date'] = date('Y-m-d', $member->silent_date);
        $member->mem_since == NULL ? $elem['mem_since'] = 'N/A' : $elem['mem_since'] = $member->mem_since;
        $member->email == NULL ? $elem['email'] = 'N/A' : $elem['email'] = $member->email;
        $elem['ok_mem_dir'] = $member->ok_mem_dir;
        $cur_yr = date('Y', time());
        $elem['silent_date'] = '';
        $elem['silent_year'] = $member->silent_year;
        $member->usr_type == 98 ? $elem['silent'] = TRUE : $elem['silent'] = FALSE;
      }
      else {
        $elem = NULL;
      }
      return $elem;
    }

    public function get_faqs() {
      $db      = \Config\Database::connect();
      $builder = $db->table('faqs');
      $cnt = $builder->countAllResults();
      $retarr = array();
      $retarr['faqs'] = array();
      if($cnt > 0) {
        $builder->resetQuery();
        $res = $builder->get()->getResult();
        $login_mod = new \App\Models\Login_model();
        foreach ($res as $key => $faq) {
          $elem = array();
          $elem['id'] = $faq->id_faqs;
          $elem['theq'] = $faq->theq;
          $elem['thea'] = $faq->thea;
          $elem['id_user_type'] = $faq->id_user_type;
          $elem['id_user'] = $faq->id_user;
          $usr_arr = $login_mod->get_user_arr($elem['id_user']);
          $elem['fname'] = $usr_arr['fname'];
          $elem['lname'] = $usr_arr['lname'];
          array_push($retarr['faqs'], $elem);
        }
      }
      else {
        $retarr['faqs'] = NULL;
      }
      $user_mod = new \App\Models\User_model();
      $retarr['mem_types'] = $user_mod->get_user_types();
      return $retarr;
    }

    public function edit_faq($param) {
      $id = $param['id'];
      unset($param['id']);
      $db      = \Config\Database::connect();
      $builder = $db->table('faqs');
      $cnt = $builder->countAllResults();
      $builder->resetQuery();
      if($cnt > 0) {
        $id != NULL ? $builder->update($param, ['id_faqs' => $id]) : $builder->insert($param);
      }
      else {
        $builder->insert($param);
      }

      $db->close();
    }

    public function delete_faq($id) {
      $db      = \Config\Database::connect();
      $builder = $db->table('faqs');
      $builder->where('id_faqs', $id);
      $builder->resetQuery();
      $builder->delete(['id_faqs' => $id]);
    }

    /**
    * Get those who are current members and subscribed to The Carrier
    */
    public function get_carrier() {
      $db      = \Config\Database::connect();
      $builder = $db->table('tMembers');
      $builder->where('hard_news', 'true');
      $builder->where( 'cur_year >', 2021);
      $builder->orderBy('lname', 'ASC');
      $res = $builder->get()->getResult();
      $retarr = array();
      foreach ($res as $key => $mem) {
        $mem_arr = array();
        $mem_arr['id'] = $mem->id_members;
        $mem_arr['fname'] = $mem->fname;
        $mem_arr['lname'] = $mem->lname;
        $mem_arr['callsign'] = $mem->callsign;
        $mem_arr['address'] = $mem->address;
        $mem_arr['city'] = $mem->city;
        $mem_arr['state'] = $mem->state;
        $mem_arr['zip'] = $mem->zip;
        array_push($retarr, $mem_arr);
      }
      $db->close();
      return $retarr;
  }

  private function new_mems($param) {
    $retarr['new_mems'] = NULL;
    $retarr['renewals'] = NULL;

    return $retarr;
  }
}
