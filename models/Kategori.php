<?php
class Kategori
{
    private $conn;
    private $table = "master_kategori";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT k.*, COUNT(b.kode_barang) AS total_produk
                FROM master_kategori k
                LEFT JOIN master_barang b ON k.kode_kategori = b.kategori_id
                GROUP BY k.kode_kategori";
        return mysqli_query($this->conn, $sql);
    }

    public function create($nama, $file)
    {
        $img = null;

        if (isset($file['img']) && $file['img']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['img']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("kat_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;

            if (move_uploaded_file($file['img']['tmp_name'], $target)) {
                $img = $filename;
            }
        }

        $sql = "INSERT INTO {$this->table} (nama_kategori, img) VALUES ('$nama', '$img')";
        return mysqli_query($this->conn, $sql);
    }

    public function update($id, $nama, $file)
    {
        $setImg = "";

        if (isset($file['img']) && $file['img']['error'] === UPLOAD_ERR_OK) {
            // hapus gambar lama dulu
            $res = mysqli_query($this->conn, "SELECT img FROM {$this->table} WHERE kode_kategori='$id'");
            if ($res && $row = mysqli_fetch_assoc($res)) {
                if (!empty($row['img']) && file_exists(__DIR__ . "/../uploads/" . $row['img'])) {
                    unlink(__DIR__ . "/../uploads/" . $row['img']);
                }
            }

            // upload gambar baru
            $ext = pathinfo($file['img']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("kat_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;

            if (move_uploaded_file($file['img']['tmp_name'], $target)) {
                $setImg = ", img='$filename'";
            }
        }

        $sql = "UPDATE {$this->table} 
            SET nama_kategori='$nama' $setImg 
            WHERE kode_kategori='$id'";
        return mysqli_query($this->conn, $sql);
    }

    public function delete($id)
    {
        // hapus file gambar dulu
        $res = mysqli_query($this->conn, "SELECT img FROM {$this->table} WHERE kode_kategori='$id'");
        if ($res && $row = mysqli_fetch_assoc($res)) {
            if (!empty($row['img']) && file_exists(__DIR__ . "/../uploads/" . $row['img'])) {
                unlink(__DIR__ . "/../uploads/" . $row['img']);
            }
        }

        // hapus data kategori
        $sql = "DELETE FROM {$this->table} WHERE kode_kategori='$id'";
        return mysqli_query($this->conn, $sql);
    }
}
