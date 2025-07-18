<?php
require_once("models/Model.model.php");
require_once("views/login.view.php");
class LoginController extends Model
{
    private $status;
    public function index()
    {
        if (isset($_POST['loginBtn'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $this->auth($username, $password);
        }
        login($this->status);
    }
    private function auth($username, $password)
    {
        $query = $this->customQuery("SELECT * FROM users WHERE username='$username' OR email='$username'");
        $check_user = mysqli_fetch_assoc($query);
        if ($check_user === NULL) {
            return $this->status = [
                "Pesan" => "Login gagal",
                "Status" => false
            ];
        }
        if (password_verify($password, $check_user['password'])) {
            session_start();
            $_SESSION['user_data'] = $check_user;
            $this->status = [
                "Pesan" => "Berhasil login",
                "Status" => true
            ];
            header("Location: /");
            exit;
            setcookie("username", "$username");
        } else {
            return $this->status = [
                "Pesan" => "Login gagal",
                "Status" => false
            ];
        }
    }
}
