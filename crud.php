<?php
    include "koneksi.php";

//kode otomatis
$q = mysqli_query($koneksi, "SELECT kode tbarang order by kode desc limit 1");
$data = mysqli_fetch_array($q);
if($data){
    $no_terakhir = substr($datx['kode'], -3);
    $no = $no_terakhir +1;

    if($no > 0 and $no <10){
        $kode = "00".$no;
    }else if($no > 10 and $no < 100){
        $kode = "0".$no;
    }else if($no > 100){
        $kode = $no;
    }
}else{
    $kode = "001";
}
$tahun = date('Y');
$vkode = "IVN-" . $tahun . '-' . $kode;



//jika Simpan Di Klik 
if(isset($_POST['bsimpan'])){

    //Pengujian Apajah data akan diedit atau disimpan baru
    if(isset($_GET['hal']) == "edit"){
        //data akan di edit
        $edit = mysqli_query($koneksi, "UPDATE tbarang SET 
                                                nama = '$_POST[tnama]',
                                                asal = '$_POST[tasal]',
                                                jumlah = '$_POST[tjumlah]',
                                                satuan = '$_POST[tsatuan]',
                                                tanggal_diterima = '$_POST[ttanggal_diterima]'
                                        WHERE id_barang = '$_GET[id]'
                                        ");
        //Uji Jika Simpan Data Sukses
        if($edit){
            echo"<script>alert('Edit Data Sukses')
            document.location='index.php';
            </script>";
        }else{
            echo"<script>alert('Edit Data Gagal')
            document.location='index.php';
            </script>";
        }
        }else{
            //data akan di simpan baru
             //Data akan Disimpan Baru
                $simpan = mysqli_query($koneksi,"INSERT INTO tbarang (kode, nama, asal, jumlah, satuan, tanggal_diterima)
                                                            VALUE   ('$_POST[tkode]',
                                                                    '$_POST[tnama]',
                                                                    '$_POST[tasal]',
                                                                    '$_POST[tjumlah]',
                                                                    '$_POST[tsatuan]',
                                                                    '$_POST[ttanggal_diterima]')
                                                                    ");

            //Uji Jika Simpan Data Sukses
            if($simpan){
            echo"<script>alert('Simpan Data Sukses')
            document.location='index.php';
            </script>";
            }else{
            echo"<script>alert('Simpan Data Gagal')
            document.location='index.php';
            </script>";
            }
         }
            
}

//deklarasi variabel untuk menampung data yang akan di edit

$vnama = "";
$vasal = "";
$vjumlah = "";
$vsatuan = "";
$vtanggal_diterima = "";
//Pengujian Jika Tombol Edit Atau Hapus Di Klik
if(isset($_GET['hal'])){
    //pengujian jika edit data
    if($_GET['hal'] == "edit"){
        //tampilkan data yang akan di edit
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data){
            //jika data ditemukan, maka data di tampung ke dalam variabel
            $vkode = $data['kode'];
            $vnama = $data['nama'];
            $vasal = $data['asal'];
            $vjumlah = $data['jumlah'];
            $vsatuan = $data['satuan'];
            $vtanggal_diterima = $data['tanggal_diterima'];

        }
    }else if ($_GET['hal'] == "hapus"){
        //persiapan Hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tbarang WHERE id_barang = '$_GET[id]'");
        //Uji Jika Hapus Data Sukses
            if($hapus){
            echo"<script>alert('Hapus Data Sukses')
            document.location='index.php';
            </script>";
            }else{
            echo"<script>alert('Hapus Data Gagal')
            document.location='index.php';
            </script>";
            }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">

        <div class="mt-3">
        <h3 class="text-center">Data Inventaris</h3>
        <h3 class="text-center">Kantor Camat Kahu</h3>

        <div class="row">
            <div class="col-md-6 mx-auto">
                    <div class="card">
                    <div class="card-header bg-info text-light">
                        Form Input Data Barang
                    </div>
                    <div class="card-body">
                        <!--awal Form-->
                        <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="tkode" value="<?= $vkode?>" class="form-control"  placeholder="Masukkan Kode Barang" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="tnama" value="<?= $vnama?>" class="form-control"  placeholder="Masukkan Nama Barang"required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asal Barang</label>
                                <select class="form-select" name="tasal"requared >
                                    <option value="<?=$vasal?>"><?=$vasal?></option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Makassar">Makassar</option>
                                    <option value="Bandung">Bandung</option>
                                </select>
                        </div>
                        <div class="row">
                             <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="tjumlah" value="<?= $vjumlah?>" class="form-control"  placeholder="Masukkan Jumlah Barang"required>
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Satuan</label>
                                        <select class="form-select" name="tsatuan"required>
                                            <option value="<?=$vsatuan?>"><?=$vsatuan?></option>
                                            <option value="Unit">Unit</option>
                                            <option value="Kotak">Kotak</option>
                                            <option value="Pcs">Pcs</option>
                                        </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Di Terima</label>
                                    <input type="date" name="ttanggal_diterima" value="<?= $vtanggal_diterima?>" class="form-control"  placeholder="Masukkan Jumlah Barang" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <hr>
                                <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
                                <button class="btn btn-danger" name="bkosongkan" type="reset">Hapus</button>
                            </div>
                        </div>
                    
                        </form>
                        <!--akhir Form-->
                    </div>
                    <div class="card-footer bg-info">
                       
                    </div>
                </div>
            </div>
        </div>   
            <div class="card mt-3">
                    <div class="card-header bg-info text-light">
                        Data Barang
                    </div>
                    <div class="card-body">
                        <div class="col-md-6 mx-auto">
                            <form action="" method="post">
                                <div class="input-group mb-3">
                                    <input type="text" name="tcari" value="<?= @$_POST['tcari']?>"class="form-control" placeholder="Masukkan Kata Kunci">
                                    <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                                    <button class="btn btn-danger" name="breset" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-hover table-bordered">
                            <tr>
                                <th>No.</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Asal Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Tanggal Diterima</th>
                                <th>Aksi</th>
                            </tr>
                            
                        <?php
                            //persiapan menampilkan data
                            $no = 1;

                            //Untuk Pencarian Data
                            //Jika Tombol Cari Di Klik
                            if(isset($_POST['tcari'])){
                                //tampilkan data yang di cari
                                $keyword = $_POST['tcari'];
                                $q = "SELECT * FROM tbarang WHERE kode like '%$keyword%' or nama like '%$keyword%' or asal like '%$keyword%' order by id_barang desc";
                            }else{
                                $q = "SELECT * FROM tbarang order by id_barang desc";

                            }
                            $tampil = mysqli_query($koneksi, $q);
                            while($data = mysqli_fetch_array($tampil)):
                        ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$data['kode']?></td>
                                <td><?=$data['nama']?></td>
                                <td><?=$data['asal']?></td>
                                <td><?=$data['jumlah']?> <?=$data['satuan']?></td>
                                <td><?=$data['tanggal_diterima']?></td>
                                <td>
                                    <a href="index.php?hal=edit&id=<?=$data['id_barang']?>" class="btn btn-warning">Edit</a>
                                    <a href="index.php?hal=hapus&id=<?=$data['id_barang']?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Hapus Data Ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile;?>
                        </table>
                        
                    </div>
                    <div class="card-footer bg-info">
                       
                    </div>
                </div>
    </div>
    



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>