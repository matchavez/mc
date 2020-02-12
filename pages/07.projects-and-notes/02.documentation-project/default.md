---
title: 'Documentation Project'
---

> Have you ever needed to write documentation that shares content, and you don't want to keep it in two places?
> 
> Have you ever thought that a huge, running, linear document is a bad idea for something?
> 
> Do you take fragmented notes, but want them to be available in one document?
> 
> Ever thought markdown is cool, but never looks all that good?

Ya, sounds like marketing pitch for something, but it's not. I've got a method of doing documentation that I want to share. First, it's free. Second, it's markdown, so there's nothing to learn. And third, it's cross-platform, editor-agnostic, and can work with git repos or shared file systems or just plain local files. Bonus -- it can be scripted and run on something like Jenkins!

I've been working on this, and it's come up several times. Until now, I haven't been happy with the outcome, but now, I have this thing polished and usable. So it's time to share.

### So what is this thing?

It's a documentation system. The goal is that you can create partial document pieces, keep them somewhere, and use what you need, when you want. Then you can convert from markdown ugliness to a nice, consistent style sheet to give you HTML or PDF output that looks sharp. 

### What's needed?

All the software is free, and all you need to do is create a simple manifest of partial documents. You'll want to have either Atom or VSCode. It doesn't matter what OS you use; we'll cover Windows, and Linux/Mac.

### Draw me something

So what you're doing is:

.md \

.md   |

.md    |--->  script to combine document --> render using plugin for style --> output PDF or HTML

.md   |

.md /

Let's figure out which text editor you like, and we'll go from there:

[I LIKE Atom](i-like-atom)

[I LIKE VSCode](i-like-vscode)