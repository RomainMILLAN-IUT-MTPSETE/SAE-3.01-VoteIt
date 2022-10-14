<?php
namespace App\VoteIt\Model\Repository;
use App\VoteIt\Config\Conf;
use PDO;

  class DatabaseConnection {

      private static ?DatabaseConnection $instance = null;

      private $pdo = null;

      public function __construct()
      {
          $hostname = Conf::getHostname();
          $database_name = Conf::getDatabase();
          $login = Conf::getLogin();
          $password = Conf::getPassword();
          // Connexion à la base de données
          // Le dernier argument sert à ce que toutes les chaines de caractères
          // en entrée et sortie de MySql soit dans le codage UTF-8
          $this->pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,
              array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
          $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }

      public static function getInstance() : ?DatabaseConnection {
          if (is_null(static::$instance)) {
              static::$instance = new DatabaseConnection();
          }
          return static::$instance;
      }

      public static function getPdo(): PDO
      {
          return static::getInstance()->pdo;
      }










  }