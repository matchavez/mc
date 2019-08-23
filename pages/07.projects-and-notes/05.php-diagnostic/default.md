---
title: 'PHP Diagnostics'
---

Get the server address:

```php
<?php
    $ip = $_SERVER['SERVER_ADDR'];
    print "IP: ";
    print "$ip<br />\n";
?>
```

Get the PHP version information

```php
<?php
    phpinfo();
?>
```