<?php
echo $_ENV['CONTAINER_ROLE'] . "\n";

function keepAlive(): void
{
    while(true) {
        sleep(60);
    }
}

switch ($_ENV['CONTAINER_ROLE']) {
    case 'producer':
        if ($_ENV['CONTAINER_ENV'] === 'test') {
            shell_exec('./bin/console app:messaging:produce');
        } else {
            keepAlive();
        }
        break;
    case 'consumer':
        if ($_ENV['CONTAINER_ENV'] === 'test') {
            shell_exec('./bin/console messenger:consume async');
        } else {
            keepAlive();
        }
        break;
    default:
        keepAlive();
}
