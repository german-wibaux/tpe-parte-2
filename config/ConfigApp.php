<?php

class ConfigApp
{
    public static $ACTION = 'action';
    public static $PARAMS = 'params';
    public static $ACTIONS = [
      ''=> 'VisitanteController#Home',
      'home'=> 'VisitanteController#Home',
      'home-materias'=> 'VisitanteController#HomeMaterias',
      'materias' => 'MateriasController#Materias',
      //'crear' => 'MateriasController#Modalidades',
      'agregar'=> 'MateriasController#InsertMateria',
      'borrar'=> 'MateriasController#BorrarMateria',
      // 'completada'=> 'TareasController#CompletarTarea',
      // 'editar'=> 'TareasController#EditarTarea',
      'editar'=> 'MateriasController#EditarMateria',
      'guardarEditar'=> 'MateriasController#GuardarEditarMateria',
      // 'mostrarUsuarios'=> 'UsuarioController#MostrarUsuario',
      'login'=> 'LoginController#login',
      'logout'=> 'LoginController#logout',
      'verificarLogin' => 'LoginController#verificarLogin'
    ];

}

 ?>
