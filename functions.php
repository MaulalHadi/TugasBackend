
<html>
<script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../alert/dist/sweetalert2.all.min.js"></script>
</html>
<?php 
require 'koneksi.php';



function registrasi($data){
    global $koneksi;

    $email = stripslashes( $data['email']);
    $deskripsi = htmlspecialchars( $data['deskripsi']);
    $nama = htmlspecialchars( $data['nama']);
    $password = mysqli_real_escape_string($koneksi,$data['pass1']);
    $password2 = mysqli_real_escape_string($koneksi,$data['pass2']);
   
    //cek konfirm pass

    if($password != $password2)
    {
        echo "
        <script>alert('Konfirm Password Tidak Sesuai');</script>
        ";
        return false;
    }

    //Cek Email

    $result = mysqli_query($koneksi,"SELECT email FROM user WHERE email ='$email'");

    if(mysqli_fetch_assoc($result))
    {
       
        echo "
        <script>alert('Email Sudah Pernah Digunakan');</script>
        ";
        return false;
    }
    else{

          //enkripsi password
        $pass = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO user VALUES('','$nama','$email','$deskripsi','$pass','2')";

        mysqli_query($koneksi,$query);
        echo "
        <script>alert('Berhasil Register, Silakan Login');window.location.href = 'login.php';</script>
        ";

    }
    return mysqli_affected_rows($koneksi);
}

function login($data)
{    global $koneksi;
  
    $email = $data['email'];
    $password = $data['password'];

    $result  = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
  
    if(mysqli_num_rows($result) === 1 )
    {
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password,$row['password']))
        {
            $status = $row['status'];
            $email = $row['email'];
            $id_user = $row['id_user'];
            $_SESSION['login'] = true;
            $_SESSION['status'] = $status;
            $_SESSION['email'] = $email;
            $_SESSION['id_user'] = $id_user;

            if( $status == '1')
            {
                header("Location:admin/dashboard.php");
            }
            else if( $status == '2')
            {
                header("Location:blogger/blogger.php");
            }
            exit;
        }
        else
        {
            echo "
            <script>alert('Maaf Password Salah'); window.location.href = 'index.php';</script>
            ";
            exit;
        }
    }
    else
    {
        echo "
        <script>alert('Maaf Username Salah'); window.location.href = 'index.php';</script>
        ";
        exit;
    }
}
function limit_words($string, $word_limit) {
    $words = explode(' ', $string);
    return implode(' ', array_slice($words, 0, $word_limit));
}

