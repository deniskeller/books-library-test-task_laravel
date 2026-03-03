<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-db', function () {
    try {
        // Проверка подключения
        DB::connection()->getPdo();

        // Получаем список всех таблиц
        $tables = DB::select('SHOW TABLES');

        // Преобразуем результат в читаемый вид
        $tableNames = array_map(function ($table) {
            return array_values((array)$table)[0];
        }, $tables);

        return response()->json([
            'success' => true,
            'message' => 'Подключение к БД успешно!',
            'database' => DB::connection()->getDatabaseName(),
            'tables' => $tableNames,
            'tables_count' => count($tableNames)
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ошибка подключения к БД',
            'error' => $e->getMessage()
        ], 500);
    }
});
