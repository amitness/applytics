<?php

/**
 * Database operations
 *
 * Performs SQL CRUD operations
 */

/**
 * Load MySQL connection
 */
require_once(__DIR__.DIRECTORY_SEPARATOR.'mysql.class.php');

class Database
{
    private $_db;
    public $lastInsertId;
    public $error = false;

    public function __construct()
    {
        $this->_db = MySQL::getConnection();
    }


    public function query($id, $type)
    {
        try {
          $sql = "SELECT * FROM comments WHERE app_id='$id' AND sentiment='$type'";
          $stmt = $this->_db->prepare($sql);
          // $stmt->bindValue(1, $id, PDO::PARAM_STR);
          // $stmt->bindValue(2, $type, PDO::PARAM_STR);
          $stmt->execute();
          return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function appIds()
    {
        try {
          $sql = 'SELECT appname, appid FROM app';
          $stmt = $this->_db->prepare($sql);
          $stmt->execute();
          return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function profile($id)
    {
        try {
          $sql = 'SELECT * FROM app WHERE appid=?';
          $stmt = $this->_db->prepare($sql);
          $stmt->bindValue(1, $id, PDO::PARAM_STR);
          $stmt->execute();
          return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function senti($id)
    {
      global $likes;
      global $dislikes;
        
        try {
          $sql = 'SELECT sentiment, count(app_id) AS cnt FROM comments WHERE app_id=? GROUP BY app_id';
          $stmt = $this->_db->prepare($sql);
          $stmt->bindValue(1, $id, PDO::PARAM_STR);
          $stmt->execute();
          $r =  $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach($r as $res)
          {
            $$res['sentiment'] = (int)$res['cnt'];
            if ($res['sentiment'] == 'TRUE')
            {
              $likes = 1;
              $dislikes = 0.3;
            }
            else
            {
              $likes = 0.3;
              $dislikes = 1;
            }
          }

          if (isset($TRUE) && isset($FALSE))
          {
            if ($likes > $dislikes) {
              $likes = 1;
              $dislikes = 0.1;
            } else {
              $likes = 0.1;
              $dislikes = 1;
            }
          }

        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

}
