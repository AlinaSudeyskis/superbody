<?php

/**
 * Created by Alina Sudeyskis (alina.sudeyskis@gmail.com).
 * Date: 16.01.2018 12:51
 */
class YandexCheckout
{
    /**
     * YandexCheckout constructor.
     */
    public function __construct()
    {
        require __DIR__ . '/yandex-checkout/lib/autoload.php';
        require __DIR__ . '/yandex-checkout/vendor/autoload.php';
    }
}