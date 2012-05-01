#!/bin/bash
wget "http://pecl.php.net/get/APC"
tar -xzf APC
cd APC-*
phpize && ./configure && make && make install
echo "extension=apc.so
[apc]
apc.enabled = 1
apc.enable_cli = 1" > `php --ini | grep "Loaded Configuration File" | sed -e "s|.*:\s*||"`