<?php
class Produk
{
    private $conn;
    private $table = "master_barang";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getFiltered($filters)
    {
        $where = [];

        if (!empty($filters['search'])) {
            $search = mysqli_real_escape_string($this->conn, $filters['search']);
            $where[] = "p.nama_barang LIKE '%$search%'";
        }

        if (!empty($filters['satuan'])) {
            $satuan = mysqli_real_escape_string($this->conn, $filters['satuan']);
            $where[] = "p.satuan = '$satuan'";
        }

        if (!empty($filters['kategori_id'])) {
            $kategori = mysqli_real_escape_string($this->conn, $filters['kategori_id']);
            $where[] = "p.kategori_id = '$kategori'";
        }

        if (!empty($filters['kode_gudang'])) {
            $gudang = mysqli_real_escape_string($this->conn, $filters['kode_gudang']);
            $where[] = "p.kode_gudang = '$gudang'";
        }

        $whereSql = "";
        if (count($where) > 0) {
            $whereSql = "WHERE " . implode(" AND ", $where);
        }

        $sql = "SELECT p.*, k.nama_kategori, g.nama_gudang
                FROM {$this->table} p
                LEFT JOIN master_kategori k ON p.kategori_id = k.kode_kategori
                LEFT JOIN master_gudang g ON p.kode_gudang = g.kode_gudang
                $whereSql";

        return mysqli_query($this->conn, $sql);
    }

    public function getAll()
    {
        $sql = "SELECT p.*, k.nama_kategori, g.nama_gudang
                FROM master_barang p
                LEFT JOIN master_kategori k ON p.kategori_id = k.kode_kategori
                LEFT JOIN master_gudang g ON p.kode_gudang = g.kode_gudang";
        return mysqli_query($this->conn, $sql);
    }

    public function create($data, $file)
    {
        $nama       = $data['nama_barang'];
        $satuan     = $data['satuan'];
        $harga      = $data['harga'];
        $stok       = $data['stok'];
        $kategori   = $data['kategori_id'];
        $gudang     = $data['kode_gudang'];
        $deskripsi  = $data['deskripsi'];

        $img = null;
        if (isset($file['img']) && $file['img']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['img']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("prd_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;
            if (move_uploaded_file($file['img']['tmp_name'], $target)) {
                $img = $filename;
            }
        }

        $sql = "INSERT INTO {$this->table} 
                (nama_barang, satuan, harga, stok, kategori_id, kode_gudang, deskripsi, img)
                VALUES ('$nama','$satuan','$harga','$stok','$kategori','$gudang','$deskripsi','$img')";
        return mysqli_query($this->conn, $sql);
    }

    public function update($data, $file)
    {
        $id         = $data['kode_barang'];
        $nama       = $data['nama_barang'];
        $satuan     = $data['satuan'];
        $harga      = $data['harga'];
        $stok       = $data['stok'];
        $kategori   = $data['kategori_id'];
        $gudang     = $data['kode_gudang'];
        $deskripsi  = $data['deskripsi'];

        $setImg = "";

        // kalau ada gambar baru
        if (isset($file['img']) && $file['img']['error'] === UPLOAD_ERR_OK) {
            // hapus gambar lama dulu
            $res = mysqli_query($this->conn, "SELECT img FROM {$this->table} WHERE kode_barang='$id'");
            if ($res && $row = mysqli_fetch_assoc($res)) {
                if (!empty($row['img']) && file_exists(__DIR__ . "/../uploads/" . $row['img'])) {
                    unlink(__DIR__ . "/../uploads/" . $row['img']);
                }
            }

            // upload gambar baru
            $ext = pathinfo($file['img']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("prd_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;
            if (move_uploaded_file($file['img']['tmp_name'], $target)) {
                $setImg = ", img='$filename'";
            }
        }

        $sql = "UPDATE {$this->table} SET 
                nama_barang='$nama',
                satuan='$satuan',
                harga='$harga',
                stok='$stok',
                kategori_id='$kategori',
                kode_gudang='$gudang',
                deskripsi='$deskripsi'
                $setImg
                WHERE kode_barang='$id'";
        return mysqli_query($this->conn, $sql);
    }

    public function delete($id)
    {
        // ambil nama file gambar
        $res = mysqli_query($this->conn, "SELECT img FROM {$this->table} WHERE kode_barang='$id'");
        if ($res && $row = mysqli_fetch_assoc($res)) {
            if (!empty($row['img']) && file_exists(__DIR__ . "/../uploads/" . $row['img'])) {
                unlink(__DIR__ . "/../uploads/" . $row['img']);
            }
        }

        // hapus data di database
        $sql = "DELETE FROM {$this->table} WHERE kode_barang='$id'";
        return mysqli_query($this->conn, $sql);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return $row['total'] ?? 0;
    }

    public function countLowStock()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE stok <= 5";
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return $row['total'] ?? 0;
    }

    public function getAllLP()
    {
        $sql = "SELECT b.*, k.nama_kategori, IFNULL(SUM(d.qty), 0) as total_terjual
                FROM {$this->table} b
                LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
                LEFT JOIN detail_transaksi d ON b.kode_barang = d.kode_barang
                GROUP BY b.kode_barang
                ORDER BY b.kode_barang DESC"; // bisa diubah jadi ORDER BY created_at DESC kalau ada
        return mysqli_query($this->conn, $sql);
    }

    public function search($keyword)
    {
        $keyword = mysqli_real_escape_string($this->conn, $keyword);
        $sql = "SELECT b.*, k.nama_kategori, 
                   IFNULL(SUM(d.qty), 0) AS total_terjual
            FROM master_barang b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            LEFT JOIN detail_transaksi d ON b.kode_barang = d.kode_barang
            WHERE b.nama_barang LIKE '%$keyword%'
            GROUP BY b.kode_barang";
        return mysqli_query($this->conn, $sql);
    }

    public function findById($id)
    {
        $id = mysqli_real_escape_string($this->conn, $id);

        $sql = "SELECT b.*, k.nama_kategori
            FROM master_barang b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            WHERE b.kode_barang = '$id'
            LIMIT 1";

        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getByKategori($kategoriId)
    {
        $kategoriId = mysqli_real_escape_string($this->conn, $kategoriId);
        $sql = "SELECT b.*, k.nama_kategori, IFNULL(SUM(d.qty), 0) AS total_terjual
            FROM master_barang b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            LEFT JOIN detail_transaksi d ON b.kode_barang = d.kode_barang
            WHERE b.kategori_id = '$kategoriId'
            GROUP BY b.kode_barang
            ORDER BY b.kode_barang DESC";
        return mysqli_query($this->conn, $sql);
    }

    public function getHargaBarang($kode_barang)
    {
        $sql = "SELECT harga FROM master_barang WHERE kode_barang = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $kode_barang);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row ? (int)$row['harga'] : 0;
    }
}
