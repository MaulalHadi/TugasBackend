
<?php 

session_start();
if(isset($_SESSION['login']))
{
    header("Location:404.html");
    exit;
}
 $_SESSION['judul'] = "Halaman Login";
  include 'asset/headerakses.php';
  include 'functions.php';
  include 'koneksi.php';
// pengecekan Login
  if(isset($_POST['submit']))
  {

    login($_POST);
  }

  
; ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                   
                                       
                                    
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome !</h1>
                                    </div>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" required aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" required placeholder="Password">
                                        </div>
                                      
                                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                        
                                       
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                        <a class="small" href="index.php">Blog!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
    <?php 
  include 'asset/footerakses.php';
; ?>



