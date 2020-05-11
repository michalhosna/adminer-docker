# Docker Adminer with env login

[Adminer](https://www.adminer.org) docker image with extended env variables for autologin.

Docker hub: http://hub.docker.com/r/michalhosna/adminer

## Exapmle:
```yaml
version: '2.4'

services:
    adminer:
        image: michalhosna/adminer
        ports:
            - 8080:8080
        environment:
            ADMINER_DB: adminer
            ADMINER_DRIVER: pgsql
            ADMINER_PASSWORD: adminer
            ADMINER_SERVER: postgres
            ADMINER_USERNAME: adminer
            ADMINER_AUTOLOGIN: 1
            ADMINER_NAME: This will be in the title!


    postgres:
        image: postgres:11-alpine
        restart: on-failure
        environment:
            POSTGRES_DB: adminer
            POSTGRES_USER: adminer
            POSTGRES_PASSWORD: adminer


```

## Tags

```
michalhosna/adminer:4.7.7-en_v1
```

- `4.7.7` = Adminer version
- `en` = Adminer flavour (as in https://github.com/vrana/adminer/releases)
- `v1` = Image version, when something else than adminer version in this repository changes 

## Guide
You can preffil any/all/none of the environment variables. 
If you prefill all environment variables including `ADMINER_AUTOLOGIN`, user will be autologed and won't see the login screen at all.
If you prefill only some variables, user will be presented with form with prefiled (and disabled) fields from env vars.

## Environment Variables

### `ADMINER_DB, ADMINER_PASSWORD, ADMINER_SERVER, ADMINER_USERNAME`
I hope those speak for themselves

### `ADMINER_DRIVER`
Value from driver select

Current possible values are:
- `sqlite`
- `sqlite2`
- `pgsql`
- `oracle`
- `mssql`
- `firebird`
- `simpledb`
- `mongo`
- `elastic`
- `clickhouse`

(This image was not tested with all of them)

### `ADMINER_AUTOLOGIN`
If this variable exists (even if it's empty), adminer will try to autologin, no matter if all fields are filled

### `ADMINER_NAME`
This value will be in the title and heading.
