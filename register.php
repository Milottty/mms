<?php include_once 'header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    background-color: #121212;
    color: #fff;
  }

  .form-container {
    background-color: #1e1e1e;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    margin-top: 50px;
  }

  .form-label {
    color: #ccc;
  }

  .form-control,
  .form-select {
    background-color: #292929;
    border: 1px solid #444;
    color: #fff;
  }

  .form-control:focus,
  .form-select:focus {
    background-color: #292929;
    color: #fff;
    border-color: #666;
    box-shadow: none;
  }

  .btn-primary {
    background-color: #dc3545;
    border-color: #dc3545;
  }

  .btn-primary:hover {
    background-color: #c82333;
    border-color: #bd2130;
  }

  .card {
    background-color: #1e1e1e;
    border-radius: 20px;
  }

  .text-black {
    color: #fff !important;
  }
</style>

<section class="vh-100">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4" style="color: #fff;">Sign Up</p>

                <form class="mx-1 mx-md-4" method="POST" action="registerLogic.php" enctype="multipart/form-data">

                  <div class="mb-4">
                    <label class="form-label">Your Name</label>
                    <input type="text" name="emri" class="form-control" required />
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required />
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Your Email</label>
                    <input type="email" name="email" class="form-control" required />
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required />
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Repeat your password</label>
                    <input type="password" name="confirm_password" class="form-control" required />
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="profile_image" class="form-control" accept="image/*" required />
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg">Register</button>
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <img src="img/draw1.webp" class="img-fluid" alt="Sample image">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include_once 'footer.php'; ?>
