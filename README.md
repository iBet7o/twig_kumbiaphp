# Twig en KumbiaPHP

Este repositorio contiene una serie de clases que permiten la integración del sistema de plantillas [Twig](http://twig.sensiolabs.org/) en el framework [KumbiaPHP](http://www.kumbiaphp.com/), con la finalidad de usar las bondades que ofrece dicha libreria.

## Instalación

Para instalar la libreria es necesario descargar este repositorio y colocar su contenido directamente en la carpeta **proyecto/app/libs** de la aplicación, se debe tener cuidado ya que el repositorio contiene un archivo view.php y este va a reemplazar al que viene por defecto con el framework, si usted tiene algún código agregado a dicho archivo, debe realizar una integración manual entre el view.php de su proyecto y el view.php de este repositorio.

Luego de haber copiado los archivos ya se puede comenzar a usar el framework con las vistas en twig, para ello mueva la carpeta views de este repo a la altura de **app**, con el fin de hacer una mezcla entre la carpeta views del framework y la que se va a mover (en la carpeta view proporcionada con el repo, se encuentran algunas vistas twig de ejemplo para comenzar a trabajar con twig).

## Funciones Twig Disponibles

### Functiones Generales:

#### css

#### js

#### url

#### asset

#### img

#### link

#### link_action

#### view_content

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

