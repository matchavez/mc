---
title: 'Mac Stuff'
---

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

Compact Sparseimages

```sh
hdiutil compact "Media Store.sparsebundle" -batteryallowed
```

Disable Time Machine Local Snapshots
```sh
sudo tmutil disablelocal
```

