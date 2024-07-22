
# Project Daniel

## Requirements

- Docker

## Setting Up the Application

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/DanielPalmSie/group-bwt.git
    cd project-daniel
    ```

2. **Start Docker Containers:**

   Ensure you have Docker and Docker Compose installed. Then, run the following command to start the application:

    ```bash
    docker-compose up -d
    ```

3. **Access the Docker Container:**

   Once the containers are up and running, access the PHP container:

    ```bash
    docker exec -it project-daniel-php bash
    ```

4. **Run the Application:**

   Inside the container, you can run the application with the following command:

    ```bash
    php index.php input.txt
    ```

## Running Tests

To run the tests, execute the following command inside the Docker container:

```bash
vendor/bin/phpunit
```