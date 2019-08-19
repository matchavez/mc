---
title: 'Add a Style Sheet'
---

## Instructions for adding a Style Sheet / CSS / LESS

This is an optional step, as most of them are. The task here is to turn your (combined) markdown document into something readable and "brandable" on screen (HTML) or on "paper" (PDF). This is accomplished by the interpretive step of a "Preview" by the appropriately named "Markdown Preview Enhanced", and then exporting from that same preview.

To start with, MPE does follow a solid option of using the same styling as Github, and for good reason. It's clean and very readable. However, it's very likely that you have a specific style you want to achieve. In fact, you or your company, or your website, might already have a CSS that you want to use. If so, great! This is where you put it. 

In the file `~/.mume/style.less` you will see the code here tells you that you can put in your own CSS (or LESS if you desire). Just make sure that you put the CSS contents in at line 5, and that's within the _first_ `head body {}` style. It's just how the plugin works. As an incomplete example, take a look at this:

```css

html body {
  // DO NOT REMOVE this opening tag. It is required to work for Atom.

  html, body {
    text-rendering:geometricPrecision;
  }

  p {
    margin: 1em 0;
    font-size: 0.8125em;
  }

  a {
    color: #001E82;
    background-color: #ECF7FE;
    text-decoration: none;
  }

  h1, h2, h3, h4, h5, h6 {
    font-weight: 100;
    line-height: 1.0;
    cursor: text;
    position: relative;
    margin: 1em 0 15px;
    padding: 0;
```

Some things to be aware of...

- The plugin, as currently designed, can only point to `style.less`. If you want to change it, you must work within that file, or...
- Duplicating `style.less` to something like `style_sample.less` will allow you to save it within the directory.
- If there is no `style.less` when the plugin starts, it will rewrite a new one, based again on the GitHub style.
- It's a `.less` file, but any Cascading Style Sheet code will work within that first-line style.

Now, let's [export](../exporting-to-pdf-or-html).