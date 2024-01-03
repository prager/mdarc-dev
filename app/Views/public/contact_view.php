<section id="learn" class="p-5">
  <div class="container">

    <form action="/index.php/send-contact" method="post" id="contactForm" onSubmit="onSubmit(event)">
    
    <div class="row pt-5">
      <div class="col-lg-8 offset-lg-2">
        <h3>Send Us a Message</h3>
      </div>
    </div>
    <!-- Name input v1 -->
    <div class="row pt-2">
      <div class="col-lg-4 offset-lg-2">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name" required>
      </div>
      <div class="col-lg-4">
        <label for="fname">Last Name</label>
        <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name" required>
      </div>
    </div>
    <!-- Email address input -->
        <div class="row pt-3">
          <div class="col-lg-8 offset-lg-2">
            <label class="form-label" for="email">Email Address</label>
            <input class="form-control" id="email" name="email" type="email" placeholder="Email Address" required>
          </div>
        </div>
        <!-- Message input -->
        <div class="row pt-3">
          <div class="col-lg-8 offset-lg-2">
            <label class="form-label" for="message">Message</label>
            <textarea class="form-control" id="msg" name="msg" type="text" placeholder="Message" style="height: 10rem;" required></textarea>
          </div>
        </div>
        <div class="row py-5">
          <div class="col-lg-4 offset-lg-4 pb-5">
            <!-- Form submit button -->
            <div class="d-grid">
            <!-- <input type="hidden" id="recaptcha_response" name="recaptcha_response" value=""> -->
              <button class="btn btn-primary btn-lg" type="submit">Submit</button>
            </div>
          </div>
        </div>
  </form>
  </div>
</section>
