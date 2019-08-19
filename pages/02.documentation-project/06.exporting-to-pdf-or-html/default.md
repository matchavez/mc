---
title: 'Exporting to PDF or HTML'
---

This might be the easiest step of all.

Once you have the document open within the Preview, right click anywhere in the preview window. You'll get lots of options, but the two important ones are:

- HTML (offline)
- Chrome (Puppeteer) > PDF

The HTML option creates a self-encapsulated HTML. Be aware of any image links, and ensure those have worked as expected. If you plan to upload the HTML, make sure the assets come along as well. Obviously, this is only kicking out a `.html` single file, thus, it will be dependent on internal references if any outside links are not absolutes.

The PDF option creates a self-contained document, images and all. It uses Chrome's pdf engine, and that one has shown to work a lot better than Pandoc or wkhtmltopdf. Those products are fine, but have a tendency to work in odd ways with tables and code.

That's it! That's all there is to it. To recap, you've written markdown in pieces, stitched it together, styled it, and exported it. Each subsequent time should be very quick, and easy to view locally. Well done!

But now, to take it one level further, you may want to [script something](../scripting), especially if your documentation is based on a deployment script.
