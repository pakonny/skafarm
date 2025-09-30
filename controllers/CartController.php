<?php
require_once(__DIR__ . '/../models/Cart.php');
require_once(__DIR__ . '/../models/Produk.php');

class CartController
{
    private $cartModel;
    private $barangModel;

    public function __construct($conn)
    {
        $this->cartModel   = new Cart($conn);
        $this->barangModel = new Produk($conn);
    }

    public function mycart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=showLogin");
            exit;
        }

        $kode_user = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartByUser($kode_user);

        include 'views/landingPage/cart.php';
    }

    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $kode_user   = $_SESSION['user_id'];
        $kode_barang = $_GET['id'] ?? null;
        $qty         = 1;

        if (!$kode_barang) {
            die("Barang tidak valid!");
        }

        $harga = $this->barangModel->getHargaBarang($kode_barang);

        if ($harga <= 0) {
            die("Barang tidak ditemukan atau harga tidak valid!");
        }

        $this->cartModel->addToCart($kode_user, $kode_barang, $qty, $harga);

        header("Location: index.php?controller=cart&action=mycart");
    }

    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $kode_user = $_SESSION['user_id'];
        $id_cart   = $_GET['id_cart'];

        $this->cartModel->deleteFromCartById($kode_user, $id_cart);

        header("Location: index.php?controller=cart&action=mycart");
    }
}
