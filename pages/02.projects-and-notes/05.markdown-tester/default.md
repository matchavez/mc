---
title: 'Markdown Tester'
---

! Be aware that this has some rST in it.


# Sphinx (Recommonmark) Usage

These standards are what make up the "CommonMark" library that is used by Sphinx through the ReCommonMark bridge. When installed, it renders .md files in a normal manner alongside native reStructuredText. This allows a document to be generally written with Markdown but also use specific rST code to provide full functionality within documentation.

As noted, this does not include ALL of the GFM (GitHub-flavoured Markdown) additions you may see available within Github. A good example is the task-list checkbox. It will not render in Sphinx in the way that it does on GitHub.com.

Also, rST can be rendered directly using code fence evaluation, as noted below with the Admonition example. This is rST natively rendered from Sphinx. As an important example, while there are ways to do tables in GFM, those do not work. If a table is required, a table can be created using rST eval, but it is important to note that the same rST table will likely not "render" above text in GitHub.


## Comments

<!--This is a comment.-->

Text is above, saying 'This is a comment.' If you do not see the comment, it is not visible, and works correctly. Please be aware that this is not universal, and some apps will show a comment like this as text.


## Headings

Headings from h1 through h6 are constructed with a # for each level:

# h1 Heading
## h2 Heading
### h3 Heading
#### h4 Heading
##### h5 Heading
###### h6 Heading


## Horizontal Rules

```
---  Three consecutive en-dashes
```
---

```
___  Three consecutive underscores
```
___

```
***  Three consecutive asterisks
```
***

All three options make a full hr.


## Body Copy

Bold
**rendered as bold text**

Italics
_rendered as italicised text_

Interior Italics
interior_naming_underscores.txt
(Spaces must surround the emphasis marks, or the assumption is that it is a file name and not intended to be emphasised.)

Blockquotes
> Add a greater-than at the beginning of a line. This is a blockquote.  
> This is more  
> Blockquote  
>
> This is crap



## Lists

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

TIP: If you just use 1. for each number, they will automatically number each item. This allows you to reorder without having to re-number the changes. For example:

1. Lorem ipsum dolor sit amet
1. Consectetur adipiscing elit
1. Integer molestie lorem at massa
1. Facilisis in pretium nisl aliquet


## Code

Single-line code:

`Use single apostrophes for one line.`

Use “code fences” \`\`\` to block in multiple lines of code.

```html
<h5>THis is unrendered code in monospace and a selected language format...</h5>
```

```css
a#logo h1 {
  color: #ff0000;
}

#header {
  background: #000000;
}
```


## Links

Basic link

[Assemble](http://assemble.io)

[Upstage](https://github.com/upstage/ “Visit Upstage!”)

## Anchoring

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


## Images

Images have a similar syntax to links but include a preceding exclamation point.

![Minion](http://octodex.github.com/images/minion.png)


![Alt text](http://octodex.github.com/images/stormtroopocat.jpg 'The Stormtroopocat')
Alt text

Like links, Images also have a footnote style syntax

![Alt text][id]
Alt text

With a reference later in the document defining the URL location:

[id]: http://octodex.github.com/images/dojocat.jpg  "The Dojocat"


## reStructuredText evaluation

```eval_rst
.. DANGER::
   This is evaluated rST! Further explanation later.
```

This is an example of a specific Admonition available within rST. By placing the directive inside a standard code fence, and using eval_rst as the "language", the parser evaluates the code not as preformatted text, but actual rST, thus allowing any true rST to be rendered by Sphinx. This will be code-fenced in any other location, but the advantage is that the monospace fonts will keep the rST looking correctly.

One more example is a table:

```
.. table:: Truth table for "not"
   :widths: auto

   =====  =====
     A    not A
   =====  =====
   False  True
   True   False
   =====  =====
```

```eval_rst
.. table:: Truth table for "not"
   :widths: auto

   =====  =====
     A    not A
   =====  =====
   False  True
   True   False
   =====  =====

```
