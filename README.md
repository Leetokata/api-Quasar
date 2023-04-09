
## 💻 Instalacion
1.- Configue el archivo .env de laravel

2.- instalar dependencia PHP

```
composer install
```

3.- Generar una Key 

```
php artisan key:generate
```

4.- Ejecutar migraciones

``` 
php artisan migrate
```

5.- Configurar el Path de la API
```
Para esto ir a carpeta QuasarApp/src/boot/axios.js
Debe configurar el archivo axios.js con la ruta la api en su servidor ya que por defecto es "http://127.0.0.1:8000/api"
```

6.- Compilar app de quasar
```
Para esto ir a carpeta QuasarApp
ejevutar quasar build
```
7.- Ya esta lista la aplicacion 🤖





