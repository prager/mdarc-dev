<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Sent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="<?php echo base_url() ;?>/assets/img/mdarc-icon.ico" type="image/x-icon" />
   
  </head>
  <body>
  <div class="container my-5">
        <div class="p-5 text-center bg-body-tertiary rounded-3">
            <h1 class="text-body-emphasis">Email Sent!</h1>
            <p class="lead">Thank you for supporting MDARC!</p><br>
            <p>Status: <?php echo $status; ?></p><br>
            <a href="https://mdarc.jlkconsulting.info" class="btn btn-outline-secondary"> MDARC Membership Portal </a><br>
        </div>
    </div>
    
  </body>
</html>