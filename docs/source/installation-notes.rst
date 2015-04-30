Como instalar Apache
====================

*Ojo, instalación en sistemas Linux, para Windows ver* `como instalar xampp <#todo-en-uno-xampp-windows>`_

Para distribuciones basadas en Debian basta con ejecutar el comando::

$ sudo apt-get install apache2

Para distribuciones basadas en fedora puedes leer `esta guía de instalción. <https://dcala.wordpress.com/2010/02/02/como-instalar-apache2-con-php5-y-sopote-mysql-en-fedora-12-lamp/>`_

Como instalar PHP
=================

En distros basadas en Debian ejecuta el siguiente comando para instalar PHP::

$ sudo apt-get install php5

Para distribuciones basadas en fedora puedes leer `esta guía de instalción. <https://dcala.wordpress.com/2010/02/02/como-instalar-apache2-con-php5-y-sopote-mysql-en-fedora-12-lamp/>`_

Como instalar MySQL
===================

En distros basadas en Debian ejecuta el siguiente comando para instalar el servidor MySql::

$ sudo apt-get install mysql-server

Sería bueno qué támbien instalaras phpmyadmin ya qué es una herramienta muy util a la hora de diseñar bases de datos::

$ sudo apt-get install phpmyadmin

Para distribuciones basadas en fedora puedes leer `esta guía de instalción. <https://dcala.wordpress.com/2010/02/02/como-instalar-apache2-con-php5-y-sopote-mysql-en-fedora-12-lamp/>`_

Todo en uno: XAMPP (Windows)
============================

Con **XAMPP** tendrás *apache*, *php*, *mysql* y más, en una sola instalación, lo primero es descargar el instalador para Windows (Incluso hay para linux y MacOX) lo puedes `descargar desde aquí. <https://www.apachefriends.org/download.html#641>`_

Y es como cualquier otra instalación de Windows, siguiente, siguiente, pero si deseas una guía más extensa visita `este enlace. <https://ajbalmon.wordpress.com/2008/06/25/instalando-xampp-en-windows/>`_

Como activar mod_rewrite
========================

Esto es indispensable para qué bitphp pueda funcionar, primero vamos a hacerlo en linux.

Linux
~~~~~

Desde la consola bastará con introducir el siguiente comando::

$ sudo a2enmod rewrite

A continuación editamos el archivo **/etc/apache2/apache2.conf** y buscamos las líneas **AllowOverride None** y las cambiamos por **AllowOverride All**

Para aplicar los cambios hay qué reiniciar Apache::

$ sudo service apache2 restart

Windows
~~~~~~~

En Windows debemos modificar el archivo **httpd.conf** el cual puede estar en distintas ubicaciones dependiendo de nuestra instalación, en el caso de XAMPP el archivo se encuentra en **C:/xampp/apache/conf/httpd.conf** en este archivo buscamos la linea::

# LoadModule rewrite_module modules/mod_rewrite.so

Y borramos el **#** (simbolo de gato).

Después, en ese mismo archivo buscamos las lineas **AllowOverride None** y las cambiamos por **AllowOverride All**. Reiniciamos el servidor para qué los cambios surtan efecto.