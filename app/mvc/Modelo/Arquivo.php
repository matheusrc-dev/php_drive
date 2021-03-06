<?php

namespace Modelo;

use PDO;
use \Framework\DW3BancoDeDados;

class Arquivo extends Modelo
{
  const BUSCAR_TODOS = 'SELECT a.name, a.type, a.size, a.path, a.upload_date, a.id id, u.id user_id FROM arquivos a JOIN usuarios u ON (a.user_id = u.id) WHERE u.id = ? ORDER BY a.id';
  const BUSCAR_TODOS_ORDER_NAME = 'SELECT a.name, a.type, a.size, a.path, a.upload_date, a.id id, u.id user_id FROM arquivos a JOIN usuarios u ON (a.user_id = u.id) WHERE u.id = ? ORDER BY a.name';
  const BUSCAR_TODOS_ORDER_DATE = 'SELECT a.name, a.type, a.size, a.path, a.upload_date, a.id id, u.id user_id FROM arquivos a JOIN usuarios u ON (a.user_id = u.id) WHERE u.id = ? ORDER BY a.upload_date';
  const BUSCAR_TODOS_ORDER_FILE_SIZE = 'SELECT a.name, a.type, a.size, a.path, a.upload_date, a.id id, u.id user_id FROM arquivos a JOIN usuarios u ON (a.user_id = u.id) WHERE u.id = ? ORDER BY a.size';
  const INSERIR = 'INSERT INTO arquivos(user_id, name, type, size, path, upload_date) VALUES (?,?,?,?,?,?)';
  const DELETAR = 'DELETE FROM arquivos WHERE id = ?';
  const BUSCAR_ID = 'SELECT * FROM arquivos WHERE id = ?';

  private $id;
  private $user_id;
  private $name;
  private $type;
  private $size;
  private $path;
  private $upload_date;

  public function __construct(
    $user_id,
    $name = null,
    $type = null,
    $size = null,
    $path = null,
    $upload_date = null,
    $id = null,
  ) {
    $this->user_id = $user_id;
    $this->name = $name;
    $this->type = $type;
    $this->size = $size;
    $this->path = $path;
    $this->upload_date = $upload_date;
    $this->id = $id;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getUserId()
  {
    return $this->user_id;
  }

  public function getName()
  {
    return $this->name;
  }
  public function getType()
  {
    return $this->type;
  }
  public function getSize()
  {
    return $this->size;
  }
  public function getPath()
  {
    return $this->path;
  }

  public function getUploadDate()
  {
    return $this->upload_date;
  }

  public function salvar()
  {
    $this->inserir();
  }

  public function inserir()
  {
    DW3BancoDeDados::getPdo()->beginTransaction();
    $comando = DW3BancoDeDados::prepare(self::INSERIR);
    $comando->bindValue(1, $this->user_id, PDO::PARAM_INT);
    $comando->bindValue(2, $this->name, PDO::PARAM_STR);
    $comando->bindValue(3, $this->type, PDO::PARAM_STR);
    $comando->bindValue(4, $this->size, PDO::PARAM_INT);
    $comando->bindValue(5, $this->path, PDO::PARAM_STR);
    $comando->bindValue(6, $this->upload_date);
    $comando->execute();
    $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
    DW3BancoDeDados::getPdo()->commit();
  }

  public static function buscarTodos($id, $order_by = null)
  {
    if ($order_by == null)
      $comando = DW3BancoDeDados::prepare(self::BUSCAR_TODOS);

    if ($order_by == 'name')
      $comando = DW3BancoDeDados::prepare(self::BUSCAR_TODOS_ORDER_NAME);

    if ($order_by == 'date')
      $comando = DW3BancoDeDados::prepare(self::BUSCAR_TODOS_ORDER_DATE);

    if ($order_by == 'size')
      $comando = DW3BancoDeDados::prepare(self::BUSCAR_TODOS_ORDER_FILE_SIZE);

    $comando->bindValue(1, $id, PDO::PARAM_INT);
    $comando->execute();
    $registros = $comando->fetchAll();
    $arquivos = [];

    foreach ($registros as $registro) {
      $arquivos[] = new Arquivo(
        $registro['user_id'],
        $registro['name'],
        $registro['type'],
        $registro['size'],
        $registro['path'],
        $registro['upload_date'],
        $registro['id']
      );
    }

    return $arquivos;
  }

  public static function destruir($id)
  {
    $usuario = Arquivo::buscarId($id);

    unlink($usuario->getPath());    // Deleta o arquivo no caminho especificado

    $comando = DW3BancoDeDados::prepare(self::DELETAR);
    $comando->bindValue(1, $id, PDO::PARAM_INT);
    $comando->execute();
  }

  public static function buscarId($id)
  {
    $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
    $comando->bindValue(1, $id, PDO::PARAM_INT);
    $comando->execute();
    $registro = $comando->fetch();

    return new Arquivo(
      $registro['user_id'],
      $registro['name'],
      $registro['type'],
      $registro['size'],
      $registro['path'],
      $registro['upload_date'],
      $registro['id']
    );
  }

  public function getIconByType()
  {
    if ($this->getType() == 'image/png' || $this->getType() == 'image/jpg' || $this->getType() == 'image/jpeg') {
      return 'image';
    }
    if ($this->getType() == 'video/mp4' || $this->getType() == 'video/wav') {
      return 'movie';
    }
    if ($this->getType() == 'audio/mpeg') {
      return 'audiotrack';
    }
    return 'content_copy';
  }
}
