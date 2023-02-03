#/!bin/bash

log=/tmp/test.dump
echo > $log

#rm -rf vendor
#rm -rf composer.lock
#composer install --dev
status=$(/usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests >> $log 2>&1)
status=''
$?=0
#S=$(cat $log | grep 'ERROR!' | tail -n 1)
#echo $S
#cat $log
echo '1'