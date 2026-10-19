<?php
declare(strict_types=1);
function e(string $v):string{return htmlspecialchars($v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function json_response(array $d,int $s=200):never{http_response_code($s);header('Content-Type: application/json; charset=utf-8');header('Cache-Control: no-store, max-age=0');echo json_encode($d,JSON_UNESCAPED_SLASHES|JSON_INVALID_UTF8_SUBSTITUTE);exit;}
function request_json():array{$r=file_get_contents('php://input');$d=$r?json_decode($r,true):[];return is_array($d)?$d:[];}
function sf(mixed $v,float $d=0):float{return is_numeric($v)&&is_finite((float)$v)?(float)$v:$d;}
function app_log(string $m):void{$d=ROOT_PATH.'/storage/logs';if(!is_dir($d))@mkdir($d,0750,true);@file_put_contents($d.'/app.log','['.date('c').'] '.$m.PHP_EOL,FILE_APPEND|LOCK_EX);}
