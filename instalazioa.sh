#! /bin/sh

GERKUD_BASE=`pwd`
GERKUD_DB=prueba
GERKUD_USER=gerkud
GERKUD_PWD=gerkud

cd $GERKUD_BASE
php symfony doctrine:build --all --and-load --no-confirmation

cat sql/errenteria/*.sql | mysql -u $GERKUD_USER --password=$GERKUD_PWD $GERKUD_DB
cat sql/*.sql | mysql -u $GERKUD_USER --password=$GERKUD_PWD $GERKUD_DB
