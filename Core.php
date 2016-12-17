<?php

namespace LegionLab\Rest;
use LegionLab\Rest\Router\Router;
use LegionLab\Rest\Collections\Settings;

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:34
 */

class Core extends Router
{
    public function __construct()
    {
        if(!defined("DOMAIN")) {
            $path = dirname($_SERVER["SCRIPT_NAME"]);
            $path = str_replace('/public', '', $path);
            if ($path === '/')
                $path = '';
            define('DOMAIN', $path);
        }

        if(!defined("ROOT")) {
            $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"].DOMAIN.'/';
            if ($path === '/')
                $path = '';
            define('ROOT', $path);
        }

        $this->importKernelUtil();
    }

    private function importKernelUtil()
    {
        require_once ROOT."settings/setups.php";

        if(Settings::get('deployment'))
            require_once ROOT."settings/database.php";
    }

}
