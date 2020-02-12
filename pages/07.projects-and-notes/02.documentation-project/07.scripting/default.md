---
title: Scripting
---

If you're here, that means you're pretty advanced with what you're trying to do. Good deal. Here's the technical:

Two Python scripts can get you home on this. Make sure you know which version of Python you're on. 

```python
python -v
```

Install Pandoc on your build machine if you haven't already. [Normal ways](https://pandoc.org/installing.html), or on a Mac:

```sh
brew install pandoc
```
You'll also need that CSS file you customised earlier - but without that surrounding `html body{}` style. 

First, call the concatenation script from earlier. This will update all of your content, and obviously clobber any old version. It's idempotent.

Second, you'll convert to an intermediary HTML format. You don't have to keep this after you're done, but it's needed for puppeteer.

```sh
pandoc -f gfm+fenced_code_blocks+pipe_tables+task_lists+emoji -t html -V css=/Path/To/File/cascade_style.css --self-contained -o foo.html foo.md
```
Then run a conversion:

```sh
wkhtmltopdf -B 25mm -T 25mm -L 25mm -R 25mm -q -s A4 foo.html output_file_name.pdf
```
This format may leave some headers and footers. As of writing, it's a bug that you can't get rid of them. (One option is setting margins to 0mm, but I didn't like it.) Another option is to run Chrome headless, requiring Chrome be installed where you run this:

```sh
/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --headless --displayHeaderFooter=false --print-to-pdf=foo.pdf foo.html
```

Again, this may not work because of a bug with Chrome.

With a little scripting, or even just a watched folder, you actually have an extremely light static CMS now. Just make the output point to the viewable location of your public docs, and run the script on cron, and the HTML will update. You might also want to run the pandoc HTML script across the fragments and put them into individual pages, depending on your setup. The good part is you can also take those .md files and put them into [readthedocs.io](https://readthedocs.io) or whatever you need. The choice is yours. 

I hope this helps. If it has, let me know.

!!!! Yet to write: Use custom fonts, CSS tricks and table widths, single line code wrap