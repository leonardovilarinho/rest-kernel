<?php

namespace LegionLab\Rest\Collections;

/**
 * Control Settings
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:41
 */

abstract class Settings implements Collection
{
    /**
     * @var array - lista com variaveis de configuracao
     */
    private static $definitions = array();

    /**
     * Cria uma variavel de configuracao.
     *
     * @param $key - nome da variavel
     * @param $value - valor da variavel
     */
    public static function set($key, $value = '')
    {
        self::$definitions[$key] = $value;
    }

    /**
     * Resgata uma variavel de configuracao, retorna false se ela nao existir.
     *
     * @param $key - nome da variavel a pegar
     * @param $callback - função de callback
     * @return bool|mixed - false se nao encontrar, se encontrar retorna o valor da mesma
     */
    public static function get($key, $attr = '@')
    {
        if(array_key_exists($key, self::$definitions)) {
            return self::$definitions[$key];
        }
        return '';
    }

}
