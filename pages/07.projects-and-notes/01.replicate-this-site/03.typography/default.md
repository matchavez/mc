---
title: Typography
---

!!! Most of the changes in typographical theming are taken from a modified theme of Typora. The Typora .css is available at [my GitHub](https://github.com/matchavez/TyporaThemes/). If you're looking for the current theme, the site [custom.css](https://github.com/matchavez/mc/blob/master/themes/learn2/css/custom.css) can also be found there.

---

### Headings


# H1 Heading `40px`

## H2 Heading `32px`

### H3 Heading `28px`

#### H4 Heading `24px`

##### H5 Heading `20px`

###### H6 Heading `16px`

---

### Paragraphs

Lorem ipsum dolor sit amet, consectetur [adipiscing elit. Praesent risus leo, dictum in vehicula sit amet](#), feugiat tempus tellus. Duis quis sodales risus. Etiam euismod ornare consequat.

Climb leg rub face on everything give attitude nap all day for under the bed. Chase mice attack feet but rub face on everything hopped up on goofballs.

---

### Markdown Semantic Text Elements

**Bold** `**Bold**`

_Italic_ `_Italic_`

~~Strikethrough~~ `~~Strikethrough~~`

`Inline Code` `` `Inline Code` ``

### HTML Semantic Text Elements

<abbr>I18N</abbr> `<abbr>`

<cite>Citation</cite> `<cite>`

<kbd>Ctrl + S</kbd> `<kbd>`

Text<sup>Superscripted</sup> `<sup>`

Text<sub>Subscripted</sub> `<sub>`

<u>Underlined</u> `<u>`

<mark>Highlighted</mark> `<mark>`

<time>20:14</time> `<time>`

<var>x = y + 2</var> `<var>`

---

### Blockquote

> The advance of technology is based on making it fit in so that you don't really even notice it,
> so it's part of everyday life.
>
> <cite>- Bill Gates</cite>

```markdown
> The advance of technology is based on making it fit in so that you don't really even notice it,
> so it's part of everyday life.
>
> <cite>- Bill Gates</cite>
```

> “Inside every cynical person, there is a disappointed idealist.”

<cite>– George Carlin</cite>

---

### Unordered List

* list item 1
* list item 2
    * list item 2.1
    * list item 2.2
    * list item 2.3
* list item 3

```markdown
* list item 1
* list item 2
    * list item 2.1
    * list item 2.2
    * list item 2.3
* list item 3
```

---


### Ordered List

1. list item 1
1. list item 2
    1. list item 2.1
    1. list item 2.2
    1. list item 2.3
1. list item 3

```markdown
1. list item 1
1. list item 2
    1. list item 2.1
    1. list item 2.2
    1. list item 2.3
1. list item 3
```

---


### Table

| Name                        | Genre                         | Release date         |
| :-------------------------- | :---------------------------: | -------------------: |
| The Shawshank Redemption    | Crime, Drama                  | 14 October 1994      |
| The Godfather               | Crime, Drama                  | 24 March 1972        |
| Schindler's List            | Biography, Drama, History     | 4 February 1994      |
| Se7en                       | Crime, Drama, Mystery         | 22 September 1995    |

```markdown
| Name                        | Genre                         | Release date         |
| :-------------------------- | :---------------------------: | -------------------: |
| The Shawshank Redemption    | Crime, Drama                  | 14 October 1994      |
| The Godfather               | Crime, Drama                  | 24 March 1972        |
| Schindler's List            | Biography, Drama, History     | 4 February 1994      |
| Se7en                       | Crime, Drama, Mystery         | 22 September 1995    |
```

---

### Notices

The notices styles are actually provided by the `markdown-notices` plugin but are useful enough to include here:

! This is a warning notification

!! This is an error notification

!!! This is a default notification

!!!! This is a success notification


```markdown
! This is a warning notification

!! This is an error notification

!!! This is a default notification

!!!! This is a success notification
```

---


### Code

Single-line code:

`Use single apostrophes for one line.`

Use “code fences” \`\`\` to block in multiple lines of code.

```html
<h5>This is unrendered code in monospace and a selected language format...</h5>
```

```css
a#logo h1 {
  color: #ff0000;
}

#header {
  background: #000000;
}
```

```scala
 class Queue[T](
    private val leading: List[T],
    private val trailing: List[T]
  ) {
    private def mirror =
      if (leading.isEmpty)
        new Queue(trailing.reverse, Nil)
      else
        this

    def head = mirror.leading.head

    def tail = {
      val q = mirror
      new Queue(q.leading.tail, q.trailing)
    }

    def append(x: T) =
      new Queue(leading, x :: trailing)
  }
```

```css
a#logo h1 {
  color: #ff0000;
}

#header {
  background: #000000;
}
```