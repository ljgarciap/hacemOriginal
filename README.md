## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 03-08-20

Desarrolo para el grupo Sennova de investigación

## 04-08-20

Importante sobre el uso de seeders; el seeder unidadBase carga desde su mismo archivo uno a uno los datos; los demás seeder implementados hasta el dia de hoy cargan de archivos json ubicados en la ruta seeds/json esos son: areas, perfiles, procesos y roles; tener muy en cuenta que en el archivo DatabaseSeeder en donde incluimos las llamadas a los seeder hay que ser cuidadoso con la jerarquia pues las entidades dependen unas de otras, ponerlas secuenciales para no tener problema de que falte algo. Tambien hay que tener en cuenta que en este archivo se implemento una funcion que limpia las tablas y luego las llena con los seeder, asi que se debe ser cuidadoso si se van a correr nuevamente con los datos que se hayan ingresado a mano, si se desea conservar una opcion seria exportar el json desde la base y actualizar los archivos.

## 05-08-20

Se crearon seeders y modelos se llenaron con sus campos correspondiente;se creo un archivo llamado cuentas con el cual se poda ver las cuentas que quedaron predeterminadas para el ingreso de la plataforma.
