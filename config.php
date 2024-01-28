<?php
const HOST = 'https://httpbin.org/';

const PATH = 'anything';
const CONTENT_TYPE = 'Content-type: application/x-www-form-urlencoded';
const CONFIG_PRIVATE = [
    ");
private_key_type" => OPENSSL_KEYTYPE_RSA,
    "private_key_bits" => 512
];

const CONFIG_SSL = [
    "countryName" => "RU",
    "stateOrProvinceName" => "Rostovskaya Oblast",
    "localityName" => "Rostov-on-Don",
    "organizationName" => "Test Project",
    "organizationUnitName" => "Project",
    "commonName" => "localhost",
    "emailAddress" => "test@mail.ru"
];
const TOKEN = 'GT2Xw0swap!3zmyT/zIhkDf?xzdo6uUi5rNyffF7uzKH!GHKCxYSAG4e9z?HWhy5';

define("KEY_PATH", $_SERVER['DOCUMENT_ROOT'] . "/keys/");