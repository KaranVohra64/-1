#!/bin/bash

dat=$(curl -s "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=MSFT&apikey=demo" | tr -dc '[A-Za-z0-9.: {}][ ]\n')
pat="(.*)^{\s([A-Za-z\s]+):\s{\s|\d.\s([A-Za-z ]+):\s([a-zA-Z,\s]+|\d{8}\s\d{1,3}:\d{1,2}:\d{1,2})|[\s}\s]([A-Za-z\s]+)[:\s{\s]|(\d{1,8})[\s:\s{\s]|[\s]\d.\s([A-Za-z]+?):\s(\d+[.]\d{1,4}|\d+)"
[[ $dat =~ $pat ]] && echo ${BASH_REMATCH[0]}
echo ${#BASH_REMATCH[@]}
#echo $dat
