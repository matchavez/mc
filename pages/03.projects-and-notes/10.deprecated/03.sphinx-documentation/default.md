---
title: 'Sphinx Documentation'
---

! This content may be somewhat out of date.

# Preamble & Objective:

Given the many options for putting word-to-page, documentation is often a difficult by-product of complex projects. In software, it is often the most cast-off segment of work that has some of the most time-constrained effort. The traditional cycle of define, create, test, then document is never optimal. Add on top the need to iterate using tools that are designed for the static document, particulary the "word processor", and you end up in a cycle that keeps documentation away from those creating and playing a game of "telephone" with the Technical Writing team.

In our team, this was the end goal:

* Get developers to make the first pass at documents, since they know what they are doing
* Get the technical writer to be a curator and formatter, not a creator of content
* Create a system where the documentation can live alongside features, stored within the code files
* Generate the latest documentation using the software build process
* Make the documents available offline, in HTML and PDF format

This certainly seems like a lofty goal, and one that could become unweildy without a good working system. We looked long and hard at online systems as a service, and in the end found that our organisation wanted the flexibility to write without the dependency of a third party, and the lack of control that offered. If we were going to tackle all of these goals, we needed to do them with tools we control. The funny part is that while the budget wasn’t much of an object, we found what we needed for free.

Ya, really. $0.

# What’s the Toolbox?

The first question of every project is to decide what you’re going to plumb together and create. It took some maturisation, but when we got there, it was pretty simple.

---
# Sphinx Install with Markdown

##### These instructions will walk through a basic install of the Sphinx documentation system for a local setup with the accompanying themes and configurations.

#### Step 0 - Pre-reqs

Assume a full install of 16.04.4 LTS Ubuntu, if a VM minimum 25gb hd, and internet connectivity. Recommend multi-core, especially if a VM. Must have sudo rights.

### Installation

#### Step 1 - Fully update Ubuntu

```sh
$ sudo apt update -y
$ sudo apt upgrade -y
$ sudo apt dist-upgrade -y
```

> The "upgrade" step may take a few minutes

#### Step 2 - Install Python and update pip

```sh
$ sudo apt-get install python-pip -y
$ sudo pip install --upgrade pip
```

#### Step 3 - Install Sphinx and theme files

```sh
$ sudo pip install sphinx
$ sudo pip install sphinxjp.themes.basicstrap
$ sudo pip install sphinx_bootstrap_theme
```

#### Step 4 - Install the PDF Generator

```sh
$ sudo apt-get install texlive -y
```

> This may take 10-20 minutes

#### Step 5 - Install the Markdown parser and close Terminal window

```sh
 $ sudo pip install recommonmark
 $ sudo pip install sphinx-markdown-tables
```

**Action: Close the current terminal window to de-privilege._**

