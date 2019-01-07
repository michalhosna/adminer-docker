# Docker Adminer with env login

[Adminer](https://www.adminer.org) docker image with extended env variables for autologin.

Docker hub: http://hub.docker.com/r/michalhosna/adminer

## Exapmle:
```yaml
version: '2.4'

services:
    adminer:
        image: michalhosna/adminer:master
        ports:
            - 8080:8080
        volumes:
          - ./4/index.php:/var/adminer/index.php
        environment:
            ADMINER_DB: adminer
            ADMINER_DRIVER: pgsql
            ADMINER_PASSWORD: adminer
            ADMINER_SERVER: postgres
            ADMINER_USERNAME: adminer
            ADMINER_AUTOLOGIN: 1
            ADMINER_NAME: This will be in the title!


    postgres:
        image: postgres:10-alpine
        restart: on-failure
        environment:
            POSTGRES_DB: adminer
            POSTGRES_USER: adminer
            POSTGRES_PASSWORD: adminer


```

## Tags
The builds are always build without changing the build-args

- The stable: `master` - always master of the repo, prefered to use, it should be to most up-to-date and stable
- Locke commit, like `8dc4d2b8b484ed08d041066fadc6a832ef57a1f6` or similar 
- Adminer version, like `4.7.0` 
- Adminer version + commit `4.7.0-8dc4d2b`, the same as commit hash, only with better readability of version

No latest tag, if it shows up in the docker hub i fucked up (it's to easy), and you cannot completely delete tag from docker hub, you shouldn't use it.

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
