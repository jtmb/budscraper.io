# Build docker compose stack and set entry point script
web_app_name=budscraper_app
sudo docker compose --env-file nginx/.env -p "$web_app_name" -f "./nginx/docker-compose.yml" up -d --build
sudo docker exec $web_app_name-php-1 sh /usr/local/bin/entrypoint

echo
echo "-----------------------"
echo "                       "
echo "        RUNNING        "
echo "                       "
echo "-----------------------"