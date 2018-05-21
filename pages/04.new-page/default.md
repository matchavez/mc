---
title: 'New Page'
---

## This should be Markdown aware. Accordingly, I'm going to insert the GFM Test...


============

     Typography

That's some text with a footnote.[^1]

[^1]: And that's the footnote.



Headings

Headings from h1 through h6 are constructed with a # for each level:

# h1 Heading
## h2 Heading
### h3 Heading
#### h4 Heading
##### h5 Heading
###### h6 Heading


## Tasks

- [x] Task1
- [x] Task2
- [ ] Task3

—

This
tests
single
line
break

—

Horizontal Rules

```
___: three consecutive underscores
```

___

```
***: three consecutive asterisks
```
***



# Body Copy

Bold
**rendered as bold text**

Italics
_rendered as italicised text_

Strikethrough
~~Strike through this text.~~



Blockquotes

For quoting blocks of content from another source within your document.

Add > before any text you want to quote.

>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. This is a blockquote.




Lists

Unordered

A list of items in which the order of the items does not explicitly matter.

You may use any of the following symbols to denote bullets for each list item:

* valid bullet
- valid bullet
+ valid bullet

Nesting
+ Lorem ipsum dolor sit amet
+ Consectetur adipiscing elit
+ Integer molestie lorem at massa
+ Facilisis in pretium nisl aliquet
+ Nulla volutpat aliquam velit
  - Phasellus iaculis neque
  - Purus sodales ultricies
  - Vestibulum laoreet porttitor sem
  - Ac tristique libero volutpat at
+ Faucibus porta lacus fringilla vel
+ Aenean sit amet erat nunc
+ Eget porttitor lorem


Ordered

A list of items in which the order of items does explicitly matter.

1. Lorem ipsum dolor sit amet
2. Consectetur adipiscing elit
3. Integer molestie lorem at massa
4. Facilisis in pretium nisl aliquet
5. Nulla volutpat aliquam velit
6. Faucibus porta lacus fringilla vel
7. Aenean sit amet erat nunc
8. Eget porttitor lorem


TIP: If you just use 1. for each number, GitHub will automatically number each item. For example:

1. Lorem ipsum dolor sit amet
2. Consectetur adipiscing elit
3. Integer molestie lorem at massa
4. Facilisis in pretium nisl aliquet
5. Nulla volutpat aliquam velit
6. Faucibus porta lacus fringilla vel
7. Aenean sit amet erat nunc
8. Eget porttitor lorem


Code

Use “fences” \`\`\` to block in multiple lines of code.

```html
<h5>Sample text here...</h5>
```


``` javascript
<h5>Sample text here...</h5>
grunt.initConfig({
  assemble: {
    options: {
      assets: ‘docs/assets’,
      data: ‘src/data/*.{json,yml}’,
      helpers: ‘src/custom-helpers.js’,
      partials: [‘src/partials/**/*.{hbs,md}’]
    },
    pages: {
      options: {
        layout: ‘default.hbs’
      },
      files: {
        ‘./‘: [‘src/templates/pages/index.hbs’]
      }
    }
  }
};
```
\``

### Tables

Tables are created by adding pipes as dividers between each cell, and by adding a line of dashes (also separated by bars) beneath the header. Note that the pipes do not need to be vertically aligned.

| Option | Description                              |
| ------ | ---------------------------------------- |
| data   | path to data files to supply the data that will be passed into templates. |
| engine | engine to be used for processing templates. Handlebars is the default. |
| ext    | extension to be used for dest files.     |



Right aligned text

Adding a colon on the right side of the dashes below any heading will right align text for that column.

| Option |                              Description |
| -----: | ---------------------------------------: |
|   data | path to data files to supply the data that will be passed into templates. |
| engine | engine to be used for processing templates. Handlebars is the default. |
|    ext |     extension to be used for dest files. |




Links

Basic link

[Assemble](http://assemble.io)

[Upstage](https://github.com/upstage/ “Visit Upstage!”)


Named anchors enable you to jump to the specified anchor point on the same page. For example, each of these chapters:

# Table of Contents
  * [Chapter 1](#chapter-1)
  * [Chapter 2](#chapter-2)
  * [Chapter 3](#chapter-3)
      will jump to these sections:

## Chapter 1 <a id=“chapter-1”></a>
Content for chapter one.

## Chapter 2 <a id=“chapter-2”></a>
Content for chapter one.

## Chapter 3 <a id=“chapter-3”></a>
Content for chapter one.
NOTE that specific placement of the anchor tag seems to be arbitrary. They are placed inline here since it seems to be unobtrusive, and it works.




Images

Images have a similar syntax to links but include a preceding exclamation point.

![Minion](http://octodex.github.com/images/minion.png)


![Alt text](http://octodex.github.com/images/stormtroopocat.jpg 'The Stormtroopocat')
Alt text

Like links, Images also have a footnote style syntax

![Alt text][id]
Alt text

With a reference later in the document defining the URL location:

[id]: http://octodex.github.com/images/dojocat.jpg  "The Dojocat"
