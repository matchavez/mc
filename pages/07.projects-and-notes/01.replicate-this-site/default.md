---
title: 'Replicate This Site'
---

I got tired of social media grabbing things and letting them disappear off their timelines. I wanted to remember things, and even if they got a little dusty, they weren't dropped off or given away. So here's how I made it. 

---

## Software

### Web Server Software - Aprelium Abyss
I wanted a good web server for Mac. I decided that it needed to run multiple domains and have a simple UI. Abyss is excellent, and if it's just a single domain, it's _free_. It gets no better than that. Nothing wrong with using Apache, Nginx, or whatever you want. The problem is that I wanted to run it as an app on a Mac, without VM-ing it.

### Web Content Management - Grav
Grav is an excellent CMS. It's growing leaps and bounds, but my critical choice was that it handles GFM Markdown properly. This means I can use code fences and they get coloured properly, and the exact text that I use or take notes with will "round-trip" without converting it. I'll never be scared of removing the content later, or extracting it for another application.

Grav's documentation theme Learn2 is currently the modified theme. Using that, and syncing it with Github, and I have the ability to change and copy and backup all the time. I don't worry about backing up the site over and over because it does it for you. Give it a shot.

---

## Hardware

You probably know that hardware doesn't matter much. Personally, I have a 2012 Mac Mini running this page. It could just as easily be a Raspberry Pi doing it, which may be an upcoming project. The Mini is hard-wired into an Airport Extreme, and routed off of my DSLR router from a Static IP.

If you plan on hosting yourself, off your own internet connection, please be aware of a few things:

- Is your port available? Specifically, if you hit port 80 and 443, does the router force you to itself? Some cheap routers reserve port 80 for its own use, making it impossible to serve http. In those situations, you could potentially serve 100% https, but be aware of what you own.
- Is your connection available most of the time? Make sure you're not dealing with outages. Otherwise, grab a cloud provider.
- Be prepared to make some individual setting choices to get Port 80 to route to a single internal IP address. This could be a virtual machine even, but that's not ideal. Make sure the machine you use is on a set internal IP, so it does not get reassigned on reboot.

If you can get this done, you can save yourself a few hundred dollars a year in hosting costs and headaches.