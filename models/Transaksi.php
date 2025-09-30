<?php
class Transaksi
{
    private $conn;
    private $table = "master_transaksi";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT t.*, u.username
                FROM {$this->table} t
                JOIN master_user u ON t.kode_user = u.kode_user
                ORDER BY t.id_transaksi DESC";
        return mysqli_query($this->conn, $sql);
    }

    public function getDetail($id_transaksi)
    {
        $sql = "SELECT d.*, b.nama_barang 
                FROM detail_transaksi d
                JOIN master_barang b ON d.kode_barang = b.kode_barang
                WHERE d.id_transaksi = '$id_transaksi'";
        return mysqli_query($this->conn, $sql);
    }

    public function updateStatus($id)
    {
        $sql = "UPDATE {$this->table} SET status='selesai' WHERE id_transaksi='$id'";
        return mysqli_query($this->conn, $sql);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM master_transaksi";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return $row['total'] ?? 0;
    }

    public function sumPendapatan()
    {
        $sql = "SELECT SUM(total_harga) as total FROM master_transaksi WHERE status='selesai'";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return $row['total'] ?? 0;
    }
}
