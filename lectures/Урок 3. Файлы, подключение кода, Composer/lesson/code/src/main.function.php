<?php

function main(string $configFileAddress): string{
    $config = readConfig($configFileAddress);
    
    if (!$config) {
        return handleError("Невозможно подключить файл настроек");
    }

    $storageFileAddress = $config['storage']['address'];

    $functionName = parseCommand();

    if (function_exists($functionName)) {
        $result = $functionName($storageFileAddress);
    } else {
        $result = handleError("Вызываемая функция не существует");
    }

    return $result;
}


function parseCommand(): string{
    $functionName = 'helpFunction';

    if (isset($_SERVER['argv'][1])) {
        $functionName = match ($_SERVER['argv'][1]) {
            'read-all' => 'readAllFunction',
            'add' => 'addFunction',
            'clear' => 'clearFunction',
            'help' => 'helpFunction',
            default => 'helpFunction'
        };
    }

    return $functionName;
}
