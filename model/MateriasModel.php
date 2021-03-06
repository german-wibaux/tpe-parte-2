<?php

/**
 *
 */
class MateriasModel
{
    private $db;

    function __construct()
    {
        $this->db = $this->Connect();

    }

    function Connect()
    {
        return new PDO('mysql:host=localhost;'
            . 'dbname=tp-especial;charset=utf8'
            , 'root', '');
    }

    function GetMaterias()
    {

        $sentencia = $this->db->prepare("select a.*, o.nombreModalidad, CASE WHEN i.URL is NULL then 'materias/000.jpg' ELSE i.URL END as RUTA from materias a inner JOIN modalidad o on a.idModalidad = o.idModalidad LEFT JOIN imagenes i on a.idMateria=i.idMateria order by o.idModalidad, a.anio, a.division");

        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }


    function GetMateria($idMateria)
    {

        $sentencia = $this->db->prepare("select * from materias where idMateria=?");
        $sentencia->execute(array($idMateria));
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    function GetPath1($idMateria)
    {

        $sentencia = $this->db->prepare("select path1 from materias where idMateria=?");
        $sentencia->execute(array($idMateria));
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    function GetComentarios()
    {

        $sentencia = $this->db->prepare("select c.*, m.nombreMateria from comentarios c inner join materias m on c.idMateria=m.idMateria");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    function GetComentario($idMateria)
    {

        $sentencia = $this->db->prepare("select c.*, m.nombreMateria from comentarios c inner join materias m on c.idMateria=m.idMateria where c.idMateria=?");
        $sentencia->execute(array($idMateria));
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }


    private function subirImagen($imagen)
    {
        $destino_final = 'img/materias/' . uniqid() . '.jpg';
        move_uploaded_file($imagen, $destino_final);
        return $destino_final;
    }

    function InsertarMateria($nombre, $modalidad, $descripcion, $anio, $division)
    {

        $sentencia = $this->db->prepare("INSERT INTO materias(nombreMateria, idModalidad, descripcionMateria, anio, division, path1) VALUES(?,?,?,?,?,?)");
        $sentencia->execute(array($nombre, $modalidad, $descripcion, $anio, $division, null));
    }

    function InsertarMateriaImg($nombre, $modalidad, $descripcion, $anio, $division, $tempPath)
    {
        $path = $this->subirImagen($tempPath);
        $sentencia = $this->db->prepare("INSERT INTO materias(nombreMateria, idModalidad, descripcionMateria, anio, division, path1) VALUES(?,?,?,?,?,?)");
        $sentencia->execute(array($nombre, $modalidad, $descripcion, $anio, $division, $path));
    }

    function BorrarMateria($idMateria)
    {
        $sentencia = $this->db->prepare("delete from materias where idMateria=?");
        $sentencia->execute(array($idMateria));
    }

    function GuardarEditarMateria($titulo, $modalidad, $descripcion, $anio, $division, $id)
    {
        $sentencia = $this->db->prepare("update materias set nombreMateria = ?, idModalidad = ?,  descripcionMateria = ?, anio = ?, division = ? where idMateria=?");
        $sentencia->execute(array($titulo, $modalidad, $descripcion, $anio, $division, $id));
    }

    function GuardarEditarMateriaImg($titulo, $modalidad, $descripcion, $anio, $division, $tempPath, $id)
    {
        $path = $this->subirImagen($tempPath);
        $sentencia = $this->db->prepare("update materias set nombreMateria = ?, idModalidad = ?,  descripcionMateria = ?, anio = ?, division = ?, path1 = ? where idMateria=?");
        $sentencia->execute(array($titulo, $modalidad, $descripcion, $anio, $division, $path, $id));
    }

    function EliminarImagenPath1($idMateria)
    {
        $sentencia = $this->db->prepare("update materias set path1 = ? where idMateria=?");
        $sentencia->execute(array(null, $idMateria));
    }

    function GetComentarioSolo($idComentario)
    {
        $sentencia = $this->db->prepare("select * from comentarios where id=?");
        $sentencia->execute(array($idComentario));
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    function BorrarComentario($idComentario)
    {

        $tarea = $this->GetComentarioSolo($idComentario);
        if (isset($tarea)) {
            $sentencia = $this->db->prepare("delete from comentarios where id=?");
            $sentencia->execute(array($idComentario));
            return $tarea;
        }
    }


    function InsertarComentario($Comentario, $Puntaje, $idUsuario, $idMateria)
    {

        $sentencia = $this->db->prepare("INSERT INTO comentarios (comentario, puntaje, idUsuario, idMateria) VALUES(?,?,?,?)");
        $sentencia->execute(array($Comentario, $Puntaje, $idUsuario, $idMateria));
    }

    function GetModalidad($idModalidad)
    {

        $sentencia = $this->db->prepare("select * from modalidad where idModalidad=?");
        $sentencia->execute(array($idModalidad));
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    function InsertarModalidad($nombre)
    {

        $sentencia = $this->db->prepare("INSERT INTO modalidad(nombreModalidad) VALUES(?)");
        $sentencia->execute(array($nombre));
    }

    function BorrarModalidad($idModalidad)
    {
        $sentencia = $this->db->prepare("delete from modalidad where idModalidad=?");
        $sentencia->execute(array($idModalidad));
    }

    function GuardarEditarModalidad($modalidad, $id)
    {
        $sentencia = $this->db->prepare("update modalidad set nombreModalidad = ? where idModalidad=?");
        $sentencia->execute(array($modalidad, $id));
    }


}


?>
