<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "1. PHP funcionando<br>";

if (file_exists('config.php')) {
    echo "2. config.php encontrado<br>";
    try {
        require_once 'config.php';
        echo "3. config.php carregado OK<br>";
    } catch (Throwable $e) {
        echo "3. ERRO no config.php: " . $e->getMessage() . "<br>";
    }
} else {
    echo "2. config.php NÃO ENCONTRADO<br>";
}

if (file_exists('models/DataBase.php')) {
    echo "4. DataBase.php encontrado<br>";
    try {
        require_once 'models/DataBase.php';
        echo "5. DataBase.php carregado OK<br>";
    } catch (Throwable $e) {
        echo "5. ERRO no DataBase.php: " . $e->getMessage() . "<br>";
    }
} else {
    echo "4. DataBase.php NÃO ENCONTRADO<br>";
}

echo "6. Fim do debug<br>";
