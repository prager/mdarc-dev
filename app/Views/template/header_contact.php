<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- Option 1: Include in HTML -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="/img/mdarc-icon.ico" type="image/x-icon">
  <title>MDARC Membership</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>"></script>
  <!-- Include script -->
  <!-- <script type="text/javascript">

  function onSubmit(e) {
      e.preventDefault();
      grecaptcha.ready(function() {
          grecaptcha.execute("<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>", {action: 'submit'}).then(function(token) {

                // Store recaptcha response
                document.getElementById("recaptcha_response").value = token;

                // Submit form
                document.getElementById("contactForm").submit();

          });
      });
  }

</script> -->
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light navbar-light py-2 fixed-top">
  <div class="container">
      <a href="<?php echo base_url(); ?>" class="navbar-brand"><img src="/img/mdarc-avatar.jpg" alt="Logo" style="width:40px;" class="rounded-pill"> MDARC Members Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                  <a href="<?php echo base_url(); ?>" class="nav-link">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="helpMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  MDARC Memberships
                </a>
                <ul class="dropdown-menu" aria-labelledby="helpMenu">
                  <li class="nav-link"><a href="<?php echo base_url() . '/index.php/add-mem/new-member'; ?>" class="dropdown-item"> &nbsp; Join MDARC</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li class="nav-link"><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#renewMem"> &nbsp; Renew Membership</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li class="nav-link"><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#goDonate"> &nbsp; Donate to MDARC</a></li>
                </ul>
              </li>
              <li class="nav-item">
                  <a href="<?php echo base_url() . '/index.php/contact'; ?>" class="nav-link">Contact</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="helpMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  About
                </a>
                <ul class="dropdown-menu" aria-labelledby="helpMenu">
                  <li class="nav-link"><a ><a href="<?php echo base_url() . '/index.php/faqs'; ?>" class="dropdown-item"> &nbsp; FAQs</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li class="nav-link"><a href="#" data-bs-toggle="modal" data-bs-target="#tech" class="dropdown-item"> &nbsp; About</a></li>
                </ul>
              </li>
              <li class="nav-item">
                  <a href="#"  data-bs-toggle="modal" data-bs-target="#login" class="nav-link"> Login <i class="bi bi-person"></i></a>
              </li>
          </ul>
      </div>
  </div>
</nav>
