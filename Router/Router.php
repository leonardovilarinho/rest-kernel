<?php

namespace LegionLab\Rest\Router;

use LegionLab\Rest\Collections\Settings;

/**
 * Class Router
 * @package RestPHP\Router
 */
class Router
{

    /**
     * Traduz uma rota, verifica se ela possui atributos e validadores, então pega tudo e envia em forma de array para
     * o callback, sendo um array com os valores dos parametros da rota
     * @param $_url - rota
     * @param $_callback - função para retorno
     * @param $attrs - atributos da url
     * @return null - caso não encontre nada
     */
    private function translateURL($_url, $_callback, $attrs = null)
    {
        $params = array();

        if( strpos($_SERVER ['REQUEST_URI'], str_replace($_SERVER['HTTP_HOST'], '', Settings::get('api_url').$_url))  !== false) {
            if(!is_null($attrs)) {
                $values = $this->handlingURL($_url);

                if( count($attrs) == count($values) ) {
                    $count = 0;
                    foreach ($attrs as $key => $value) {
                        $result = $this->validateATTR( $value, $values[$count] );

                        if(is_null($result))
                            return null;
                        else
                            $params[$key] = $result;
                        $count ++;
                    }
                    call_user_func($_callback, $params);
                }
            } else {

                if ($_SERVER ['REQUEST_URI'] === str_replace($_SERVER['HTTP_HOST'], '', Settings::get('api_url').$_url)) {
                    global $_PUT, $_DELETE;

                    if(count($_POST) == 0 and $_SERVER['REQUEST_METHOD'] == 'POST')
                        call_user_func($_callback);
                    if(count($_PUT) == 0 and $_SERVER['REQUEST_METHOD'] == 'PUT')
                        call_user_func($_callback);
                    if(count($_DELETE) == 0 and $_SERVER['REQUEST_METHOD'] == 'DELETE')
                        call_user_func($_callback);
                    if(count($_GET) == 0 and $_SERVER['REQUEST_METHOD'] == 'GET')
                        call_user_func($_callback);
                }

            }
        }
        return null;
    }

    /**
     * Valida um tipo de parametro da URL
     * @param $validator - o tipo do parametro indicado na rota
     * @param $attr - valor dado na URL
     * @return null@mixed - null para nao encontrado ou valor enncontrado
     */
    private function validateATTR($validator, $attr)
    {
        switch (trim($validator)) {
            case 'any':
                return $attr;
            case 'int':
                return (filter_var($attr, FILTER_VALIDATE_INT)) ? $attr : null;
            case 'bool':
                switch ($attr) {
                    case 'y':
                        return $attr;
                    case 'n':
                        return false;
                    case '1':
                        return $attr;
                    case '0':
                        return false;
                    case 'true':
                        return $attr;
                    case 'false':
                        return false;
                    default:
                        return null;
                }
            case 'email':
                return (filter_var($attr, FILTER_VALIDATE_EMAIL)) ? $attr : null;
            case 'float':
                return (filter_var($attr, FILTER_VALIDATE_FLOAT)) ? $attr : null;
            case 'ip':
                return (filter_var($attr, FILTER_VALIDATE_IP)) ? $attr : null;
            case 'string':
                return (is_string($attr)) ? $attr : null;
            default:
                return null;
        }
    }

    /**
     * Manipula a URL, transformando-a em um array de valores da rota e seus determinados valores
     * @param $route - rota
     * @return array - url: array com indeces da rota, atttr: valores dos indices na url
     */
    private function handlingURL($route)
    {
        $values = array();

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $values = explode('/', $_SERVER ['REQUEST_URI']);
            break;
            case 'POST':
                $values = $_POST;
            break;
            case 'PUT':
                global $_PUT;
                parse_str(file_get_contents("php://input"), $_PUT);
                $values = $_PUT;
            break;
            case 'DELETE':
                global $_DELETE;
                parse_str(file_get_contents("php://input"), $_DELETE);
                $values = $_DELETE;
            break;
            default:
                $attr = null;
        }

        foreach ($values as $key => $value) {
            if(!empty($value))
                if( strpos(Settings::get('api_url'), $value) !== false or  strpos($route, $value) !== false )
                    unset($values[$key]);
        }

        $values = array_filter( $values, function($v) { return !($v == ''); } );
        return array_values($values);
    }

    /**
     * Manipula uma rota com método GET
     * @param $_url - rota
     * @param $_callback - função para retorno
     */
    public function get($_url, $_callback, $attrs = null)
    {
        if( $_SERVER['REQUEST_METHOD'] == "GET" )
            $this->translateURL($_url, $_callback, $attrs);
    }

    /**
     * Manipula uma rota com método POST
     * @param $_url - rota
     * @param $_callback - função para retorno
     */
    public function post($_url, $_callback, $attrs = null)
    {
        if( $_SERVER['REQUEST_METHOD'] == "POST" )
            $this->translateURL($_url, $_callback, $attrs);
    }

    /**
     * Manipula uma rota com método PUT
     * @param $_url - rota
     * @param $_callback - função para retorno
     * @param $attrs - atributos que recebemos
     */
    public function put($_url, $_callback, $attrs = null)
    {
        if( $_SERVER['REQUEST_METHOD'] == "PUT" )
            $this->translateURL($_url, $_callback, $attrs);
    }

    /**
     * Manipula uma rota com método DELETE
     * @param $_url - rota
     * @param $_callback - função para retorno
     */
    public function delete($_url, $_callback, $attrs = null )
    {
        if( $_SERVER['REQUEST_METHOD'] == "DELETE" )
            $this->translateURL($_url, $_callback, $attrs);
    }
}

?>