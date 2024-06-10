
<?php 
session_start();
if(isset($_SESSION['login']) )
{
    header("Location:404.html");
    exit;
}
require 'koneksi.php';
include "functions.php";

if(! isset($_GET['kategori']) &&  !isset($_POST['judul']))
{
    $query = "SELECT * FROM blog" ;
$result = mysqli_query($koneksi,$query);
   
}
else if( isset($_GET['kategori']) )
{
    $id_kategori = $_GET['kategori'];
    $query = "SELECT * FROM blog where id_kategori = $id_kategori " ;
    $result = mysqli_query($koneksi,$query);
}
else if( isset($_POST['judul']) )
{
    $judul = $_POST['judul'];

    $query = "SELECT * FROM blog where judul = '$judul' " ;
    $result = mysqli_query($koneksi,$query);
}


$query2 = "SELECT * FROM kategori ";
$result2 = mysqli_query($koneksi,$query2);
 ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Home - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/style.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#!">Blog Pribadi</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Blog</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Selamat Datang Diblog Pribadi</h1>
                    <p class="lead mb-0">Blog Dengan Berbagai Kategori Yang Menarik</p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                   
                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <div class="col-lg-6">
                                <!-- Blog post-->
                                <div class="card mb-4">
                                    <a href="#!"><img class="card-img-top" src="img/blog/<?= $row['gambar'] ; ?>" alt="..." /></a>
                                    <div class="card-body">
                                        <div class="small text-muted"><?= $row['tanggal'] ; ?></div>
                                        <h2 class="card-title h4"><?= $row['judul'] ; ?></h2>
                                        <p class="card-text"><?= limit_words($row['pembahasan'], 20) ; ?></p>
                                        <a class="btn btn-primary" href="show-blog.php?id=<?= $row['id_blog'] ; ?>">Read more →</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile ; ?>
                        
                    </div>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <form action="" method="post">
                            <div class="input-group">
                                <input class="form-control" name="judul" type="text" placeholder="Masukan Judul.." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                            <?php while($row = mysqli_fetch_assoc($result2)): ?>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="index.php?kategori=<?= $row['id_kategori'] ; ?>"><?= $row['nama_kategori'] ; ?></a></li>
                                    </ul>
                                </div>
                                <?php endwhile ; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Blog Pribadi 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>