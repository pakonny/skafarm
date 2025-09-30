<?php
class Cart
{
    private $conn;
    private $table = "master_cart";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCartByUser($kode_user)
    {
        $query = "SELECT c.id_cart, c.*, b.nama_barang, b.harga, b.img, k.nama_kategori
              FROM master_cart c
              JOIN master_barang b ON c.kode_barang = b.kode_barang
              JOIN master_kategori k ON b.kategori_id = k.kode_kategori
              WHERE c.kode_user = '$kode_user'";
        return mysqli_query($this->conn, $query);
    }

    public function getSummaryByUser($kode_user)
    {
        $query = "SELECT 
                SUM(qty) AS total_produk, 
                SUM(subtotal) AS total_harga 
              FROM master_cart 
              WHERE kode_user = '$kode_user'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }


    public function addToCart($kode_user, $kode_barang, $qty, $harga)
    {
        $subtotal = $qty * $harga;

        $query = "SELECT * FROM master_cart WHERE kode_user = '$kode_user' AND kode_barang = '$kode_barang'";
        $result = mysqli_query($this->conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $query = "UPDATE master_cart 
                      SET qty = qty + $qty, subtotal = subtotal + $subtotal
                      WHERE kode_user = '$kode_user' AND kode_barang = '$kode_barang'";
            return mysqli_query($this->conn, $query);
        } else {
            $query = "INSERT INTO master_cart (kode_user, kode_barang, qty, harga_satuan, subtotal)
                      VALUES ('$kode_user', '$kode_barang', '$qty', '$harga', '$subtotal')";
            return mysqli_query($this->conn, $query);
        }
    }

    public function getHargaBarang($kode_barang)
    {
        $query = "SELECT harga FROM master_barang WHERE kode_barang = '$kode_barang'";
        $result = mysqli_query($this->conn, $query);
        $data = mysqli_fetch_assoc($result);
        return $data ? $data['harga'] : 0;
    }

    public function deleteFromCartById($kode_user, $id_cart)
    {
        $query = "DELETE FROM master_cart WHERE id_cart = '$id_cart' AND kode_user = '$kode_user'";
        return mysqli_query($this->conn, $query);
    }
}
