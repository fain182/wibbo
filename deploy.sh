#!/usr/bin/env bash

git push heroku master
# "run:detach" because "run" has problem on fastweb:
# http://stackoverflow.com/questions/8582860/heroku-run-console-get-timeout-awaiting-process
heroku run:detached './vendor/bin/phinx migrate -e production'
