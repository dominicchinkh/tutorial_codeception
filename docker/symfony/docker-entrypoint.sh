#!/bin/bash
set -e

# Wait for our database to startup
# https://docs.docker.com/compose/startup-order/
/usr/bin/wait-for-it -h $DATABASE_SERVER -p $DATABASE_SERVER_PORT -t 0

# Run database migrations
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

# Execute the container's main process (CMD)
exec "$@"