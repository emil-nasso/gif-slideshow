#!/usr/bin/env bash
osascript -e 'quit app "Google Chrome"'
php bin/console server:stop
sleep 1
php bin/console server:start
open -a "Google Chrome" --args --kiosk "http://127.0.0.1:8000"
