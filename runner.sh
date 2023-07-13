# Build docker compose stack and set entry point script
sudo docker compose --env-file nginx/.env -p "msg-converter" -f "./nginx/docker-compose.yml" up -d --build
sudo docker exec msg-converter-php-1 sh /usr/local/bin/entrypoint

echo
echo "-----------------------"
echo "                       "
echo "        RUNNING        "
echo "                       "
echo "-----------------------"