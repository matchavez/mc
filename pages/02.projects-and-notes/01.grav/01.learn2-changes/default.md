---
title: 'Learn2 Changes'
---

These are the changes I made to go from the "stock" version of Learn2 to the way it looks today.

Change `languages.yaml` so that the appropriate wording is shown in search boxes. Use `" "` for a literal space, as null will break.

1. In `user/themes/learn2/templates/partials/logo.html.twig`, you'll need to comment out or remove the text that exists. Be aware that this is a vector-based SVG file, and **_not an image_** to be swapped out. Comments in twig are done with `{# thisisallcommentedout #}`  or you can remove ALL of the text without harm. In the example, you may want to put in something like `<h5>MatChavez.com</h5>` to insert some text.
2. Create a new file called `user/themes/learn2/css/custom.css` and add the following to it:

```
a#logo h5 {
  color: #ff0000;
}

#header {
  background: #000000;
}
```

- Code highlighting plug-in turned on, using Solarized Dark.
