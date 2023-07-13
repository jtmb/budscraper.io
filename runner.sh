# Build docker compose stack and set entry point script
sudo docker compose --env-file nginx/.env -p "msg-converter" -f "./nginx/docker-compose.yml" up -d --build
sudo docker exec msg-converter-php-1 sh /usr/local/bin/entrypoint

# Show random generated db_pwd at the end of build
db_pwd=$(cat ~/repos/msg-converter/web-app/nginx/.env | rev | cut -d "=" -f1 | rev)

echo
echo "-----------------------"
echo db login info: 
echo "user; root"
echo "pwd; $db_pwd"
echo "-----------------------"