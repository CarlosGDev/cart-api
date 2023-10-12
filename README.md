## Cart API with Symfony 6 

## Install:
* Run `docker-compose up -d --build`
* Run `docker-compose exec php bin/setup_db.sh` to load fixtures

## API DOC
* You can go to http://localhost:8080/api/doc and try the shop api  

![api doc_img](doc/img/api_doc.png)
![api doc_img](<iframe src="doc/img/api_doc.png" height="200px" width="400px"></iframe>)


## Data Base Design

![db_design_img](doc/img/db_design.png)

## Test
* Run `docker-compose exec php make all`
