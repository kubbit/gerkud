# Gerkud
[Gerkud][1] (Gertakarien Kudeaketa - Gestión de Incidencias) es un sistema de gestión de tareas de uso interno para los ayuntamientos. Permite llevar un seguimiento de todas las peticiones que se hacen en el ayuntamiento (tanto internas como externas) y encaminarlas hasta su resolución final: clasificarlas y asignarlas al departamento responsable en cada caso, registrar anotaciones, adjuntar ficheros, recibir notificaciones de cambios de estado, sacar informes, etc.

Inicialmente fue desarrollado para gestionar de forma interna todas las tareas  del departamento de mantenimiento urbano de un ayuntamiento. Por ello dispone de un módulo para poder visualizar en un mapa cada una de las incidencias introducidas en el sistema, tanto por codificación de la calle como por coordenadas establecidas de forma manual.

# Idiomas
Se encuentra disponible en dos idiomas:
- Euskera
- Castellano

# Tecnologías usadas
La aplicación hace uso de las siguientes tecnologías:
- `PHP`
- `Symfony 1.5`
- `MySQL`
- `XHTML 5`
- `JavaScript`
- `CSS3`
- `Google Maps`

Se adapta a cualquier tipo de pantalla usando `diseños adaptativos`, lo que permite su uso a través de dispositivos móviles.

## Conexión con otras aplicaciones
Actualmente se integra completamente con [HorKonpon][2], aplicación para dispositivos móviles que permite a los ciudadanos notificar problemas o sugerencias a los ayuntamientos.

HorKonpon también es software libre y el código está disponible en GitHub ([Android][3] e [iOS][4]).

## Autoría
Gerkud fue inicialmente desarrollado por el [Ayuntamiento de Pasaia][5] para uso interno de su departamento de mantenimiento urbano.

Posteriormente la empresa [Kubbit][6] se hizo cargo del proyecto para su adaptación al [Ayuntamiento de Errenteria][7], y es quien a día de hoy lidera el desarrollo y mantenimiento de la aplicación.


## Licencia
La aplicación ha sido publicada bajo la Licencia Pública General de GNU en su versión 2 (GPLv2).

[1]: https://gerkud.kubbit.com
[2]: https://kubbit.com/horkonpon/
[3]: https://github.com/kubbit/horkonpon.android
[4]: https://github.com/kubbit/horkonpon.ios
[5]: http://www.pasaia.eus
[6]: https://kubbit.com
[7]: http://www.errenteria.eus
