<?php

// include_once 'config.php';

class LDAP {

    protected $_global_ldap = null;

    protected function conecta() {
        if (isset($this->_global_ldap)) {
            return $this->_global_ldap;
        }
        /* No esta conectado */
        try {
            $this->_global_ldap = ldap_connect("ldap.sanidadnaval.cl");

            return $this->_global_ldap;
        } catch (Exception $ex) {
            $this->_global_ldap = null;
            return null;
        }
        /* bind anonimo */
        $conectado = @ldap_bind($this->_global_ldap);
        if ($conectado !== TRUE) {
            $this->_global_ldap = null;
        }
        return $this->_global_ldap;
    }

    public function busca_login($login) {
        $res = array('login' => $login, 'success' => FALSE, 'message' => '');

        self::conecta();

        if (!isset($this->_global_ldap)) {
            $res['message'] = 'LDAP no conectado';
            return $res;
        }

        $search = @ldap_search($this->_global_ldap,
                        "ou=Personas,dc=sanidadnaval,dc=cl",
                        "(uid=" . $login . ")",
                        array('dn', 'displayName'));
        $info = @ldap_get_entries($this->_global_ldap, $search);
        /*
          $res['LDAP'] = array(
          'global_ldap' => is_null($this->_global_ldap) ? "-null" : "--" . $this->_global_ldap,
          'search' => "$search",
          'info' => "$info",
          );
          /* */
        if (@$info['count'] == 0) {
            $res['message'] = 'Usuario no encontrado';

            return $res;
        } elseif (@$info['count'] > 1) {
            $res['message'] = 'Mas de un usuario encontrado';

            return $res;
        }
        /* usuario fue encontrado */
        $res['success'] = TRUE;
        $res['data'] = $info[0];
        return $res;
    }

    /**
     *
     * @param array $usuario
     * @param string $app
     * @return array
     */
    public function busca_grupos($usuario, $app) {
        self::conecta();
        if (!is_array($usuario)) {
            $usuario = array('success' => FALSE, 'login' => '', 'data' => array('dn' => ''));
            return $usuario;
        }
        $dn = @$usuario['data']['dn'];
        if (!isset($this->_global_ldap)) {
            $usuario['success'] = FALSE;
            return $usuario;
        }

        /**
         * Busca los grupos del usuario
         */
        $search = @ldap_search($this->_global_ldap,
//                        'ou=EventosAdversos,ou=Aplicaciones,ou=Grupos,dc=sanidadnaval,dc=cl',
                        'ou=' . $app . ',ou=Aplicaciones,ou=Grupos,dc=sanidadnaval,dc=cl',
                        '(memberUid=' . @$usuario['login'] . ')', array('dn', 'cn'));
        $info = @ldap_get_entries($this->_global_ldap, $search);
        $grupos = array('singrupo' => TRUE);
        if (is_array($info)) {
            foreach ($info as &$i) {
                if (!isset($i['cn'])) {
                    continue;
                }
                /**
                 * Fuerza que 'grupos' sea tratado como object y no como array
                 */
                $grupo = $i['cn'][0];
                $grupos [$grupo] = TRUE;
            }
        }
        $usuario['data']['grupos'] = $grupos;
        $usuario['success'] = TRUE;
        return $usuario;
    }
    /**
     *
     * @param array $usuario
     * @param string $password
     * @return array
     */
    public function valida_password($usuario, $password, $app) {
        self::conecta();
        if (!is_array($usuario)) {
            $usuario = array('success' => FALSE, 'login' => '', 'data' => array('dn' => ''));
            return $usuario;
        }
        $dn = @$usuario['data']['dn'];
        $conectado = @ldap_bind($this->_global_ldap, $dn, $password);
        if ($conectado !== TRUE) {
            $usuario['success'] = FALSE;
            return $usuario;
        }
        return $this->busca_grupos($usuario, $app);
    }

}

?>
