version de php 7.4.9 

version composer 2.2.18 

version phpMyAdmin 5.0.2


Pasos para utilizar el juego:

Ejecutar los siguientes comandos en la terminal

1.	composer install
2.	php bin/console doctrine:database:create
3.	php bin/console doctrine:schema:update --force 

Al iniciar el Juego el primer usuario Registrado será el Administrador una vez ingresado al juego debera ir al las 

opciones del administrador y agregar por lo menos 10 imágenes de lo contrario no podrá crear partidas

En la opción listar imágenes podrá agregar las características de cada imagen


en: Gwap/public/imagenesPrueba hay algunas imagenes que podria usar para utilizar el juego

pero debe agregarlas por medio de la opcion Agregar Imagen en el panel del administrador para que se vayan

agregando a la base de datos y al directorio public/assets


pagina de inicio:

http://localhost/gwap/public/login
