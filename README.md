# student-subject-network

project assignment from Advanced Database Systems


# installation of composer2

sudo apt install composer


curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer2

## run composer2 in project (there must exist composer.json):

composer2 install

# launching neo4j database

docker run     --name neo4j     -p7474:7474 -p7687:7687     -d     -v $HOME/neo4j/data:/data     -v $HOME/neo4j/logs:/logs     -v $HOME/neo4j/import:/var/lib/neo4j/import     -v $HOME/neo4j/plugins:/plugins     --env NEO4J_AUTH=neo4j/nbp     neo4j:3.4.18


# instalation of php-mongodb

sudo apt install php7.4-mongodb
sudo systemctl restart apache2

# launching mongodb database:

docker run -d -p 27017:27017 --name mongo_nbp -v mongo-data:/data/db  mongo:latest




