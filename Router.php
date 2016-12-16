<?php

namespace RestPHP\Router;

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
     */
    private function translateURL($_url, $_callback)
    {
        $params = array();
        $folder = '/'.end( explode('/', __DIR__) );

        if( stripos($_url, ':') !== false ) {

            $data = $this->handlingURL($_url);

            if( count($data['url']) == count($data['attr']) ) {
                foreach ($data['url'] as $key => $value) {
                    if( stripos($value, ':') !== false ) {
                        if( stripos($value, '|') !== false ) {
                            $result = $this->validateATTR( explode('|', $value)[1], urldecode($data['attr'][$key]) );

                            if(is_null($result))
                                return null;
                            else
                                $params[substr(explode('|', $value)[0], 1)] = $result;
                        }
                        else
                            $params[substr($value, 1)] = urldecode($data['attr'][$key]);
                    }
                }
                call_user_func($_callback, $params);
            }
        }
        else if( $_SERVER ['REQUEST_URI'] == $folder.$_url )
            call_user_func($_callback);
    }

    /**
     * Valida um tipo de parametro da URL
     * @param $validator - o tipo do parametro indicado na rota
     * @param $attr - valor dado na URL
     * @return null|mixed - null para nao encontrado ou valor enncontrado
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
     * @param $_url - rota
     * @return array - url: array com indeces da rota, atttr: valores dos indices na url
     */
    private function handlingURL($_url)
    {
        $url = explode('/', $_url);
        $attr = explode("/", $_SERVER ['REQUEST_URI']);

        $url = array_filter( $url, function($v) { return !($v == ''); } );
        $attr = array_filter( $attr, function($v) { return !($v == ''); } );
        unset($attr[1]);

        return array( 'url' => array_values($url), 'attr' => array_values($attr) );
    }

    /**
     * Manipula uma rota com método GET
     * @param $_url - rota
     * @param $_callback - função para retorno
     */
    public function get($_url, $_callback)
    {
        if( $_SERVER['REQUEST_METHOD'] == "GET" )
            $this->translateURL($_url, $_callback);
    }

    /**
     * Manipula uma rota com método POST
     * @param $_url - rota
     * @param $_callback - função para retorno
     */
    public function post($_url, $_callback)
    {
        if( $_SERVER['REQUEST_METHOD'] == "POST" )
            $this->translateURL($_url, $_callback);
    }

    /**
     * Manipula uma rota com método PUT
     * @param $_url - rota
     * @param $_callback - função para retorno
     */
    public function put($_url, $_callback)
    {
        if( $_SERVER['REQUEST_METHOD'] == "PUT" )
            $this->translateURL($_url, $_callback);
    }

    /**
     * Manipula uma rota com método DELETE
     * @param $_url - rota
     * @param $_callback - função para retorno
     */
    public function delete($_url, $_callback)
    {
        if( $_SERVER['REQUEST_METHOD'] == "DELETE" )
            $this->translateURL($_url, $_callback);
    }
}

?>