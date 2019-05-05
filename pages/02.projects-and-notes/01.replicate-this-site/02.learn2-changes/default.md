---
title: 'Learn2 Changes'
---

These are the changes I made to go from the "stock" version of Learn2 to the way it looks today.

Change `languages.yaml` so that the appropriate wording is shown in search boxes. Use `" "` for a literal space, as null will break.

1. In `user/themes/learn2/templates/partials/logo.html.twig`, you'll need to comment out or remove the text that exists. Be aware that this is a vector-based SVG file, and **_not an image_** to be swapped out. Comments in twig are done with `{# thisisallcommentedout #}`  or you can remove ALL of the text without harm. In the example, you may want to put in something like `<h2>MatChavez.com</h2>` to insert some text.
2. Create a new file called `user/themes/learn2/css/custom.css` and add the following to it:

```
a#logo h2 {
  color: #ff0000;
}

#header {
  background: #000000;
}
```
The colous here are just a starter; there's no need to select them. You can always see my latest custom.css to see what I've used for a colour palette.


Also, go into `languages.yaml`, and you can change the strings for several areas. For example, in `THEME_LEARN2_SEARCH_DOCUMENTATION: " "` making this a literal space makes the search text not have a silly default.

- Code highlighting plug-in turned on, using Solarized Dark.

In order to relax the clipboard link obnoxious colouration, go into `images/clippy.svg` and change the svg by adding a colour indicator for the trace:

`<path style="fill:#38424d;" d="M128 768 …`

And add to custom.css:

```css
.copy-to-clipboard {
	background-color: #000;
	
}
```
!!! The colour values presented will likely not be the same as those currently in use.
