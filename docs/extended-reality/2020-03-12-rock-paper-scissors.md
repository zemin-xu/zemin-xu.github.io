---
layout: default 
parent: Extended Reality
title: Rock Paper Scissors -- Augmented Reality
demo: true
---

# {{ page.title }}

Collaborators: [E.Meurice](https://www.linkedin.com/in/eva-meurice/), [A.Mougin](https://www.linkedin.com/in/arthur-mougin/), [J.Pigrée](https://www.linkedin.com/in/jean-baptiste-pigrée-876087110/)

*Rock Paper Scissors* is an one-week project realized by me with three classmates. The purpose of this workshop is to develop an app emphasizing augmented reality technology, using *Unity* and *Vuforia* framework.
{: .fs-6 .fw-300 }

---


## Concept

The idea is simple: augmented reality with tattoo as marker. Here, tattoo serves as the marker. The concept is afterwards developed by combining with the [Rock Paper Scissors](https://en.wikipedia.org/wiki/Rock_paper_scissors).

<img src="{{ site.url_imgs }}/rock_paper_scissors_hand.jpg " style="width: 100%">{: .px-8 }

## Gameplay

A player will have a main marker on the back of his hand as well as two secondary markers on two fingers. When diplaying the main marker without secondary one, the player results in getting a Rock in app. A main marker with one secondary one equals to scissors. All marker displayed means paper. When players are ready, one of them should click on Run button and display their marker(s) under camera. Corresponding animation will be trigger when the two icons are close enough.

## Experiments

The first problem we encountered was that the recognition of tattoo on skin was not as good as we imagined.

At that moment, we used illustrations on cartons as an alternative way. At the same time, we did furthur experiments on recogition of tattoo. We firstly tested tattoo on forearm because the skin there is flatter.

We applied the technique of stencil as well. The pattern on stencil was successfully recognized, but the tattoo itself was not. After that, we captured a photo of an existant tattoo and uploaded it into database of *Vuforia*. The problem existed. Therefore, we drew a conclusion that *Vuforia* is suitable for markers on plane.

<img src="{{ site.url_imgs }}/rock_paper_scissors_forearm_stencil.jpg " style="width: 100%">{: .px-8 }

<img src="{{ site.url_imgs }}/rock_paper_scissors_forearm.jpg " style="width: 100%">{: .px-8 }

<video id="player" playsinline controls style="width: 100%">
<source src= "{{ site.url_videos }}/rock_paper_scissors.mp4" type="video/mp4" />
</video>