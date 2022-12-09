<?php

require 'vendor/autoload.php';
$httpClient = new \GuzzleHttp\Client();

$response = $httpClient->get('https://meridiano.net/beisbol/beisbol-venezolano/249167/lvbp--tigres-de-aragua-aseveran-que-miguel-cabrera-tiene--mucha-posibilidad--de-jugar.html');
$htmlString = (string) $response->getBody();

// HTML is often wonky, this suppresses a lot of warnings
libxml_use_internal_errors(true);

$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);

$file = fopen("test.txt", "w");

$title = $xpath->evaluate('//meta[contains(@property,"og:title")]/@content');
if(count($title) > 0){
    echo "Title: " . $title[0]->textContent.PHP_EOL;
    fwrite($file, "Title: " . $title[0]->textContent.PHP_EOL);
}

$description = $xpath->evaluate('//meta[contains(@property,"og:description")]/@content');
if(count($title) > 0){
    echo "Description: " . $description[0]->textContent.PHP_EOL;
    fwrite($file, "Description: " . $description[0]->textContent.PHP_EOL);
}

$image = $xpath->evaluate('//div[contains(@class,"News Detail")]//img/@src');
if(count($image) > 0){
    echo "Image link: " . $image[0]->textContent.PHP_EOL;
    fwrite($file, "Image link: " . $image[0]->textContent.PHP_EOL);
}

$text = $xpath->evaluate('//*[@id="med"]');
if(count($image) > 0){
    echo "Text content: " . $text[0]->textContent.PHP_EOL;
    fwrite($file, "Text content: " . $text[0]->textContent.PHP_EOL);
}
fclose($file);