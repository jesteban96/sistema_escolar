<?php require_once INCLUDES.'inc_header_minimal.php'; ?>

<div class="container">

  <!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
          <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">
                      <?php echo sprintf('¡Bienvenido a %s!',get_sitename());?>
                    </h1>
                </div>
                <?php echo Flasher::flash(); ?>
                <form class="user" action="login/post_login" method="post">
                  <?php echo insert_inputs(); ?>  
                    <div class="form-group">
                      <input name="email" type="email" class="form-control form-control-user"
                        id="email" aria-describedby="emailHelp"
                        placeholder="Enter Email Address..." require>
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control form-control-user"
                          id="password" placeholder="Password" require>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit" >
                      Ingresar</button>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  </div>
</div>

<?php require_once INCLUDES.'inc_footer_minimal.php'; ?>

