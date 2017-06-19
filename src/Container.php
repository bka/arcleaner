<?php
// @codeCoverageIgnoreStart
$c = new \Pimple\Container();

$c['console.input'] = function ($c) {
    return new \Symfony\Component\Console\Input\ArgvInput();
};

$c['console.output'] = function ($c) {
    return new \Symfony\Component\Console\Output\ConsoleOutput();
};

$c['commands'] = function($c) {
    return [
        new \Bka\ARCleaner\Commands\ListImages(),
        new \Bka\ARCleaner\Commands\DeleteImage(),
    ];
};

$c['application'] = function($c) {
    $application = new \Symfony\Component\Console\Application('arcleaner', '@version');
    $application->addCommands($c['commands']);
    return $application;
};

return $c;
// @codeCoverageIgnoreEnd
