---
title: 'GFM vs JSON'
---

## Notetaking systems - Using GitHub Flavored Markdown .md text files vs. a JSON-formatted storage matrix

#### _This is where notes get really nerdy..._

In short, there are two directions to take when it comes to storing formatting and meta of notes within files. All notation applications have to retain content and show it on demand. That's essentially all any notes are; even on paper. You write notes, and paper has constant recall, available anytime.

I fall under the preference of readable notation _at all times_, and the format should be contained within it. Markdown is itself format that allows a standard text file to hold formatting by using specific sequences of characters to indicate specific formats. A simple example is that if you start and end a word or sentence or any sequence of characters with two asterisks, it will be formatted as "bold". This is clearly indicative on the raw text, making it human-interpretable as bold while still being plain text.

JSON formats are very easy to manipulate programmatically. JavaScript Object Notation means that a note can be contained in a less-readable but more manipulatable format. It captures meta easily within the file, and can handle conversion to more complex languages to retain more possible formats. For example, a JSON file can hold things like color of text, or saving image objects within a note. Applications also find this much easier to synchronise, and this becomes the basis for passing heavily-formatted notes between devices.

In the end, I think that the notes with _that much_ formatting reach into a different style of application. Are you writing a document or a note? Maybe if it's heavily formatted, it's definitely for an application that can handle those. My approach is that once you get Markdown figured out, it'll hold everything you really need. GFM offers checkmarks and tables, and adding something like Grav as your CMS allows further extension with !-notices and {c:#fbb} colours {/c}. All this on a fully readable raw format should leave you with more than enough to take information, save and recall it, and not be locked into a specific app with specific JSON formatting that may or may not import, export, or carry over. I always have raw text files that work everywhere. For me, that's the deal.
