#!/usr/bin/env bash
heroku run:detached './vendor/bin/phinx migrate -e production'