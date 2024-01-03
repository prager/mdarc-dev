<section id="learn" class="p-5">
  <div class="container">
    <form action="<?php echo base_url() . '/index.php/send-renew/' . $id_members; ?>" method="post">
    <div class="row mt-5">
      <div class="col-md-6 offset-md-1">
        <h5>Renew Your MDARC Membership</h5>
        <small>Fields marked with (*) are required</small>        
      </div>
    </div>
    <?php if($msg != '') {?>
      <div class="row mt-3">
        <div class="col-md-8 mt-3">
          <p><?php echo $msg; ?></p>
        </div>
      </div>
    <?php }?>

    <div class="row">
        <div class="col-md offset-md-1">
        
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item col-md-8">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <a href="#" class="accordion-button collapsed text-decoration-none text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Membership Costs - For Details Click to Expand</a></h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">                            
                            <div class="row mt-2">
                                <div class="col">
                                    Individual or Family membership renewals (All living at the same address): <strong>$45.00</strong><br />
                                    <small><em>Valid for all of the current year. Family members are full members, but a family receives only one copy of the newsletter.</em></small>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    Student membership (must provide copy of student ID to Membership Chair): <strong>$15.00</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md offset-md-1">
            
        </div>
    </div>
    <div class="row">
      <div class="col-md-4 offset-md-1">
        <label for="fname">First Name *</label>
        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" required>
      </div>
      <div class="col-md-4">
        <label for="lname">Last Name *</label>
        <input type="text" class="form-control" id="lname" name="lname"  value="<?php echo $lname; ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-4 offset-md-1">
        <label for="email">Email *</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
      </div>
      <div class="col-md-4">
        <label for="callsign">Callsign</label>
        <input type="text" class="form-control" id="callsign" name="callsign"  value="<?php echo $callsign; ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-4 offset-md-1">
        <label for="phone">Cell Phone </label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
      </div>
      <div class="col-lg-4">
        <label for="sel_lic">License Type</label>
            <select class="form-select" name="sel_lic">
              <?php
                foreach($lic as $lc) {
                  if($lc == $license) { ?>
                    <option value="<?php echo $license; ?>" selected><?php echo $license; ?></option>
              <?php    }
                  else { ?>
                    <option value="<?php echo $lc; ?>"><?php echo $lc; ?></option>
              <?php }
                }
              ?>
            </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-4 offset-md-1">
        <label for="street">Street Address *</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo $street; ?>" required>
      </div>
      <div class="col-md-4">
            <label for="sel_lic">Member Type</label>
            <select class="form-select" name="mem_types">
              <?php
                foreach($mem_types as $key => $type) {
                  if($id_mem_types == $key) {?>
                    <option value="<?php echo $key; ?>" selected><?php echo $type['description']; ?></option>
                  <?php }
                  else { ?>
                    <option value="<?php echo $key; ?>"><?php echo $type['description']; ?></option>
              <?php  }
                }
              ?>
            </select>
          </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-4 offset-md-1">
        <label for="city">City *</label>
        <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>" required>
      </div>
      <div class="col-md-2">
        <label for="callsign">State</label>
        <select class="form-select" name="state_cd" aria-label="Select State">
          <?php
            foreach($states as $state) {
              if($state == $states[$state_cd]) {?>
              <option selected value="<?php echo key($states); ?>"><?php echo $state; ?></option>
            <?php }
              else { ?>
              <option value="<?php echo key($states); ?>"><?php echo $state; ?></option>
            <?php
                }
            next($states);
              }?>
        </select>
      </div>
      <div class="col-md-2">
        <label for="zip">Zip *</label>
        <input type="text" class="form-control" id="zip_cd" name="zip_cd" placeholder="Enter Zipcode" value="<?php echo $zip_cd; ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-3 offset-md-1">
        <div class="form-check">
          <label class="form-check-label" for="carrier"> Carrier Copy ($18.00) </label>
          <input class="form-check-input" type="checkbox" id="carrier" name="carrier" value="add_carrier" />
          <input type="hidden" name="mdarc-mem" value="public_renew">
          <input type="hidden" name="mem_since" value="<?php echo $mem_since; ?>">
          <input type="hidden" name="cur_year" value="<?php echo $cur_year; ?>">
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-lg-8 offset-md-1">
          <hr>
          <h5>Donations</h5>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-lg-4 offset-md-1">
        <label for="repeater">Repeater</label>
        <input type="text" class="form-control" name="repeater" value="$0.00">
      </div>
      <div class="col-lg-4">
        <label for="mdarc_donation">MDARC</label>
        <input type="text" class="form-control" name="mdarc_donation" value="$0.00">
      </div>
    </div>
    <div class="row my-5">
      <div class='col-lg-6 offset-md-1'>
        <input class="btn btn-primary" type="submit" value=" Submit Your Renewal">
      </div>
    </div>
    </div>
  </form>
</section>
