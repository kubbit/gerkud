#! /bin/sh

GERKUD_BASE=`pwd`
GERKUD_DB=gerkud
GERKUD_USER=gerkud
GERKUD_PWD=gerkud

GERKUD_HERRIA=errenteria

cd $GERKUD_BASE

# crear estructura de base de datos
php symfony doctrine:build --all --and-load --no-confirmation

# cargar datos de tablas externas
cat sql/*.sql | mysql -u $GERKUD_USER --password=$GERKUD_PWD $GERKUD_DB
cat sql/$GERKUD_HERRIA/*.sql | mysql -u $GERKUD_USER --password=$GERKUD_PWD $GERKUD_DB

# copiar logotipos especificos del municipio al area general
cp -a web/images/$GERKUD_HERRIA/* web/images/

# Crear directorios necesarios si no existen
if [ ! -d cache ]; then
	mkdir -p cache
fi
if [ ! -d log ]; then
	mkdir -p log
fi
if [ ! -d web/uploads/FILES ]; then
	mkdir -p web/uploads/FILES
fi

# Permisos para usuario www
chmod 1777 cache log web/uploads/FILES 
