# student-subject-network

project assignment from Advanced Database Systems

## Setup enviroment

Installation goes in few steps because we need to install docker and two databases:
1. Install [php](https://web.math.pmf.unizg.hr/nastava/rp2d/slideovi/Predavanje-01-Uvod.pdf)
2. Installation of composer2 
   ```
   $ sudo apt install composer

   # We need to install composer2
   $ curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer2
   ```

   Now we can use composer2: _composer2 \<some command\>_  

3. Delete in project `vendor` and `composer.lock`
4. Move to project directory `cd student-subejct-network`
5. Run composer2 in project (`composer.json` must exist)
   ```
   $ composer2 install
   ```
6. [Install docker](https://www.simplilearn.com/tutorials/docker-tutorial/how-to-install-docker-on-ubuntu)
7. (Optional) Manage docker as non root user 
   ```
   # Create group that can run docker without sudo
   $ sudo groupadd docker
   
   
   # Add yourself to that group
   $ sudo usermod -aG docker $USER
   
   
   # Test everything is working
   $  docker run hello-world
   ```
8. Install and lunch docker neo4j database container
   ```
   $ docker run --name neo4j -p 7474:7474 -p 7687:7687 -d -v $HOME/neo4j/data:/data -v $HOME/neo4j/logs:/logs -v $HOME/neo4j/import:/var/lib/neo4j/import -v $HOME/neo4j/plugins:/plugins --env NEO4J_AUTH=neo4j/nbp neo4j:3.4.18
   ```
9. Install php-mongodb
   ```
   # Install php7.4-monogdb
   $ sudo apt install php7.4-mongodb
   
   
   # Restart apache2 server so installation take effect
   $ sudo systemctl restart apache2
   ```
10. Install and lunch docker mongodb container
   ```
   $ docker run -d -p 27017:27017 --name mongo_nbp -v mongo-data:/data/db mongo:latest
   ```
   
## Run project
If you did't run mongo and neo4j container go and do 8. and 10. step from [Setup enviroment](#setup-enviroment)
1. Move this project to your `public_html` directory
2. Go in browser on [localhost/~username/student-subject-directory](http://localhost/~username/student-subject-directory)

sudo docker exec -it mongo_nbp mongo


