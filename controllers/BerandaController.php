<?php
require_once(__DIR__ . '/../models/Kategori.php');
require_once(__DIR__ . '/../models/Produk.php');
require_once(__DIR__ . '/../models/Blog.php');

class BerandaController
{
    private $kategoriModel;
    private $produkModel;
    private $blogModel;

    public function __construct($conn)
    {
        $this->kategoriModel = new Kategori($conn);
        $this->produkModel   = new Produk($conn);
        $this->blogModel     = new Blog($conn);
    }

    public function index()
    {
        $kategori = $this->kategoriModel->getAll();

        $keyword  = $_GET['search'] ?? null;
        $kategoriId = $_GET['kategori'] ?? null;

        if ($keyword) {
            $produk = $this->produkModel->search($keyword);
        } elseif ($kategoriId) {
            $produk = $this->produkModel->getByKategori($kategoriId);
        } else {
            $produk = $this->produkModel->getAllLP();
        }

        $blogFeatured = $this->blogModel->getLimit(1);
        $blogSide     = $this->blogModel->getLimit(3, 1);
        $blogAll      = $this->blogModel->getAll();

        require_once(__DIR__ . '/../views/landingPage/beranda.php');
    }


    public function detail()
    {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=beranda&action=index");
            exit;
        }

        $id = $_GET['id'];
        $product = $this->produkModel->findById($id);

        if (!$product) {
            header("Location: index.php?controller=beranda&action=index&status=notfound");
            exit;
        }

        require_once(__DIR__ . '/../views/landingPage/detailProduk.php');
    }
}
