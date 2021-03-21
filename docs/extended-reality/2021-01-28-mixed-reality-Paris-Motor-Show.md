---
layout: default 
parent: Extended Reality
title: Paris Motor Show -- Mixed Reality
---

# {{ page.title }}

**Paris Motor Show** is a project using **MRTK** to build a demo app displaying motor in mixed reality(XR), whose target platform is Hololens 2. The goal is to experiment and get practical development experience in XR.  In this post, I will describe briefly the steps. It used **Unity** engine, its XR package and mainly **MRTK**.
{: .fs-6 .fw-300 }

---

## MRTK

**MRTK** is a toolkit developed by Microsoft in order to accelerate the development of Hololens app in Unity. In this toolkit, some pre-made UI tool provide a coherent visual effect as well as powerful functionalities. Besides, the profile in MRTK is used to configure the settings.

### welcome dialog

The app starts with a welcome dialog. To do so, I used the dialog prefab from **MRTK** and put it inside the scene. The event system is like Unity's event system, which allows us to trigger a script of a gameobject selected.

<img src="{{ site.url_imgs }}/pms/dialog_prefab.png " style="width: 100%">{: .px-8 }



The buttons are set so that if we confirm it, we can access the second view.


<img src="{{ site.url_imgs }}/pms/dialog_first.png " style="width: 100%">{: .px-8 }



### preference dialog

The user can choose among options a mark of car which interests me, this selection will allow him directly move to the place in front of a car of this mark. In real world, the position and rotation is controlled by headset. In this simulator, we can modify the properties of camera to make it move.



<img src="{{ site.url_imgs }}/pms/option_buttons.png " style="width: 100%">{: .px-8 }



<img src="{{ site.url_imgs }}/pms/dialog_button_config.png " style="width: 100%">{: .px-8 }




### importation of car models

On **sketchfab.com**, I found some car models and imported into the project. I extracted an material to control the color of car body, so that I can change it later, by setting the properties of this material.



<img src="{{ site.url_imgs }}/pms/models.png " style="width: 100%">{: .px-8 }



<img src="{{ site.url_imgs }}/pms/model_color.png " style="width: 100%">{: .px-8 }



Sometimes the user will get lost in the scene. I put an indicator which will display the direction when the avatar is far from main scene. This is a prefab from MRTK.

### color button

The physical button prefab of MRTK have a sound and touch feedback when we press it. By writing a custom script, the color changing function can be triggered once the button is pressed.



<img src="{{ site.url_imgs }}/pms/color_button.png " style="width: 100%">{: .px-8 }



### title and information

In order to show the brief information and detail one, I used simple 3D text and tooltip of MRTK, as well as a dialog box when user is close and would like to know more. I put blue platforms for car, and put the 3D text onto them. When we gaze at a car, we can see the specific model of that car.



<img src="{{ site.url_imgs }}/pms/platforms.png " style="width: 100%">{: .px-8 }



<img src="{{ site.url_imgs }}/pms/titles.png " style="width: 100%">{: .px-8 }



<img src="{{ site.url_imgs }}/pms/tooltip.png " style="width: 100%">{: .px-8 }



The mechanics of the information dialog used the collier in Unity. It is only when the user is close enough of the car, the info button will appear and charge in the corresponding information of car.



<img src="{{ site.url_imgs }}/pms/more_info.png " style="width: 100%">{: .px-8 }



### rating

At the end of this visit, the app will ask user for a rating. The source code can be found [here](https://github.com/zemin-xu/ParisMotorShow). Below is a demo video.

<video id="player" playsinline controlsstyle="width: 100%">{: .px-8 }
<source src= "{{ site.url_videos }}/paris_motor_show.mp4" type="video/mp4" />
</video>
