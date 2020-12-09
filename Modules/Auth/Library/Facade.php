<?php


namespace Modules\Auth\Library;





class Facade
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Facade();
        }

        return self::$instance;
    }

    public function generateMobileVerifyCodeRandom()
    {
        $result = 1;
        $length = env('MOBILE_VERIFY_CODE_LENGTH', 4);
        for ($i = 0; $i < $length-1; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;


    }
}
