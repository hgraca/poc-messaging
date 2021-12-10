<?php
echo $_ENV['CONTAINER_ROLE'] . "\n";

while(true) {
    sleep(60); // to make the container stay alive
}
