<?php

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function register($data) {
        if (!isset($data['username'], $data['email'], $data['password'])) {
            return ['status' => false, 'message' => 'Formatação inválida'];
        }

        if ($this->userModel->register($data['username'], $data['email'], $data['password'])) {
            return ['status' => true, 'message' => 'Usuário registrado com sucesso'];
        }
        return ['status' => false, 'message' => 'O registro de usuário falhou'];
    }

    public function login($data) {
        if (!isset($data['email'], $data['password'])) {
            return ['status' => false, 'message' => 'Formatação inválida'];
        }

        $user = $this->userModel->login($data['email'], $data['password']);
        if ($user) {
            return ['status' => true, 'message' => 'Login feito com sucesso', 'user' => $user];
        }
        return ['status' => false, 'message' => 'Credenciais inválidas'];
    }
}
