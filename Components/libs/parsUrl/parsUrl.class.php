<?php

/**
 * parsUrl.class
 * release 1.0.0
 */
if (!defined('MODX_BASE_PATH')) {
    die('What are you doing? Get out of here!');
}

/**
 * include_once MODX_BASE_PATH.'assets/libs/parsUrl.php';
 * Class parsUrl
 * @package gpz
 */
class parsUrl
{
    /**
     * @param string $url
     * @param array $post
     * @return mixed
     */
    static public function request($url = '', $post = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // отправляем на
        curl_setopt($ch, CURLOPT_HEADER, 0); // пустые заголовки
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);// таймаут4
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // время на выполнения скрипта
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); // сохранять куки в файл
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 YaBrowser/16.6.0.8149 Yowser/2.5 Safari/537.36");
        curl_setopt($ch, CURLOPT_POST, $post !== 0); // использовать данные в post
        if ($post)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $data['page'] = curl_exec($ch);
        $data['info'] = curl_getinfo($ch);
        $data['error'] = curl_error($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * чтение страницы после авторизации
     *
     * @param string $url
     * @param string $post
     * @return mixed
     */
    static public function read($url = '', $post = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // откуда пришли на эту страницу
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);// таймаут4
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);// время на выполнения скрипта
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //отсылаем серверу COOKIE полученные от него при авторизации
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        curl_setopt($ch, CURLOPT_POST, $post !== 0); // использовать данные в post
        if ($post)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $data['page'] = curl_exec($ch);
        $data['info'] = curl_getinfo($ch);
        $data['error'] = curl_error($ch);

        curl_close($ch);
        return $data;
    }

    /**
     * @param string $url
     * @param string $post
     * @param array $headers
     * @return mixed
     */
    static public function read_ajax($url = '', $post = '', $headers = [])
    {
        if (count($headers) == 0) {
            $headers = array(
                "POST " . $url . " HTTP/1.0",
                "Content-type: application/x-www-form-urlencoded; charset=UTF-8",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "Origin:" . $url . "",
                "Referer:" . $url . "/as/",
                "X-Requested-With:XMLHttpRequest"
            );
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // откуда пришли на эту страницу
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_HTTP200ALIASES, array(400, 403));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);// таймаут4
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);// время на выполнения скрипта
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //отсылаем серверу COOKIE полученные от него при авторизации
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        curl_setopt($ch, CURLOPT_POST, $post !== 0); // использовать данные в post
        if ($post)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $data['page'] = curl_exec($ch);
        $data['info'] = curl_getinfo($ch);
        $data['error'] = curl_error($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param string $url
     * @param string $post
     * @param array $headers
     * @return mixed
     */
    static function request_header($url = '', $post = '', $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // отправляем на

        if (count($headers) == 0) {
            $headers = array(
                'https://www.myus.com/_/ShippingRate/CalculateShippingRate', 'Cookie: WWWBackend=WWWBackend_eWEB_152; visited=true; browsersFirstLanguageCode=en; PreferedLanguage=en; showLanguageToggle=True; optimizelyEndUserId=oeu1470927288691r0.18889179695310032; RegOptionsId=3; optimizelySegments=%7B%222674220236%22%3A%22direct%22%2C%222674650847%22%3A%22gc%22%2C%222680570370%22%3A%22false%22%2C%224405061305%22%3A%22none%22%7D; optimizelyBuckets=%7B%226407810704%22%3A%226407850674%22%7D; _ceg.s=obr6yt; _ceg.u=obr6yt; _ga=GA1.2.796823331.1470927280', 'Origin: https://www.myus.com', 'Accept-Encoding: gzip, deflate, br', 'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4', 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8', 'Accept: application/json, text/javascript, */*; q=0.01', 'Referer: https://www.myus.com/as/', 'X-Requested-With: XMLHttpRequest', 'Connection: keep-alive');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } else {
            curl_setopt($ch, CURLOPT_HEADER, TRUE); // пустые заголовки
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);// таймаут4
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // время на выполнения скрипта
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); // сохранять куки в файл
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 YaBrowser/16.7.0.3342 Safari/537.36");
        curl_setopt($ch, CURLOPT_POST, $post !== 0); // использовать данные в post
        if ($post) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $data['page'] = curl_exec($ch);
        $data['info'] = curl_getinfo($ch);
        $data['error'] = curl_error($ch);
        curl_close($ch);

        return $data;
    }

}