(Without a close and re-open of the terminal window, the following script will create privileged files and they will have to be chown'd to allow user runs.)

### This completes the installation steps

---

### Creating a project and rendering content

#### Step 6 - Project setup

The project folder will be a self-contained directory with all source and build files. It is portable, but you must change to that directory each time you want to run a content generation. An advanced setup might be a local git sync. The example here moves out of home into /Documents/sph, but that is a user decision. Settings are recommended, but may not be applicable to all projects. These settings will all be adjustable after the opening script is complete.

```sh
$ cd Documents
$ mkdir sph
$ cd sph
Documents/sph$ sphinx-quickstart
```

`Welcome to the Sphinx quickstart utility.`
`Please enter values for the following settings (just press Enter to`
`accept a default value, if one is given in brackets).`
`Selected root path: .`
`You have two options for placing the build directory for Sphinx output.`
`Either, you use a directory "_build" within the root path, or you separate`
`"source" and "build" directories within the root path.`
`> Separate source and build directories (y/n) [n]:` 

```sh
y
```

`Inside the root directory, two more directories will be created; "_templates"`
`for custom HTML templates and "_static" for custom stylesheets and other static`
`files. You can enter another prefix (such as ".") to replace the underscore.`
`> Name prefix for templates and static dir [_]:` 

```sh
<Enter>
```


`The project name will occur in several places in the built documentation.`
`> Project name:` 

*Enter your official project name. This can be changed, but it is worth getting it right first.*

`> Author name(s): `

*Enter author or team names here*

`> Project release []:`

*While optional, if versioning is a consideration, select the matching version number*

`If the documents are to be written in a language other than English,`
`you can select a language here by its language code. Sphinx will then`
`translate text that it generates into that language.`
`For a list of supported codes, see`
`http://sphinx-doc.org/config.html#confval-language`
`\> Project language [en]:`

*Press enter if English, or select the appropriate two letter iso code*

`The file name suffic for source files. Commonly, this is either ".txt"`
`or ".rst". Only files with this suffic are considered documents.`
`> Source file suffix [.rst]:`

```sh
<Enter>
```

`One document is special in that is is considered the top node of the`
`"contents tree", that is, it is the root of the heirarchical structure`
`of the documents. Normally, this is "index", but if your "index"`
`document is a custom template, you can also set this to another filename.`
`> Name of your master document (without suffix) [index]:`

```sh
<Enter>
```

`Sphinx can also add configuration for epub output:`
`> Do you want to use the epub builder (y/n) [n]:` 

```sh
n
```

`Indicate which of the following Sphinx extensions should be enabled:`
`> autodoc: automatically insert docstrings from modules (y/n) [n]:`

```sh
y
```
`> doctest: automatically test code snippets (y/n) [n]:`

```sh
y
```
`> intersphinx: link between Sphinx documentation of different projects (y/n) [n]:` 

```sh
n
```

`> todo: write "todo" entries that can be shown or hidden on build (y/n) [n]:`

```sh
n
```
`> coverage: checks for documentation coverage (y/n) [n]:` 

```sh
y
```
`> imgmath: include math, rendered as PNG or SVG images (y/n) [n]:`

```sh
n
```
`>mathjax: include math, rendered in the browser by MathJax (y/n) [n]:`

```sh
y
```
`> ifconfig: conditional inclusion of content based on config values (y/n) [n]:`

```sh
y
```
`> viewcode: include links to the source code of documented Python objects (y/n) [n]:`

```sh
n
```
`> githubpages: create .nojekyll file to publish the document on GitHub pages (y/n) [n]:`  

```sh
y
```
`A Makefile and a Windows command file can be generated for you so that you`
`only have to run e.g 'make html' instead of invoking sphinx-build`
`directly.`
`> Create Makefile? (y/n) [y]: <Enter>`

```sh
y
```
`> Create Windows command file? (y/n) [y]:`

```sh
n
```
`Creating file ./source/conf.py.`
`Creating file ./source/index.rst.`
`Creating file ./Makefile.`
`Finished: An initial directory structure has been created.`

#### Step 7 - Verify installed path

Within the Document (or other selected) path, validate all of the following files:

```
/Documents/sph/
  |--/build/
  |--/source/
     |--/_static/
     |--/_templates/
     |-- conf.py
     |-- index.rst
  |-- Makefile
```

#### Step 8 - Get Atom

```
$ sudo add-apt-repository ppa:webupd8team/atom
$ sudo apt update
$ sudo apt install atom -y
```

_Depending on the Atom install instructions, you may need to `[Enter]` through to complete the install._ It's also advantageous but optional to get the package called `markdown-preview-enhanced` to make markdown better in Atom. Go to Edit > Preferences > Install, search, and install.

Once installed, for simplicity, ` File > Add Project Folder` and add the path you installed, e.g. Documents/sph for ease of finding all the files.

#### Step 9 - Replace conf.py  contents

The entire conf.py file can be found at the end of this document. You can either replace the entire contents, careful to note the steps you'll have to redo with naming, or diff the contents to add the recommonmark import and theme settings.

You can choose to copy-paste using the following:

###### Add to the very top of conf.py:

```sh
import recommonmark
from recommonmark.transform import AutoStructify 
from recommonmark.parser import CommonMarkParser 
source_parsers = { 
  '.md': CommonMarkParser
}

import sphinx_bootstrap_theme
```

###### Add to the very bottom of conf.py:

```sh
def setup(app): 
  app.add_config_value('recommonmark_config', {
    'enable_math': True, 
    'enable_eval_rst': True, 
    'enable_auto_doc_ref': True, 
    'auto_code_block': True,
    }, True) 
  app.add_transform(AutoStructify)
```

###### Identify where `html_theme = 'alabaster'`, comment out that line, and insert the following after the comment

```sh
html_theme = 'bootstrap'
html_theme_path = sphinx_bootstrap_theme.get_html_theme_path()
html_theme_options = {
    'bootswatch_theme': "superhero",
    'bootstrap_version': "3",
}
```

###### Identify where `extensions = [`, and add the `'sphinx_markdown_tables',` line should be added

```sh
extensions = [
    'sphinx.ext.autodoc',
    'sphinx.ext.doctest',
    'sphinx.ext.coverage',
    'sphinx.ext.mathjax',
    'sphinx.ext.ifconfig',
    'sphinx.ext.githubpages',
    'sphinx_markdown_tables',
]
```

###### Finally, where the source_suffix says `'.rst'`, change it to equal the commented value

```sh
source_suffix = ['.rst', '.md']
```

#### Step 10 - Edit index.rst

```rst
.. toctree::
   :maxdepth: 2
   
   your-first-doc
```

The index.rst file can be amended to fit your needs. The first time you build html, it's going to make an index.html Table of Contents, plus the first file you create. In this case, if you were to write `your-first-doc.md` you would enter, as above, `your-first-doc` without the extension. There are also other global alphabetical methods, such as `:glob:` and other options once you're under way. The blank line between is necessary.

#### Step 11 - Add your first markdown document

In tandem with the prior step, add a .md file to the same location as `index.rst` and call it, in this example `your-first-doc.md` (or be consistent in naming this the same as the prior step). You can also use the example file called `works-in-recommonmark.md` to see most of the formatting options. It is not entirely inclusive, but all standard markdown is supported, along with additional reStructuredText command examples. If you copy the entire file into the same place as `index.rst` and name that file, it'll generate an example to compare the raw and rendered views, assisting as an example for the formatting of your work.

#### Step 12 - Generate Rendered Content

> Be sure to re-enter the same location via terminal before re-running these commands!

```sh
make html
make latexpdf
```

The first command will create the HTML content rendering found in `build` folder. The second will create a PDF using LaTeX. Each time you want to change the content, simply run the commands.


### This completes Creating a project and rendering content


For more information, see the associated files.