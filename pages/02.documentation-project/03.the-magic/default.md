---
title: 'The Magic'
---

Combining fragmented documents is really the magic here. And for all the different applications I've seen, not many do it better. Short history; I first solved this issue with an app called Scriviner. It's excellent, and still is for sure. Great developer, solid product. It's really a book or screenplay writing application, and it does a great job. However even the best of these kinds of applications still require JSON storage in a local SQLite database. If that makes no sense, it means in short that you will have some sort of lock-in... whether it means buying everyone on your team a license, or you're taking your markdown and putting it into someone else's format.

Enough of that - you came here for the fix. And in reality, it's been right under our nose the whole time. Windows, Mac, Linux... they all have something built into the operating system called concatenation. Specifically, they have a function you can call. Concatenation is simply taking A + B + C and making ABC; in this case three things into one. What we want to do with markdown is the same:

###### Fragment_1.md + Fragment_2.md + Fragment_3.md -> combined_file.md

This is illustrative, and not that difficult. However, let's demonstrate a more complex problem that happens a lot in a workplace. Instead of A + B + C, let's say there's a lot more... like A through Z. But there's also the desire to create a smaller subset document. No problem.

So instead of A thru Z, we just order up E+G+J+K, and combine that to be a specific document. The _advantage_ is that when you edit any of the fragments, it becomes available for any document the next time you build it. This allows you to create specific document manifests that can be continually updated without reconstructing a linear document.

How it works is you make a **script** for each document manifest. I know this sounds daunting, but it's really, _really_ not. Here's how you do it:

---

## Linux and Mac

###### (This should also be ok for Windows PowerShell, but we'll cover Windows Batch files in the next section as well.)

For Linux or Mac, you'll create what's called a bash script, or otherwise known as a shell script. It's a very simple set of instructions for your operating system. It will say to it, in short, "take the following files and assemble them in this order into one compiled file".

```sh

        ``` bash {cmd=true}
        #!/bin/bash
        # Concatenation script for a document map
        cat \
        chapter_one.md \
        chapter_two.md \
        chapter_three.md \
        > complete_doc.md
        ` ``

```

Simply, create a text file that's a markdown (.md) file like all the others you'll make, and put this text in it. 

(Wait, not a .sh? No, because we're going to execute it inline. It can be a .sh still. That's why the ` ``` bash {cmd=true}` also. More to come.)

- Chapter names for whatever you want for files
- Rename the "complete_doc" into whatever you want the new file called
- Leave the cat space backslash alone; that's the "cat" command telling the shell to concatenate
- Leave a space and backslash after each for readability
- Do not add any broken lines between unless you add a backslash
- The closing three backticks have spaces between here for display. Yours should not.

!!! It should be noted that anyone with bash experience will see that this is a one line command, but it's stretched for legibility and editing purposes. Technically, this could just be ` cat one.md two.md three.md > summed.md` and work, but it's not as easy that way.

When you do this, we'll later on execute this script. Each time you run it, it will write or **overwrite** the existing version of the document, so be aware that if you want to maintain an older version, etc., this process will "clobber" the existing file.

---

## Windows

For Windows, you'll create what's called a batch script. It's a very simple set of instructions for your operating system. It will say to it, in short, "take the following files and assemble them in this order into one compiled file".

```sh

		copy ^
        chapter1.md + ^
        chapter2.md + ^
        chapter3.md ^
        combined_doc.md


```

I named these a little differently from the Linux/Mac script only to distinguish between the files. Simply, create a text file that's a markdown file like all the others you'll make, and put this text in it.
- Chapter names for whatever you want for files
- Rename the "combined_doc" into whatever you want the new file called
- Leave the copy space caret alone; that's the "copy" command telling the shell to concatenate
- Leave a space plus space caret after each for readability, except on the last fragment line. For that one, remove the + symbol as shown.
- Do not add any broken lines between unless you add a caret

!!! It should be noted that anyone with batch experience will see that this is a one line command, but it's stretched for legibility and editing purposes. Technically, this could just be ` copy one.md+two.md+three.md summed.md` and work, but it's not as easy that way.

When you do this, we'll later on execute this script. Each time you run it, it will write or **overwrite** the existing version of the document, so be aware that if you want to maintain an older version, etc., this process will "clobber" the existing file.

! Don't forget if you're using windows, it's a backslash. 🙂 

---

##### Advice for file setup

Your setup matters! If you abstract your artifacts from your documents, make sure the /artifacts (or /images or whatever) folder is equal to your shortest path document. This will ensure relative links will work with multiple document mappings.

```
/docs
  - 1.md
  - 2.md

/other_docs
  - 3.md
  - 4.md

/artifacts
  - image.jpg
  - graphic.png
```

##### If you place the artifact in the organisation path (like an image within `/other_docs` in the example), it risks not working if a link within an .md to an image/artifact/file isn't absolute. This will result in broken paths!


Now, go [get the plugin...](../get-the-plugin)