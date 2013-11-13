# Twig en KumbiaPHP

Este repositorio contiene una serie de clases que permiten la integración del sistema de plantillas [Twig](http://twig.sensiolabs.org/) en el framework [KumbiaPHP](http://www.kumbiaphp.com/), con la finalidad de usar las bondades que ofrece dicha libreria.

## Instalación

Para instalar la libreria es necesario descargar este repositorio y colocar su contenido directamente en la carpeta **proyecto/app/libs** de la aplicación, se debe tener cuidado ya que el repositorio contiene un archivo view.php y este va a reemplazar al que viene por defecto con el framework, si usted tiene algún código agregado a dicho archivo, debe realizar una integración manual entre el view.php de su proyecto y el view.php de este repositorio.

Luego de haber copiado los archivos ya se puede comenzar a usar el framework con las vistas en twig, para ello mueva la carpeta views de este repo a la altura de **app**, con el fin de hacer una mezcla entre la carpeta views del framework y la que se va a mover (en la carpeta view proporcionada con el repo, se encuentran algunas vistas twig de ejemplo para comenzar a trabajar con twig).

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

#### asset

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

#### link_action

Crea una etiqueta **a** que apunto a una acción del controlador actual dentro de la aplicación, funciona igual que Html::linkAction($action, $text, $attrs = NULL).

Ejemplo:

```html+jinja
{{ link_action('create', 'Create User') }} {# --> #} <a href="/proyecto/user/create">Create User</a>
```

#### view_content

Llama a View::content() he incluye los mensajes flash y otras cosas impresas en controladores y librerias.

Uso:

```html+jinja
{{ view_content() }}
```

### Functiones de Formularios:

#### form_open

#### form_close

#### form_label

#### form_textarea

#### form_check

#### form_radio

#### form_select

#### form_choice

#### form_options

