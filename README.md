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
