# How to Use

   Open ```/updater.php?action=update-form&psw=CHANGE_IT``` and upload a new ZIP archive.

   Alternatively, you can send the update as a POST request with the following parameters:

   - action='update'

  - psw (your secret password)

  - update_file (the ZIP archive containing the **new server root data**)

# Warning

This tool will clear the server root

# Update via curl

```
curl -X POST https://somesite.com/updater.php \
  -F "psw=CHANGE_IT" \
  -F "action=update" \
  -F "file=@updates.zip"
```

# Update using PHP

Sending from the current host to the other host some updates, the destination is localhost:9999

```
<?php
require_once(__DIR__ . "/updatelib.php");

echo "Sender";

try {
    $response = \Nzv\sendUpdates('http://localhost:9999/updater.php', 'CHANGE_IT', __DIR__ . '/updates.zip');
    echo "Ответ сервера: $response";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
```

# Get Swagger OpenAPI specifications

Open ```http://yourhost.com/updater.php?action=openapi```