function edituser($data)
{
    global $koneksi;
    $id = htmlspecialchars($data['id']);
    $nama = htmlspecialchars($data['nama']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
  
    /* Insert Data */
    $query = "UPDATE user SET
              nama = '$nama',
              deskripsi = '$deskripsi'
              WHERE id_user = '$id'";

    mysqli_query($koneksi,$query);
    return mysqli_affected_rows($koneksi);
}


function editkategori($data)
{
    global $koneksi;
    $id = htmlspecialchars($data['id']);
    $nama = htmlspecialchars($data['nama']);
    
       //Cek Email

       $result = mysqli_query($koneksi,"SELECT nama_kategori FROM kategori WHERE nama_kategori ='$nama'");

       if(mysqli_fetch_assoc($result))
       {
          
           echo "
           <script>alert('Nama Sudah Pernah Digunakan');</script>
           ";
           return false;
       }
       else{
        /* Insert Data */
        $query = "UPDATE kategori SET
                nama_kategori = '$nama'
                WHERE id_kategori = '$id'";

        mysqli_query($koneksi,$query);
       }
    return mysqli_affected_rows($koneksi);
}

/* Tambah Data */
 function tambahblog($data)
{
    global $koneksi;
    $judul = htmlspecialchars($data['judul']);
    $pembahasan = htmlspecialchars($data['pembahasan']);
    $kategori = htmlspecialchars($data['kategori']);
    $id_user = $_SESSION['id_user'];
    $tanggal = date("d-m-Y");
    /* Upload Gambar */
    $gambar = upload();
    if (!$gambar)
    {
        return false;
    }

    // echo $kategori;
    // exit;
    /* Insert Data */
    $query = "INSERT INTO blog VALUES('','$id_user','$kategori','$judul','$pembahasan','$gambar','$tanggal')";
    mysqli_query($koneksi,$query);
    return mysqli_affected_rows($koneksi);
}


function tambahpetugas($data){
    global $koneksi;

    $email = stripslashes( $data['email']);
    $nama = htmlspecialchars( $data['nama']);
    $deskripsi = htmlspecialchars( $data['deskripsi']);
    $password = mysqli_real_escape_string($koneksi,$data['pass1']);
    $password2 = mysqli_real_escape_string($koneksi,$data['pass2']);
    $hash = hash('sha256', '123456789abcdefghijklmnopq');
   
    //cek konfirm pass

    if($password != $password2)
    {
        echo "
        <script>alert('Konfirm Password Tidak Sesuai');</script>
        ";
        return false;
    }

    //Cek Email

    $result = mysqli_query($koneksi,"SELECT email FROM user WHERE email ='$email'");

    if(mysqli_fetch_assoc($result))
    {
       
        echo "
        <script>alert('Email Sudah Pernah Digunakan');</script>
        ";
        return false;
    }
    else{

          //enkripsi password
        $pass = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO user VALUES('','$nama','$email','$deskripsi','$pass','1')";

        mysqli_query($koneksi,$query);

    }
    return mysqli_affected_rows($koneksi);
}
function tambahkategori($data){
    global $koneksi;

    $nama = stripslashes( $data['nama']);
   
 

    //Cek Email

    $result = mysqli_query($koneksi,"SELECT nama_kategori FROM kategori WHERE nama_kategori ='$nama'");

    if(mysqli_fetch_assoc($result))
    {
       
        echo "
        <script>alert('Nama Sudah Pernah Digunakan');</script>
        ";
        return false;
    }
    else{
        
        $query = "INSERT INTO kategori VALUES('','$nama')";

        mysqli_query($koneksi,$query);

    }
    return mysqli_affected_rows($koneksi);
}
/* Akhir Tambah */

/* Edit Data */
function editblog($data)
{
    global $koneksi;
    $id = htmlspecialchars($data['id']);
    $judul = htmlspecialchars($data['judul']);
    $pembahasan = htmlspecialchars($data['pembahasan']);
    $kategori = htmlspecialchars($data['kategori']);
    $gambarlama = htmlspecialchars($data['gambarlama']);
    $eror = $_FILES['gambar']['error'];

    if($eror == 4)
    {
        $gambar = $gambarlama;
    }
    else
    {
        if(file_exists('../img/blog/'.$gambarlama))
        {
            unlink('../img/blog/'.$gambarlama);
        }
        $gambar = upload();
    }
    /* Upload Gambar */
    
    if (!$gambar)
    {
        return false;
    }
   
    /* Insert Data */
    $query = "UPDATE blog SET
              id_kategori = '$kategori',
              judul = '$judul',
              pembahasan = '$pembahasan',
              gambar = '$gambar'
              WHERE id_blog = '$id'";

    mysqli_query($koneksi,$query);
    return mysqli_affected_rows($koneksi);
}



function editpetugas($data)
{
    global $koneksi;
    $id = htmlspecialchars($data['id']);
    $email = stripslashes( $data['email']);
    $nama = htmlspecialchars( $data['nama']);
    $deskripsi = htmlspecialchars( $data['deskripsi']);

    $result = mysqli_query($koneksi,"SELECT email FROM user WHERE email ='$email'");

    if(mysqli_fetch_assoc($result))
    {
       
        echo "
        <script>alert('Email Sudah Pernah Digunakan');</script>
        ";
        return false;
    }
    else{

    /* Update Data */
    $query = "UPDATE user SET
              email = '$email',
              nama = '$nama',
              deskripsi = '$deskripsi'
              WHERE id_user = '$id'";

    mysqli_query($koneksi,$query);
    }
    return mysqli_affected_rows($koneksi);
}

function upload()
{
    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $eror = $_FILES['gambar']['error'];
    $tmpsementara = $_FILES['gambar']['tmp_name'];

    /* Cek Apakah yang diupload adalah gambar */
    
    $ekstensivalid = ['jpg','png','jpeg'];
    $ekstensigambar = explode('.',$nama_file);
    $ekstensigambar = strtolower(end($ekstensigambar));

    if(!in_array($ekstensigambar,$ekstensivalid))
    {
        
        echo "
        <script>alert('Ekstensi Gambar Anda Tidak Sesuai');</script>
        ";
        return false;
    }
    /* Cek Ukuran Gambar */
    if($ukuran_file > 4000000)
    {
        
        echo "
        <script>alert('Ukuran Gambar Terlalu Besar');</script>
        ";
        return false;
    }
    /* Pengecekan Nama Gambar */
    $namabaru = uniqid();
    $namabaru.= '.';
    $namabaru.= $ekstensigambar;
    /* Upload Gambar */

    move_uploaded_file($tmpsementara,'../img/blog/'. $namabaru);

    return $namabaru;

}
