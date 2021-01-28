---
layout: post
author: zemin 
category: MR 
demo: false 
---

# Mixed Reality Paris Motor Show

## MRTK

**MRTK** is a toolkit developed by Microsoft in order to accelerate the development of Hololens app in Unity. In this toolkit, some pre-made UI tool provide a coherent visual effect as well as powerful functionalities. Besides, the profile in MRTK is used to configure the settings.

## Project

**Paris Motor Show** is a project using **MRTK** to build a demo app displaying motor in mixed reality(XR), whose target platform is Hololens 2. The goal is to experiment and get pratical development experience in XR.  In this post, I will describe briefly the steps. It used **Unity** engine, its XR package and mainly **MRTK**.

### welcome dialog

The app starts with a welcome dialog. To do so, I used the dialog prefab from **MRTK** and put it inside the scene. The event system is like Unity's event system, which allows us to trigger a script of a gameobject selected.

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/dialog_prefab.png " "){:width="100%"}

&nbsp;

The buttons are set so that if we confirm it, we can access the second view.

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/dialog_first.png " "){:width="100%"}

&nbsp;

### preference dialog

The user can choose among options a mark of car which interests me, this selection will allow him directly move to the place in front of a car of this mark.


![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/dialog_first.png " "){:width="100%"}

&nbsp;



## parameters

As this is a plane object onto world, it should take **linear** as processing type.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pc/parameters.png " "){:width="100%"}

&nbsp;

## result

The result is good enough, even though here are some points of my book shelf and the frame of painting is not complete. We can easily remove it within any point cloud editing tool like **MeshLab**.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pc/view_front_raw.png " "){:width="100%"}

&nbsp;

As we see closer, we may find that there are some holes in the painting. We can also find some part is purple, that is because the light is yellow, and the tree is black.

Another issue is that the bottom part of painting lose lots of details. I think the reason is that when I takes the photo, the camera is under the bottom line. In photos there are not details on this part.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pc/view_random_angle.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pc/view_front_close.png " "){:width="100%"}

&nbsp;