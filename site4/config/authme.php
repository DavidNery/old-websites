<?php

/*
 *  Copyright (C) 2015-2016  Leonardosc
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 *  21/01/2015
 */

class AuthMe {

	/* CONEXÃO DO BANCO DE DADOS. */
	private $connection;

	/*
        PARAMETROS
        $algo = Tipo de hash que seu authme está utilizando;
    */
	public function __construct($conexao) {
		$this->connection = $conexao;
	}

	/*
        METODO USADO PARA AUTENTICAR UM USUARIO, RETORNA true CASO OS
        DADOS ESTEJAM CORRETOS, CASO CONTRARIO RETORNA false.

        PARAMETROS
        $user = Nome de usuario.
        $pass = Senha do usuario.
    */
	public function authenticate($user, $pass) {
		$query = $this->connection->prepare("SELECT password FROM authme WHERE username=?");
		$query->bindParam(1, $user);
		$query->execute();

		if ($query->rowCount() == 1) {
			$ret = $query->fetch(PDO::FETCH_OBJ);
			$hash_pass = $ret->password;
			return self::compare($pass, $hash_pass);
		} else {
			return false;
		}
	}

	/* METODOS PRIVADOS, USO SOMENTE DA CLASSE. */
	private function compare($pass, $hash_pass) {
		$shainfo = explode("$", $hash_pass);
		$pass = hash("sha256", $pass) . $shainfo[2];
		return strcasecmp($shainfo[3], hash('sha256', $pass)) == 0;
	}

	private function AMHash($pass) {
		$salt = self::createSalt();
		return "\$SHA\$" . $salt . "\$" . hash("sha256", hash('sha256', $pass) . $salt);
	}

	private function createSalt() {
		$salt = "";
		for ($i = 0; $i < 20; $i++) {
			$salt .= rand(0, 9);
		}
		return substr(hash("sha1", $salt), 0, 16);
	}
}