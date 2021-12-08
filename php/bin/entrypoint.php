<?php
echo $_ENV['CONTAINER_ROLE'] . "\n";

//if [ "$role" = "builder" ]; then
//    exec php /var/www/php/bin/build.php;
//elif [ "$role" = "producer" ]; then
//    exec php /var/www/php/bin/producer.php;
//elif [ "$role" = "consumer" ]; then
//    exec php /var/www/php/bin/consumer.php;
//elif [ "$role" = "scheduler" ]; then
//    while [ true ]
//    do
//        exec php /var/www/php/bin/scheduler.php;
//        sleep 60
//    done
//else
//    # Execute command specified on container
//    exec "$@"
//fi
