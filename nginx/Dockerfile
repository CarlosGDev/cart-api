FROM nginx:stable-alpine

ARG HOME_DIR=/home/symfony
ARG PROJECT_DIR=/home/symfony/docker

COPY default.conf /etc/nginx/conf.d/default.conf

RUN addgroup -g 1000 -S symfony
RUN adduser -u 1000 -h $HOME_DIR  -S symfony -G symfony

RUN mkdir -p $HOME_DIR
RUN mkdir -p $PROJECT_DIR

RUN chown -R symfony:symfony $HOME_DIR
RUN chown -R symfony:symfony $PROJECT_DIR

RUN touch /var/run/nginx.pid \
 && chown -R symfony:symfony /var/run/nginx.pid /var/cache/nginx /var/log/nginx

RUN sed -i 's/user nginx;/#user nginx;/g' /etc/nginx/nginx.conf

WORKDIR $PROJECT_DIR

USER symfony