---
title: 'Linux Stuff'
---

### Handy Linux stuff

Updates

```sh
sudo apt-get update        # Fetches the list of available updates
sudo apt-get upgrade       # Strictly upgrades the current packages
sudo apt-get dist-upgrade  # Installs updates (new ones)
```
---

Turn off screensaver permanently

Open /etc/default/grub in your favorite editor; you will need to use sudo (for vi, nano, etc.) or gksudo (for gedit, etc.). 
Then add `consoleblank=0` to the `GRUB_CMDLINE_LINUX_DEFAULT=,`parameter.

---

Within Apache, up the standard PHP upload limit

```sh
$ cd /etc/php/apache2
$ vim php.ini

###### Line 809, upload_max_filesize = 2M, switch to `32M`

:wq
$ service httpd restart
```
---



Disk space
```sh
df -h
```
