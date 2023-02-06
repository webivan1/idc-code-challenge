FROM nginx:latest

WORKDIR /app

COPY ./conf /etc/nginx/conf.d

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
