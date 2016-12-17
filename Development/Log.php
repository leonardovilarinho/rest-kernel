<?php

namespace LegionLab\Rest\Development;

use LegionLab\Rest\Collections\Settings;

/**
 * Control Log
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 12/07/2016
 * Time: 16:30
 */

class Log
{

    /**
     * Registra um novo log, o log padrao é mysql_errors, onde são salvos os erros do banco de dados
     * automaticamente é pego o horário do log, ip que o executou e adicionado no arquivo do log
     * com a mensagem passado por parametro.
     *
     * @param $msg - mensagem do log a ser salvo
     * @param string $archive - arquivo de log a ser adicionada a mensagem
     */
    public static function register($msg, $archive = 'mysql_errors')
    {
        echo ROOT . $archive;
        if(Settings::get('logs')) {
            $date = date('Y-m-d H:i:s');
            echo ROOT . $archive;
            if(file_exists(ROOT . $archive)) {
                $msg = "________________________________________________________\n" .
                    "___" . $date . " by " . $_SERVER['REMOTE_ADDR'] . "\n" .
                    $msg . "\n";
                file_put_contents(ROOT. $archive, $msg, FILE_APPEND);
            }
        }
    }
}
