<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "rekam_medis";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nama                    = "";
$hasil_lab               = "";
$diagnosa                = "";
$tindakan_yang_dilakukan = "";
$nama_dokter             = "";
$resep_obat              = "";
$sukses                  = "";
$error                   = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from rekammedis where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id                      = $_GET['id'];
    $sql1                    = "select * from rekammedis where id = '$id'";
    $q1                      = mysqli_query($koneksi, $sql1);
    $r1                      = mysqli_fetch_array($q1);
    $nama                    = $r1['nama'];
    $hasil_lab               = $r1['hasil_lab'];
    $diagnosa                = $r1['diagnosa'];
    $tindakan_yang_dilakukan = $r1['tindakan_yang_dilakukan'];
    $nama_dokter             = $r1['nama_dokter'];
    $resep_obat              = $r1['resep_obat'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nama                    = $_POST['nama'];
    $hasil_lab               = $_POST['hasil_lab'];
    $diagnosa                = $_POST['diagnosa'];
    $tindakan_yang_dilakukan = $_POST['tindakan_yang_dilakukan'];
    $nama_dokter             = $_POST['nama_dokter'];
    $resep_obat              = $_POST['resep_obat'];

    if ($nama && $hasil_lab && $diagnosa && $tindakan_yang_dilakukan && $nama_dokter && $resep_obat) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update rekammedis set nama = '$nama',hasil_lab='$hasil_lab',diagnosa = '$diagnosa',tindakan_yang_dilakukan='$tindakan_yang_dilakukan',nama_dokter='$nama_dokter',resep_obat='$resep_obat' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into rekammedis(nama,hasil_lab,diagnosa,tindakan_yang_dilakukan,nama_dokter,resep_obat) values ('$nama','$hasil_lab','$diagnosa','$tindakan_yang_dilakukan','$nama_dokter','$resep_obat')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
//untuk pencarian
if(isset($_POST['bcari'])){
    //tampilkan data yang dicari
    $keyword     = $_POST['tcari'];
    $sql1        = "select * from rekammedis where nama like '%$keyword%' order by id desc";
    $q         = mysqli_query($koneksi, $sql1);
    

} 
else{
   $sq   = "select * from rekammedis order by id desc";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 1100px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="hasil_lab" class="col-sm-2 col-form-label">Hasil lab</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hasil_lab" name="hasil_lab" value="<?php echo $hasil_lab ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="diagnosa" class="col-sm-2 col-form-label">Diagnosa</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="diagnosa" name="diagnosa" value="<?php echo $diagnosa ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tindakan_yang_dilakukan" class="col-sm-2 col-form-label">Tindakan Yang Dilakukan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tindakan_yang_dilakukan" name="tindakan_yang_dilakukan" value="<?php echo $tindakan_yang_dilakukan ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama_dokter" class="col-sm-2 col-form-label">Nama Dokter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="<?php echo $nama_dokter ?>">
                        </div>
                    </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="resep_obat" class="col-sm-2 col-form-label">Resep Obat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="resep_obat" name="resep_obat" value="<?php echo $resep_obat ?>">
                        </div>
                    </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
        <div>
            <div class="card-body">
                <div class="col-md-6 mx-auto">
                    <form action method="POST">
                        <div class="input-group mb-3">
                            <input type="text" name="tcari" class="form-control" placeholder="masukkan kata kunci">
                            <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                            <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                    
                    </form>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Pasien
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Hasil Lab</th>
                            <th scope="col">Diagnosa</th>
                            <th scope="col">Tindakan Yang Dilakukan</th>
                            <th scope="col">Nama Dokter</th>
                            <th scope="col">Resep Obat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql1   = "select * from rekammedis order by id desc";
                        $q2     = mysqli_query($koneksi, $sql1);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id                      = $r2['id'];
                            $nama                    = $r2['nama'];
                            $hasil_lab               = $r2['hasil_lab'];
                            $diagnosa                = $r2['diagnosa'];
                            $tindakan_yang_dilakukan = $r2['tindakan_yang_dilakukan'];
                            $nama_dokter             = $r2['nama_dokter'];
                            $resep_obat              = $r2['resep_obat'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $hasil_lab ?></td>
                                <td scope="row"><?php echo $diagnosa ?></td>
                                <td scope="row"><?php echo $tindakan_yang_dilakukan ?></td>
                                <td scope="row"><?php echo $nama_dokter ?></td>
                                <td scope="row"><?php echo $resep_obat ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>