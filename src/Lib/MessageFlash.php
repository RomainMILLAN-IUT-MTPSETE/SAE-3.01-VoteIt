<?php
namespace App\VoteIt\Lib;

use App\VoteIt\Model\HTTP\Session;

class MessageFlash
{

    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void
    {
        if(!self::contientMessage($type)){
            $array = self::lireTousMessages();
            $array[$type] = $message;

            $session = Session::getInstance();
            $session->enregistrer(static::$cleFlash, $array);
        }
    }

    public static function contientMessage(string $type): bool
    {
        if(Session::getInstance()->contient(self::$cleFlash)){
            $array = Session::getInstance()->lire(self::$cleFlash);
            return array_key_exists($type, $array);
        }else {
            return false;
        }

    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array
    {
        if(self::contientMessage($type) && Session::getInstance()->contient(self::$cleFlash)){
            $array = Session::getInstance()->lire(self::$cleFlash);
            $res = [$type=>$array[$type]];

            unset($array[$type]);
            Session::getInstance()->enregistrer(self::$cleFlash, $array);

            return $res;

        }else {
            return [];
        }
    }

    public static function lireTousMessages() : array
    {
        if(Session::getInstance()->contient(self::$cleFlash)){
            $array = Session::getInstance()->lire(self::$cleFlash);
            Session::getInstance()->enregistrer(self::$cleFlash, []);
            return $array;
        }else {
            return [];
        }
    }

}