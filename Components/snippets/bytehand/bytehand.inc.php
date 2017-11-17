<?php
/*
 * @name ByteHand
 * @description Send SMS to the mobile phone after execution to different actions on the site.
 * @version 0.1.1 (requires MODx Evolution 0.9.5+)
 * @author Vyacheslav Zadunaisky <ifourspb@gmail.com>
 *
 * Required params:
 * @param &id The ID on service bytehand.com
 * @param &key The key on service bytehand.com
 * @param &phone Phone number recipient in format [code country][code city or mobile company][phone number]
 * @param &text Max length - 800 symbols, but it will be cutted to several messages - 160 latin or 70 cyrillic letters - per each other.
 * @param &postname Variable name of POST query for action to send message
 * @param &postvalue Value the variable of POST query for action to send message
 *
 * Optional params:
 * @params &translit Transliteration text
 * @params &formatphone Convert phone number in Russian format
 
 *
 * @license Public Domain, use as you like.
 * @example [[Bytehand? &phone=`79507231253` &text=`Hello world!` &postname=`form` &postvalue=`feedback`]]
 * After execution to different actions on site, snippet will check variable $_POST['form'] = 'feedback', then
 * will send message on mobile phone.

 * @example [[Bytehand? &phone=`79507231253` &text=`Hello world!`&getname=`form` &getvalue=`feedback`]]
*  After execution to different actions on site, snippet will check variable $_GET['form'] = 'feedback', then
 * will send message on mobile phone.
 */

require_once $modx->config['base_path'] . "assets/snippets/bytehand/bytehand.class.php";
if ($postname != '' and $postvalue != '' and $_POST[$postname] == $postvalue) {
    $bh = new byteHandApi($BYTEHAND['ID'], $BYTEHAND['KEY'], $BYTEHAND['FROM']);

    $params['text'] = ($translit) ? $bh->rus2translit($text) : $text;
    $params['to'] = ($formatphone) ? $bh->format($phone) : $phone;

    //Send SMS
    $response = $bh->api('send', $params);
}

if ($getname != '' and $getvalue != '' and $_GET[$getname] == $getvalue) {

    $bh = new byteHandApi($BYTEHAND['ID'], $BYTEHAND['KEY'], $BYTEHAND['FROM']);

    $params['text'] = ($translit) ? $bh->rus2translit($text) : $text;
    $params['to'] = ($formatphone) ? $bh->format($phone) : $phone;

    //Send SMS
    $response = $bh->api('send', $params);
}

if ($k == 1) {
    echo 'Сработало';
    $bh = new byteHandApi($BYTEHAND['ID'], $BYTEHAND['KEY'], $BYTEHAND['FROM']);

    $params['text'] = ($translit) ? $bh->rus2translit($text) : $text;
    $params['to'] = ($formatphone) ? $bh->format($phone) : $phone;

    // Send SMS
    $response = $bh->api('send', $params);
}