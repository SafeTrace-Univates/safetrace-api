#!/bin/bash

set -e

# Pull latest changes from git
echo -e "\033[0;34mPulling latest changes from git...\033[0m"
if ! git pull origin; then
   echo -e "\033[0;31mError: Failed to pull latest changes from git.\033[0m"
   exit 1
fi

# Rebuild and start containers
echo -e "\033[0;34mRebuilding and starting Docker containers...\033[0m"
if ! docker compose -f 'docker-compose.yml' up -d --build; then
    echo -e "\033[0;31mError: Failed to rebuild and start Docker containers.\033[0m"
    exit 1
fi

echo -e "\033[0;34mPruning unused Docker images...\033[0m"
if docker system prune -a -f; then
    echo -e "\033[0;34mSuccessfully pruned unused Docker images.\033[0m"
else
    echo -e "\033[0;31mError: Failed to prune unused Docker data.\033[0m"
    exit 1
fi


# Check if the containers are running
if docker compose ps | grep -q 'Up'; then
    echo -e "\033[0;34mDocker containers are up and running.\033[0m"
    echo -e "\033[0;34mDeployment successful!\033[0m"
    exit 0
else
    echo -e "\033[0;31mError: Failed to start Docker containers.\033[0m"
    exit 1
fi
    exit 1
fi
# End of deploy.sh
# This script stops the current Docker containers, pulls the latest code from the master branch,
# and then rebuilds and starts the containers using Docker Compose.
# Ensure that the script is executable: chmod +x deploy.sh
# Run the script with: ./deploy.sh
# Make sure you have Docker and Docker Compose installed and configured properly.
# This script assumes that the Docker Compose file is named 'docker-compose.yml'.
# Adjust the file name if necessary.
