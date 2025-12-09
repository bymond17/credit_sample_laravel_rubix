<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sys:status', function () {
    $this->info('시스템 상태 정보');
    $this->line('----------------------');
    $this->line('PHP 버전: ' . phpversion());
    $this->line('서버 시간: ' . date('Y-m-d H:i:s'));
    $this->line('메모리 사용량: ' . round(memory_get_usage() / 1024 / 1024, 2) . ' MB');
    $this->line('최대 메모리: ' . ini_get('memory_limit'));
    $this->line('운영체제: ' . PHP_OS);
})->purpose('서버의 PHP/메모리/시간 등 시스템 상태를 출력');
