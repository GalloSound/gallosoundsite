# Gallo Sound Site

O site roda no runtime PHP compartilhado de `php/compose.yaml`. O mesmo código
é usado no Mac e na VPS.

Configure a URL pública por meio de `APP_BASE_URL_GALLOSOUNDSITE`. O valor
local padrão é:

`http://localhost:8082/gallosoundsite/`

Hosts listados em `GALLOSOUND_PUBLIC_HOSTS` usam a própria origem na raiz
(`/`). No Mac isso continua em `http://localhost:8082/gallosoundsite/`.

O `Config.php` é versionado e lê essas variáveis diretamente do ambiente do
container.

O formulário envia por SMTP autenticado (`action_email.php`). No container:

```text
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_SECURE=tls
SMTP_USERNAME=admin@gallosound.com.br
SMTP_PASSWORD=<senha de app; nao versionar>
```

O `From` visível é `Gallo Sound <contato@gallosound.com.br>`. A senha não entra no Git.

Para testes e verificações de tags:
<https://tagassistant.google.com/>
