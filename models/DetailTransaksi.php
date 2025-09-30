<?php
class Detailtransaksi
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getHistory($kode_user)
    {
        $query = "SELECT b.nama_barang, b.harga, b.img, k.nama_kategori,
                 dt.qty, dt.harga_total FROM master_transaksi mt
                JOIN detail_transaksi dt ON mt.id_transaksi = dt.id_transaksi
                JOIN master_barang b ON dt.kode_barang = b.kode_barang
                JOIN master_kategori k ON b.kategori_id = k.kode_kategori
                WHERE mt.kode_user ='$kode_user'";
        return mysqli_query($this->conn, $query);
    }
    public function getHargaBarang($kode_barang)
    {
        $query = "SELECT harga FROM master_barang WHERE kode_barang = '$kode_barang'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['harga'];
    }

    public function insertMasterTransaksi($kode_transaksi, $kode_user, $total_harga)
    {
        $tanggal = date('Y-m-d');
        $query = "INSERT INTO master_transaksi (kode_transaksi, kode_user, tanggal_transaksi, total_harga, status, alamat) 
              VALUES ('$kode_transaksi', '$kode_user', CURDATE(), '$total_harga', 'pending', 'belum')";
        mysqli_query($this->conn, $query);
    }

    public function getLastInsertId()
    {
        return mysqli_insert_id($this->conn);
    }

    public function insertDetailTransaksi($id_transaksi, $kode_barang, $qty, $harga_satuan, $harga_total)
    {
        $query = "INSERT INTO detail_transaksi (id_transaksi, kode_barang, qty, harga_satuan, harga_total) 
              VALUES ('$id_transaksi', '$kode_barang', '$qty', '$harga_satuan', '$harga_total')";
        mysqli_query($this->conn, $query);
    }
    public function getTransactionByKode($kode_transaksi)
    {
        $query = "SELECT 
                mt.kode_transaksi,
                mt.tanggal_transaksi,
                mt.metode_pembayaran,
                mt.alamat,
                dt.qty,
                dt.harga_total,
                b.nama_barang
              FROM master_transaksi mt
              JOIN detail_transaksi dt ON mt.id_transaksi = dt.id_transaksi
              JOIN master_barang b ON dt.kode_barang = b.kode_barang
              WHERE mt.kode_transaksi = '$kode_transaksi'";

        $result = mysqli_query($this->conn, $query);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }
    public function updateTransaksi($kode_transaksi, $alamat, $metode)
    {
        $query = "UPDATE master_transaksi 
              SET alamat = '$alamat', metode_pembayaran = '$metode' 
              WHERE kode_transaksi = '$kode_transaksi'";
        mysqli_query($this->conn, $query);
    }
}
