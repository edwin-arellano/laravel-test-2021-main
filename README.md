# Prueba de habilidades creando APIs REST con Laravel

La siguiente prueba pretender evaluar las habilidades y conocimientos creando APIs REST con Laravel. Además de eso se busca conocer la capacidad del evaluado adaptándose a un proyecto existente, comprendiendo el código y creando soluciones a partir de el.

La prueba consiste en culminar diversas características de un sistema de compra y venta de productos, tipo MercadoLibre, con la base de la API previamente programada. Este sistema busca realizar las siguientes acciones:

- Restringir el acceso a los diversos endpoints para que sólo usuarios autenticados puedan interactuar con ellos
- Crear y listar productos
- Comprar y vender productos a partir del usuario en sesión
- Listar los productos en venta pertenecientes a un usuario

## La base de la API comprende:

- Formato de las respuestas de la API (Errores, mensajes de éxito y devolución de contenido)
- Autenticación con Passport con los controladores y rutas para registrar un usuario, iniciar sesión y cerrar sesión
- Migraciones y modelos del sistema
- Factories para crear 20 productos, 4 usuarios y 10 transacciones

### Diagrama de modelos y relaciones

![Modelos y relaciones](https://i.ibb.co/VBnpmCq/Captura-de-pantalla-de-2021-07-08-03-38-18.png "Modelos y relaciones")


### Endpoints implementados

- __POST api/auth/login__ *Autenticación del usuario*
    - Recibe *email*, *passowrd* y opcionalmente *remember_me*
    - Regresa *access_token* el cual se utilizará como token de autorización.
- __GET api/auth/logout__ *Elimina el token de autorización*
    - Regresa un mensaje de confirmación en caso exitoso
- __GET api/products__ *Listado de productos de los poductos registrados con stock*
    - Este endpoint no tiene restricciones de acceso.
    - Solo se listará aquellos productos con un valor mayor a 0 en su propiedad *quantity*.
    - Opcionalmente puede recibir el parámetro *name* para realizar el filtrado de los productos. Este valor puede ser algún fragmento del nombre.
- __POST api/products__ *Creación de un producto por el usuario en sesión*
    - Recibe *name*, *description* y *quantity*
    - El valor para *user_id* será determinado por el usuario en sesión. De esta manera se vinculará el producto con el usuario que lo registró y se contabilizará como "producto ofrecido".
    - Regresa un mensaje de confirmación en caso exitoso


## Por hacer

### Pruebas y correcciones
- [ ] Validar que el los endpoints ya existentes funcionen tal cual se describen.
- [ ] Se debe corregir un bug en el endpoint **GET api/products**

### Endpoints
- [ ] __GET api/profile__ *Datos del usuario en sesión*
    - Incluir las siguentes propiedades:
        - *purchases* (contador de compras)
        - *products* (contador de productos ofrecidos por el usuario en sesion)
- [ ] __GET api/profile/purchases__ *Listado de compras (transacciones) del usuario en sesión*
- [ ] __POST api/products/:id/buy__ *Realizar la compra de un producto*
    - Decremetar el número de stock al realizar una venta
    - Crear restricción que no permita crear una transacción si la cantidad productos a comprar supera el número de productos en stock

## Consideraciones Generales

### Autenticación
El seeder genera 4 usuarios, la contraseña por defecto es *password* para cualquiera de ellos.

Para la autenticación de los usuarios se utiliza Passport, mediante el uso de *Bearer token*.
Este token debe incluirse en el Header de cada petición para autorizar el acceso al API.

El valor del header *Authorization* determinará el usuario en en sesión. Este valor se conforma de la siguente forma:
> Authorization: *Bearer {{token_del_usuario}}*

Para el correcto funcionamiento de Passport es necesario inicializar la configuración con el siguente comando:
> php artisan passport:install

### Uso del API
El API deberá ser probada utilizando Postman, por lo que no es necesario el desarrollo de una interfaz para esta prueba.

Al finalizar la prueba deberás adjuntar a este repo la coleccíon de Postman con todos los endpoints mencionados en este readme. Es muy recomendable que el token de Bearer quede definido como variable a nivel colección, para facilitar las pruebas.

