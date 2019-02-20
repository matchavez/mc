---
title: 'Mac Stuff'
---

### Handy Mac commands:

Show Hidden Files

```sh
$ defaults write com.apple.finder AppleShowAllFiles True
$ killall Finder
```

DNS Cache Clear

```sh
sudo dscacheutil -flushcache
```

Turn off Prefetch Cache

```sh
defaults write com.apple.safari WebKitDNSPrefetchingEnabled -boolean false
```

Compact Sparseimages (example where "Media Store" is the name of the image)

```sh
hdiutil compact "Media Store.sparsebundle" -batteryallowed
```

Disable Time Machine Local Snapshots (Prevents a Mac's hard drive from filling up to 80% on just backups)
```sh
sudo tmutil disablelocal
```

