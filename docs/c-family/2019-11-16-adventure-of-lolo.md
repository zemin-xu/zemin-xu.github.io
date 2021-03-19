---
layout: default 
title: My First Class of C++
parent: C, C++, C# 
demo: true
demo_link: adventure_of_lolo.mp4
---

[*Adventure of Lolo*](https://en.wikipedia.org/wiki/Adventures_of_Lolo) is a puzzle video game released in 1989. In the course *Introduction to C++*, I need to reproduce a video game with the same gameplay. This one-month project aims at practising C++. In this project, I used the sprite of my favorite [bomberman game](https://www.youtube.com/watch?v=WXATi38zgYE) in Childhood as texture. You can find the source code [here](https://github.com/zemin-xu/SFML).

## Structure

I used [SFML](https://www.sfml-dev.org) as the framework, which provides basic interfaces for developing multimedia app. Before programming, I designed the structure carefully so as to use the advantage of object-oriented programming.
&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/adventure_of_lolo_uml.png "UML of program"){:width="100%"}

## Problematic

### Collision

One of the difficulty comes from the collision, especially that between the movable box with other objects. To solve it, I used a ghost which is a bit smaller than its form. The ghost will move firstly and return the info whether it can move or not.
&nbsp;

``` C++
    // The concept of shape and real is important
    // to do the collision detection in game.
    // Each element will have two rectangle shape representing
    // the real part(invisible, a bit smaller and the visible part.
    /*
            -----------------
            -      shape    -
            -               -
            -    ********   -
            -    * real *   -
            -    *      *   -
            -    ********   -
            -----------------

     */
```

By the way, I used this [method](http://jeffreythompson.org/collision-detection/rect-rect.php) to do collision detection.

### AI behaviour

under construction.
