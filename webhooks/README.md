### установка докера

смотри ссылку https://docs.docker.com/engine/install/ubuntu/#install-using-the-convenience-script
```shell
$ curl -fsSL https://get.docker.com -o get-docker.sh
$ sudo sh get-docker.sh
```

### установка контейнера php
см ссылку https://hub.docker.com/r/trafex/php-nginx

```shell
$ docker run -d -p 80:8080 -p 443:8080 -v ~/code:/var/www/html trafex/php-nginx
```

### права для логирования
добавить права в папке code чтобы писать логи `chmod 777 code`

### проверка
#### webhook handshake
```shell
$ curl -v 81.200.153.212/webhook -H "X-Hook-secret: asldkasldk"
curl -v  https://margo-ceramica.ru/receive-webhook -H "X-Hook-secret: asldkasldk"
```
ответ
```shell
*   Trying 81.200.153.212:80...
* Connected to 81.200.153.212 (81.200.153.212) port 80 (#0)
> GET /webhook HTTP/1.1
> Host: 81.200.153.212
> User-Agent: curl/7.77.0
> Accept: */*
> X-Hook-secret: asldkasldk
>
* Mark bundle as not supporting multiuse
< HTTP/1.1 204 No Content
< Server: nginx
< Date: Sun, 05 Mar 2023 13:48:22 GMT
< Content-Type: text/html; charset=UTF-8
< Connection: keep-alive
< X-Hook-secret:
<
* Connection #0 to host 81.200.153.212 left intact
```

#### отправка события
```shell
$ curl -v -H "Content-Type: application/json" -H "X-Hook-signature: asldkasldk" -d '{"events":[{"object_id": "1"}]}' 81.200.153.212/webhook
```

ответ
```shell
*   Trying 81.200.153.212:80...
* Connected to 81.200.153.212 (81.200.153.212) port 80 (#0)
> POST /webhook HTTP/1.1
> Host: 81.200.153.212
> User-Agent: curl/7.77.0
> Accept: */*
> Content-Type: application/json
> X-Hook-signature: asldkasldk
> Content-Length: 31
>
* Mark bundle as not supporting multiuse
< HTTP/1.1 200 OK
< Server: nginx
< Date: Sun, 05 Mar 2023 14:16:53 GMT
< Content-Type: text/html; charset=UTF-8
< Transfer-Encoding: chunked
< Connection: keep-alive
< Vary: Accept-Encoding
<
* Connection #0 to host 81.200.153.212 left intact
```


## добавление хуков в асане
ссылка на доку апи https://developers.asana.com/reference/getwebhooks
### чекаем что работает апишка
```shell
$ curl https://app.asana.com/api/1.0/users/me -H "Authorization: Bearer 1/1204083771077723:1f02e4f525e458c1487944188030d53d"
```

### существующие хуки
```shell
$ curl -X GET https://app.asana.com/api/1.0/webhooks?workspace=1204083862532119 -H "Authorization: Bearer 1/1204083771077723:1f02e4f525e458c1487944188030d53d"
```

если ничего нет
```json
{
  "data": [
    {
      "gid": "1204113343979214",
      "active": true,
      "resource": {
        "gid": "1204083925631698",
        "name": "Project plan",
        "resource_type": "project"
      },
      "resource_type": "webhook",
      "target": "https://margo-ceramica.ru/receive-webhook"
    }
  ]
}
```


### добавляем хук
```shell
curl --request POST \
     --url https://app.asana.com/api/1.0/webhooks \
     --header 'accept: application/json' \
     --header 'authorization: Bearer 1/1204083771077723:1f02e4f525e458c1487944188030d53d' \
     --header 'content-type: application/json' \
     --data '
{
     "data": {
          "resource": "1204083925631698",
          "target": "https://margo-ceramica.ru/receive-webhook"
     }
}
'
```