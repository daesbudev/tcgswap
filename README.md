# tcgswap
Trabajo de fin de grado para el ciclo superior de Desarrollo de Aplicaciones Web para I.E.S. Ágora (curso 2022/2023).

## Uso del producto
Para poder desplegar el proyecto en local será necesario instalar XAMPP, ya que será necesario 
interpretar PHP y añadir la base de datos incluida en el paquete [tcgswap.sql](https://github.com/daesbudev/tcgswap/blob/main/tcgswap.sql).
Una vez instalado XAMPP, debemos dirigirnos a la ruta donde se haya instalado y situarnos 
en la carpeta **htdocs**. Una vez ahí, clonamos el repositorio e importamos la base de datos
en phpMyAdmin. <br>
Con esto la aplicación está lista para ser utilizada. dentro de la tabla usuarios podremos
encontrar usuarios preparados para iniciar sesión, la contraseña es 12345 para todos ellos. <br>
También se incluye en el paquete la memoria realizada para el proyecto [aquí](https://github.com/daesbudev/tcgswap/blob/main/2W_Estévez_Bueso_Dario.pdf).


## ¿Qué es tcgswap?
Este proyecto surge a partir de una de mis aficiones, que es el juego **Magic: The
Gathering**. Funciona sobre la idea de intercambiar cartas entre personas, algo que ya
se realiza dentro de sus comunidades de jugadores de manera presencial. Yo planteo
una manera de hacerlo online a través de un portal, permitiendo poder realizar ofertas
de intercambio a cualquier persona dentro de la plataforma que tenga artículos para
hacerlo.

## Metodología, lenguajes y tecnologías utilizadas
Esta aplicación se ha desarrollado sobre el editor de código Visual Studio Code y el patrón elegido para 
organizar la estructura de la aplicación ha sido el MVC.<br>
Los lenguajes utilizados han sido **HTML**, **CSS**, **PHP** (principalmente en back end aunque en algunas situaciones se ha usado en front end),
**JavaScript** y **SQL**. <br>
Cabe destacar el uso del framework **Bootstrap 5** para el estilo de la aplicación y
las librerías **jQuery** (principalmente para el uso de AJAX) y **Sweet Alerts 2** (alertas personalizadas y más dinámicas).   
