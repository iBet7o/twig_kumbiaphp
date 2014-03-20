# Twig en KumbiaPHP

Este repositorio contiene una serie de clases que permiten la integración del sistema de plantillas [Twig](http://twig.sensiolabs.org/) en el framework [KumbiaPHP](http://www.kumbiaphp.com/), con la finalidad de usar las bondades que ofrece dicha libreria.

## Instalación

La instalación se realiza mediante composer, se debe crear o añadir a un archivo composer.json en la raiz del proyecto:

    proyecto
        |
        |--vendor
        |--default
        |--core
        |--composer.json        Acá va nuestro archivo

Con el siguiente código:

```json
{
    "require": {
        "manuelj555/twig-kumbiaphp": "dev-master"
    }
}

```

Luego de eso debemos hacer que nuestra clase **app/View** extienda de **KuTwig_View**:

```php
<?php
/**
 * @see KumbiaView
 */
require_once CORE_PATH . 'kumbia/kumbia_view.php';

/**
 * Esta clase permite extender o modificar la clase ViewBase de Kumbiaphp.
 *
 * @category KumbiaPHP
 * @package View
 */
class View extends KuTwig_View
{

}
```
Por ultimo debemos cargar el autoload de composer, yo lo hago agregando esta linea en el **public/index.php** antes de cargar el **bootstrap.php**

```php
...
//require APP_PATH . 'libs/bootstrap.php'; //bootstrap de app

require dirname(CORE_PATH) . '/vendor/autoload.php';  //acá cargo el autoload de composer :-)

require CORE_PATH . 'kumbia/bootstrap.php'; //bootstrap del core 
```

Y con esto ya tenemos twig funcionando en nuestras vistas :-)


## Funciones Twig Disponibles

### Functiones Generales:

#### css(path)

Agrega una etiqueta **link** al html incluyendo el css especificado en path, la ruta de dicho path debe ser relativa a la carpeta public/css de la aplicación.

Ejemplo:

```html+jinja
<head>
    {# no hace falta escribir la extensión del archivo, ya que la función se la coloca automaticamente #}
    {{ css('style') }}
    {# GENERA: #}
    <link href="/proyecto/css/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
``` 

#### js(path)

Agrega una etiqueta **script** al html incluyendo el js especificado en path, la ruta de dicho path debe ser relativa a la carpeta public/javascript de la aplicación.

Ejemplo:

```html+jinja
{# no hace falta escribir la extensión del archivo, ya que la función se la coloca automaticamente #}
{{ js('jquery') }}
{# GENERA: #}
<script type="text/javascript" src="/proyecto/javascript/jquery.js"></script>
```

#### url(path = false, action = false, params = array())

Devuelve una url que apunta a la ruta especificada, se puede usar de varias maneras:

```html+jinja
{# el uso básico es el siguiente: #}
<a href="{{ url('usuarios') }}">Usuarios</a> {# --> #} <a href="/proyecto/usuarios">Usuarios</a>
<a href="{{ url('admin/estados') }}">Estados</a> {# --> #} <a href="/proyecto/admin/estados">Estados</a>
<a href="{{ url("categorias/editar/#{id}") }}">Cat</a> {# --> #} <a href="/proyecto/categorias/editar/2">Cat</a>
<a href="{{ url(path="user", params=[2]) }}">Show</a> {# --> #} <a href="/proyecto/user/2">Show</a>
<a href="{{ url(params=[2], path="user") }}">Show</a> {# --> #} <a href="/proyecto/user/2">Show</a>

{# Tambien se puede usar solo para cambiar de acción: #}
<a href="{{ url(action="edit", params=[2]) }}">Edit</a> {# --> #} <a href="/proyecto/user/edit/2">Edit</a>
<a href="{{ url(params=[2], action="edit") }}">Edit</a> {# --> #} <a href="/proyecto/user/edit/2">Edit</a>
<a href="{{ url(action="create") }}">Create</a> {# --> #} <a href="/proyecto/admin/estados/create">Create</a>

{# esto gracias a que twig permite llamar a los parametros por nombre #}
```

#### asset(path)

Devuelve una url que apunta un archivo cualquiera en **proyecto/public**

Ejemplo:

```html+jinja
<img src="{{ asset('img/fondo.png') }}" /> {# --> #} <img src="/proyecto/img/fondo.png" />
<a href="{{ asset('img/fondo.png') }}">Download</a> {# --> #} <a href="/proyecto/img/fondo.png">Download</a>
<script type="text/javascript" src="{{ asset('javascript/jquery.js' }}"></script>
```

#### img(src, alt=NULL, attrs = NULL)

Crea una etiqueta img dentro de la aplicación, funciona igual que Html::img($src, $alt=NULL, $attrs = NULL).

Ejemplo:

```html+jinja
{{ img('img/fondo.png') }} {# --> #} <img src="/proyecto/img/fondo.png" />
```

#### link(action, text, attrs = NULL)

Crea una etiqueta **a** dentro de la aplicación, funciona igual que Html::link($action, $text, $attrs = NULL).

Ejemplo:

