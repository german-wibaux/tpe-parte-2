<?php


require_once  "./view/LoginView.php";
require_once  "./model/UsuarioModel.php";
include_once 'controller/Controller.php';


class LoginController extends Controller
{
  // private $view;
  // private $model;
  private $Titulo;

  function __construct()
  {
    parent::__construct();
    $this->view = new LoginView();
    $this->model = new UsuarioModel();
    $this->Titulo = "Login";
  }

  function login(){

    $this->view->mostrarLogin();

  }

  function logout(){
    session_start();
    session_destroy();
    header('Location: '.LOGIN);
  }

  function verificarLogin(){
  
      $user = $_POST["usuarioId"];
      $pass = $_POST["passwordId"];
      $dbUser = $this->model->getUser($user);
      
      if(isset($dbUser)){      
        //   $password = '123456';
        //   $hash = password_hash($password, PASSWORD_DEFAULT);
        //  echo $hash;
         
          if (password_verify($pass, $dbUser[0]['pass'])){
              //mostrar lista de tareas
             echo 'entro pass valida';
              session_start();
              $_SESSION["User"] = $user;
              header("Location: ".HOME);
          }else{
            $this->view->mostrarLogin("Contraseña incorrecta");

          }
      }else{
        //No existe el usario
        $this->view->mostrarLogin("No existe el usario");
      }

  }

  

}

 ?>
