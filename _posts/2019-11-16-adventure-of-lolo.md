---
layout: post
author: zemin 
category: C++ 
demo: true
demo_link: adventure_of_lolo.mp4
---

# Introduction to C++

[*Adventure of Lolo*](https://en.wikipedia.org/wiki/Adventures_of_Lolo) is a puzzle video game released in 1989. In the course *Introduction to C++*, I need to reproduce a video game with the same gameplay. This one-month project aims at practising C++. I used the sprite of my favorite [bomberman game](https://www.youtube.com/watch?v=WXATi38zgYE) in Childhood as texture.

## Structure

I used [SFML](https://www.sfml-dev.org) as the framework, which provides basic interfaces for developing multimedia app. Before programming, I designed the structure carefully so as to use the advantage of object-oriented programming.
&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/adventure_of_lolo_uml.png "UML of program"){:width="100%"}

## Gameplay

A player will have a main marker on the back of his hand as well as two secondary markers on two fingers. When diplaying the main marker without secondary one, the player results in getting a Rock in app. A main marker with one secondary one equals to scissors. All marker displayed means paper. When players are ready, one of them should click on Run button and display their marker(s) under camera. Corresponding animation will be trigger when the two icons are close enough.

## Experiments

The first problem we encountered was that the recognition of tattoo on skin was not as good as we imagined.
&nbsp;
At that moment, we used illustrations on cartons as an alternative way. At the same time, we did furthur experiments on recogition of tattoo. We firstly tested tattoo on forearm because the skin there is flatter.
&nbsp;
We applied the technique of stencil as well. The pattern on stencil was successfully recognized, but the tattoo itself was not. After that, we captured a photo of an existant tattoo and uploaded it into database of *Vuforia*. The problem existed. Therefore, we drew a conclusion that *Vuforia* is suitable for markers on plane.
&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rock_paper_scissors_forearm_stencil.jpg "tattoo on back of a hand"){:width="100%"}
&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rock_paper_scissors_forearm.jpg "tattoo on back of a hand"){:width="100%"}
&nbsp;
Partners: [E.Meurice](https://www.linkedin.com/in/eva-meurice/), [A.Mougin](https://www.linkedin.com/in/arthur-mougin/), [J.Pigrée](https://www.linkedin.com/in/jean-baptiste-pigrée-876087110/)
&nbsp;
