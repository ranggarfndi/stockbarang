<?php 
session_start();

// KONEKSI DATABASE
$conn = pg_connect("host=localhost dbname=stockbarang user=postgres password=0000");

// MENAMBAH BARANG BARU
if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = pg_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) VALUES ('$namabarang', '$deskripsi', '$stock')");

    if ($addtotable) {
        header('location:index.php');
    } else {
        echo "<script> alert('Gagal menambahkan data!') </script>";
        header('location:index.php');
    }
};

// MENAMBAH BARANG MASUK
if(isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = pg_query($conn, "SELECT * FROM stock WHERE idbarang = '$barangnya'");
    $ambildatanya = pg_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtotablemasuk = pg_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES ('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = pg_query($conn, "UPDATE stock SET stock = '$tambahkanstocksekarangdenganquantity' WHERE idbarang = '$barangnya'");

    if ($addtotablemasuk && $updatestockmasuk) {
        header('location:masuk.php');
    } else {
        echo "<script> alert('Gagal menambahkan data!') </script>";
        header('location:masuk.php');
    }
}

// MENAMBAH BARANG KELUAR
if(isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = pg_query($conn, "SELECT * FROM stock WHERE idbarang = '$barangnya'");
    $ambildatanya = pg_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

    $addtotablekeluar = pg_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES ('$barangnya', '$penerima', '$qty')");
    $updatestockkeluar = pg_query($conn, "UPDATE stock SET stock = '$tambahkanstocksekarangdenganquantity' WHERE idbarang = '$barangnya'");

    if ($addtotablekeluar && $updatestockkeluar) {
        header('location:keluar.php');
    } else {
        echo "<script> alert('Gagal menambahkan data!') </script>";
        header('location:keluar.php');
    }
}

// UPDATE INFO BARANG
if (isset($_POST['updatebarang'])) {
    $idbarang = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = pg_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idbarang'");
    if ($update) {
        header('location:index.php');
    } else {
        echo "<script> alert('Gagal menambahkan data!') </script>";
        header('location:index.php');
    }
}

// HAPUS BARANG STOCK
if (isset($_POST['hapusbarang'])) {
    $idbarang = $_POST['idb'];
    
    $delete = pg_query($conn, "DELETE FROM stock WHERE idbarang = '$idbarang'");
    if ($delete) {
        header('location:index.php');
    }
}

// MENGUBAH DATA BARANG MASUK
if (isset($_POST['updatebarangmasuk'])) {
    
}