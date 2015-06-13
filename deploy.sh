#!/usr/bin/env bash

# "run:detach" because "run" has problem on fastweb:
# http://stackoverflow.com/questions/8582860/heroku-run-console-get-timeout-awaiting-process
heroku run:detached './vendor/bin/phinx migrate -e production'

sleep 60 # There is no simple way to know when migrations are completed, for now this is good enough.
git push heroku master