```html+jinja
{{ link('user/create', 'Create User') }} {# --> #} <a href="/proyecto/user/create">Create User</a>
```

#### link_action(action, text, attrs = NULL)

Crea una etiqueta **a** que apunto a una acción del controlador actual dentro de la aplicación, funciona igual que Html::linkAction($action, $text, $attrs = NULL).

Ejemplo:

```html+jinja
{{ link_action('create', 'Create User') }} {# --> #} <a href="/proyecto/user/create">Create User</a>
```

#### view_content()

Llama a View::content() he incluye los mensajes flash y otras cosas impresas en controladores y librerias.

Uso:

```html+jinja
{{ view_content() }}
```

### Functiones de Formularios:

Para la creación de formularios disponemos de varias funciones Twig:

* **form_*(name, attrs = array(), value = null)**
* **form_label(name, text, attrs = array())**
* **form_textarea(name, attrs = array(), value = null)**
* **form_check(name, value, attrs = array(), check = false)**
* **form_radio(name, value, attrs = array(), check = false)**
* **form_select(name, array options, attrs = array(), value = null)**
* **form_choice(name, array options, multiple = true, attrs = array(), value = null)**
* **form_options(array options, column, key = 'id')**

Estás funciones permiten crear de manera simple los elementos comunes presentes en cualquier formulario html.

#### Creando un Formulario

Veamos con un ejemplo como crear un formulario con tres campos, nombres, apellidos y edad:

```html+jinja
{{ form_label('persona.nombres', 'Nombres') }}
{{ form_text('persona.nombres') }} {# llama a la funcion form_* #}

{{ form_label('persona.apellidos', 'Apellidos') }}
{{ form_text('persona.apellidos') }}

{{ form_label('persona.edad', 'Edad') }}
{{ form_number('persona.edad', {min:1, max: 110}, 18) }} {# por defecto muestra 18 en la edad #}
```

#### form_*(field, attrs = {}, value = null)

Permite crear campos de tipo text, hidden, password, number, email, url, color, etc...

Los atributos que acepta son:

* **field**: nombre del input (genera name y id, convierte los puntos para el name en notación de array y para el id los separa con _).
* **attrs**: un arreglo twig con los atributos para el input (class, style, required, disabled, ...)
* **value**: valor inicial para el elemento, por defecto null.

```html+jinja
{{ form_text('persona.nombres') }}    
<!-- <input type="text" name="persona[nombres]" id="persona_nombres" /> -->

{{ form_text('direccion') }}    
<!-- <input type="text" name="direccion" id="direccion" /> -->

{{ form_number('edad') }}    
<!-- <input type="number" name="edad" id="edad" /> -->

{{ form_color('user.color') }}    
<!-- <input type="color" name="user[color]" id="user_color" /> -->

{{ form_url('user.website', attrs={maxlength:120}) }}    
<!-- <input type="url" name="user[website]" id="user_website" /> -->

{{ form_email('user.correo') }}    
<!-- <input type="email" name="user[correo]" id="user_correo" /> -->
    
{{ form_password('clave') }}    
<!-- <input type="password" name="clave" id="clave" /> -->
    
{{ form_hidden('id', value="23") }}    
<!-- <input type="hidden" name="id" id="id" value="23" /> -->
    
{{ form_hidden('persona.id') }}
<!-- <input type="hidden" name="persona[id]" id="persona_id" /> -->
```

#### form_label(field, text, attrs = {})

Permite crear etiquetas label para los campos

Los atributos que acepta son:

* **field**: nombre del input (genera atributo for, convierte los puntos en _).
* **text:** texto a mostrar en el label.
* **attrs**: un arreglo twig con los atributos para el input (class, style, ...)

```html+jinja
{{ form_label('persona.nombres', 'Nombres') }}    
<!-- <label for="persona_nombres">Nombres</label> -->

{{ form_label('nombres', 'Nombres') }}    
<!-- <label for="nombres">Nombres</label> -->

{{ form_label('u.edad', 'Edad del Infante', {class:'form-label'}) }}    
<!-- <label for="u_edad" class="form-label">Edad del Infante</label> -->
```    

#### form_textarea(field, attrs = {}, value = null)

Permite crear campos textarea

Los atributos que acepta son:

* **field**: nombre del input (genera name y id, convierte los puntos para el name en notación de array y para el id los separa con _).
* **attrs**: un arreglo twig con los atributos para el input (class, style, required, disabled, ...)
* **value**: valor inicial para el elemento, por defecto null.

```html+jinja
{{ form_textarea('persona.nombres') }}    
<!-- <textarea name="persona[nombres]" id="persona_nombres"></textarea> -->

{{ form_textarea('direccion', value = objeto.campo) }}    
<!-- <textarea name="direccion" id="direccion" >valor del campo</textarea> -->
```
    
#### form_radio(field, value = null, attrs = {}, check = false)

Permite crear campos de tipo radio

Los atributos que acepta son:

* **field**: nombre del input (genera name y id, convierte los puntos para el name en notación de array y para el id los separa con _).
* **value**: valor para el radio
* **attrs**: un arreglo twig con los atributos para el input (class, style, required, disabled, ...)
* **check**: indica si el campo aparecerá seleccionado o no.

