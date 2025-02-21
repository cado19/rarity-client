<?php
    require 'vendor/autoload.php';
    use Monolog\Level;
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    use Monolog\Handler\BrowserConsoleHandler;

    // create a log channel
    $log = new Logger('name');
    $log->pushHandler(new BrowserConsoleHandler);

    // add records to the log
    // $log->warning('Foo');
    // $log->error('Bar');

?>