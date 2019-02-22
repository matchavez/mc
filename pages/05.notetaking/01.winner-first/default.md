---
title: 'Winner First'
---

I hate reviews that make you click through a bunch of options before getting to the point. So please allow me to tell you here what I think the best system is.

## Winner - No Single Application

What? Nothing? No, not nothing. It's a **combination** of apps that make up a very helpful system.

- Dropbox
- Markdown; specifically GFM
- Typora
- 1Writer

These 4 things work together to offer what I'm looking for, both with capabilities and without lockin. Here's how it works:

### Dropbox
You're probably familiar with Dropbox as it's everywhere. 10GB free for anyone is outstanding, but it has an additional appeal of working in areas where you might not expect. Dropbox can be installed in corporate environments, usually, _without administrative privileges!_ This means that you probably don't have to ask... you just install it. Don't go breaking any rules at work, but when you download Dropbox and you're not an admin, it'll ask if you want to install on Windows without admin. You say yes, and then it installs a "reduced" version. It seems to use some more old-school sync methods, but it still works. This means you can have a folder on Mac, Linux, and even Windows! Android and iOS are also just as available, so you're working directly with files, and Dropbox does the sync.

##### Runner-Up - iCloud
A more secure service, but limiting with Linux and Android.

### Markdown (GitHub-Flavoured Markdown, specifically)
Why is a format part of the solution? John Gruber's original approach, and the one adopted and transformed into what's known as "GFM", is a way to write _plain text_ that is formatted. This means hashtags for headings and asterisks for bolding. It is completely readable as-is. It's not as pretty, but it is obvious when you read a completely plain text file that what you put underscores around is intended to be emphasised. It's a little like "shorthand html", but instead of writing `<h1>Heading</h1>` and surrounding all your text with HTML, you just write `# Heading`. This means that not only do you not _export_ your files, you simply work with the _raw file_ as it is. Using certain smart applications will apply those formats, and that lets you keep your original in an "application-agnostic" format.

### Typora
Typora is my main writing app on the desktop. It does one trick that no other app (as of yet) does, and it's amazing. Unlike other apps that have a "preview mode", or some that do side-by-side rendering, Typora formats GFM in real-time. This means as soon as you complete a formatting step, it's going to put it on screen within the rest of your writing. Personally, this makes writing in Markdown **much, much easier** mentally. Instead of switching into a mode to see how things witll work, you see it immediately.

### 1Writer
For iOS, 1Writer is excellent. As a mobile editor goes, it is far and away the easiest and cleanest. Easy Markdown previewing, uses GFM, code pigmentation, and auto-naming.

---

Using these 4 keys in combination, it allows you to do all those tricks, plus a few more that I mentioned before:

##### Code Fencing:

If you use any type of code, or want to call out certain text clearly and in a monospaced font, Markdown allows for a "code fence". Start and end with three backticks. It's the ~ key without the shift,  and you get a fully different experience.

```sh
$ This is fenced code.
```
If you write anything this way, you'll understand exactly why you need it. Try it out.

##### To-do checks

Part of the GFM upgrade for Markdown is that it allows checkboxes:

- [x] Easy!

##### Easy Transfer

The ease at which content can transfer is also very helpful. Whether it's notes, or in GitHub or Azure DevOps (Fire whoever named it that), or in a system like this website using Grav, Markdown content can be transferred in and out with all of its formatting fully intact. 

---

Hopefully this helps, and lets you avoid note lock-in!