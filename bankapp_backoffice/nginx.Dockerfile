# nginx.Dockerfile
FROM nginx:alpine

# Elimina el WORKDIR si no lo necesitas, la ruta raíz se define en default.conf
# WORKDIR /var/www

# Copia tu configuración de Nginx al contenedor
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Copia solo la carpeta 'public' de tu proyecto al contenedor Nginx
# Asegúrate de que esta ruta '/var/www/public' coincide con la 'root' en default.conf
COPY public /var/www/public
