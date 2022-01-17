# Microservice management

This project is inspired by Eureka-server from Netflix.
It will monitor microservices list/health and provide it to gateway-service.

## Details

1. Microservices can be registered
2. User can monitor registered microservices health
3. Gateway service can get a list of registered services
4. Security/Whitelist(url)

## Purpose

- Keep microservices healthy.
- Optimise application's performance(find performance bottleneck)

## Technologies

- Lumen framework
- Radis for Cache
