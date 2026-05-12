<?php

namespace App\Session;

class LoginCandidato
{
    private static function init()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($cand)
    {
        self::init();

        $_SESSION['candidato'] = [
            'id'   => $cand->id,
            'nome' => $cand->nome,
            'cpf'  => $cand->cpf,
            'email'=> $cand->email, 
        ];

        header('location: home.php');
        exit;
    }

    public static function getUsuarioLogado()
    {
        self::init();
        return $_SESSION['candidato'] ?? null;
    }

    public static function isLogged()
    {
        self::init();
        return isset($_SESSION['candidato']['id']);
    }

    public static function requireLogin()
    {
        if (!self::isLogged()) {
            header('location: index.php?erro=1');
            exit;
        }
    }

    public static function logout()
    {
        self::init();
        unset($_SESSION['candidato']);
        session_destroy();

        header('location: login.php');
        exit;
    }
}