```html+jinja
{{ form_radio('persona.adulto', 1, check = true) }}    
<!-- <input type="radio" name="persona[adulto]" id="persona_adulto" value="1" checked="checked" /> -->

{{ form_radio('acepta_terminos', 'Si') }}    
<!-- <input type="radio" name="direccion" id="direccion" value="Si" /> -->

{{ form_radio('acepta_terminos', 'No') }}    
<!-- <input type="radio" name="direccion" id="direccion" value="No" /> -->
```
    
#### form_checkbox(field, value = null, attrs = {}, check = false)

Cumple exactamente la misma función que form_radio, solo que genera inputs de tipo checkbox

#### form_select(field, options = {}, attrs = {}, value = null, empty = '- Seleccione -')

Permite crear campos de tipo select

Los atributos que acepta son:

* **field:** nombre del input (genera name y id, convierte los puntos para el name en notación de array y para el id los separa con _).
* **options:** arreglo con pares clave valor, donde la clave será el value de las opcionesy el valor el Texto a mostrar en las mismas.
* **attrs:** un arreglo twig con los atributos para el input (class, style, required, disabled, ...)
* **value:** valor inicial para el elemento, por defecto null.
* **empty:** texto a mostrar inicialmente, por defecto es - Seleccione -

```html+jinja
{% set sexos = { 1 : 'Hombre' , 2 : 'Mujer' } %}

{{ form_select('persona.sexo', sexos) }}    
<!-- <select name="persona[sexo]" id="persona_sexo">
        <option>- Seleccione -</option>
        <option value="1" >Hombre</option>
        <option value="2" >Mujer</option>
     </select> -->

{{ form_select('sexo', sexos, value=2) }}    
<!-- <select name="sexo" id="sexo">
        <option>- Seleccione -</option>
        <option value="1" >Hombre</option>
        <option value="2" selected="selected" >Mujer</option>
     </select> -->
```
         
Ahora lo haremos con un array que viene de un php

```php
<?php

$estatus = array(
    1 => "Activo",
    2 => "Inactivo",
    3 => "Removido",
);

echo $twig->render("form.twig", array('estatus' => $status));
```

En la vista:

```html+jinja
{{ form_select('persona.status', status) }}  

<!-- <select name="persona[status]" id="persona_status">
        <option>- Seleccione -</option>
        <option value="1" >Activo</option>
        <option value="2" >Inactivo</option>
        <option value="3" >Removido</option>
     </select> -->
```
    
#### form_options(options, column, key)

Permite crear un array con pares clave valor a partir de un array multidimensional ó un array de objetos. Es muy util cuando queremos pasar el resultado de una consulta a un select por ejemplo.

Los atributos que acepta son:

* **options:** arreglo de arreglos u objetos que se van a leer.
* **column:** nombre de la columna o atributo del objeto que se usara como el valor del arreglo que se devolverá.
* **key:** nombre de la columna o atributo del objeto que se usara como clave del arreglo que se devolverá (por defecto busca id).
         
Tenemos una matriz y un array de objetos en un php

```php
<?php

$estados = array(
    array('id' => 1, 'estado' => 'Aragua'),
    array('id' => 2, 'estado' => 'Carabobo'),
    array('id' => 3, 'estado' => 'Mérida'),
);

// nuestra clase rol tiene un método publico llamado getNombre() 
// ó un atributo publico $nombre que devuelve el nombre del rol

/**
 * class Rol
 * {
 *    protected $nombre;
 *
 *    protected $id;
 * 
 *    public functon __construct($nombre = null){ $this->nombre = $nombre; }
 *     
 *    public functon getNombre(){ return $this->nombre; }
 *     
 *    public functon getId(){ return $this->id; }
 *
 */

// en el constructor de pasamos el nombre de dicho rol

$roles = array(
    1 => new Rol('admin'),
    2 => new Rol('moderador'),
    3 => new Rol('super admin'),
);

// en la practica los roles pudieran venir de una BD por ejemplo, lo mismo para los estados.

echo $twig->render("form.twig", array(
    'estados' => $estados,
    'roles' => $roles,
));
```

En la vista:

```html+jinja
{% set estados_select = form_options(estados, 'estado') %} 
{# crea un array donde las claves son los valores de la columna id de cada array de la matriz 
   y el valor es el contenido de la columna estado de cada elemento #}
<!-- estados_select es igual a: {1:"Aragua", 2:"Carabobo", 3:"Mérida"}  -->

{% set estados_select = form_options(estados, 'estado', 'id') %}
{# igual al anterior, pero especificando la columna a usar para las keys #}

{{ form_select('persona.estado', estados_select) }} {# le pasamos el nuevo array #}  

{{ form_select('persona.estado', form_options(estados, 'estado')) }}{# llamamos directamente a la función #}  


{{ form_select('persona.rol', form_options(roles, 'nombre')) }}{# llamamos directamente a la función #}  

{{ form_select('user.roles', form_options(roles, 'nombre')),{multiple:true}}}
```
