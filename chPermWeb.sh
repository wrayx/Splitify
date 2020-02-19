#!/bin/bash

echo "----------------dirs-----------------"
for a in $(find $1 -type d ! -perm 711); do
    chmod 711 $a
    echo "$a perm has been changed to $(stat -c "%A" $a)"
done

echo "----------------web-----------------"
for b in $(find $1 -type f ! -perm 744); do
    chmod 744 $b
    echo "$b perm has been changed to $(stat -c "%A" $b)"
done

echo "----------------db-----------------"
for c in $(find $1 -type f -iname '*.db' ! -perm 777); do
    chmod 777 $c
    echo "$c perm has been changed to $(stat -c "%A" $c)"
done

echo "----------------php-----------------"
for d in $(find $1 -type f -iname '*.php' ! -perm 755); do
    chmod 755 $d
    echo "$d perm has been changed to $(stat -c "%A" $d)"
done

