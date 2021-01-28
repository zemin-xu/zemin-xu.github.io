---
layout: post
author: zemin 
category: MR 
demo: paris_motor_show.mp4
---

# Mixed Reality Paris Motor Show

## MRTK

**MRTK** is a toolkit developed by Microsoft in order to accelerate the development of Hololens app in Unity. In this toolkit, some pre-made UI tool provide a coherent visual effect as well as powerful functionalities. Besides, the profile in MRTK is used to configure the settings.

## Project

**Paris Motor Show** is a project using **MRTK** to build a demo app displaying motor in mixed reality(XR), whose target platform is Hololens 2. The goal is to experiment and get pratical development experience in XR.  In this post, I will describe briefly the steps. It used **Unity** engine, its XR package and mainly **MRTK**.

### welcome dialog

The app starts with a welcome dialog. To do so, I used the dialog prefab from **MRTK** and put it inside the scene. The event system is like Unity's event system, which allows us to trigger a script of a gameobject selected.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/dialog_prefab.png " "){:width="100%"}

&nbsp;

The buttons are set so that if we confirm it, we can access the second view.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/dialog_first.png " "){:width="100%"}

&nbsp;

### preference dialog

The user can choose among options a mark of car which interests me, this selection will allow him directly move to the place in front of a car of this mark. In real world, the position and rotation is controlled by headset. In this simulator, we can modify the properties of camera to make it move.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/option_buttons.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/dialog_button_config.png " "){:width="100%"}

&nbsp;


### importation of car models

On **sketchfab.com**, I found some car models and imported into the project. I extracted an material to control the color of car body, so that I can change it later, by setting the properties of this material.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/models.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/model_color.png " "){:width="100%"}

&nbsp;

Sometimes the user will get lost in the scene. I put an indicator which will display the direction when the avatar is far from main scene. This is a prefab from MRTK.

### color button

The physical button prefab of MRTK have a sound and touch feedback when we press it. By writing a custom script, the color changing function can be triggered once the button is pressed.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/color_button.png " "){:width="100%"}

&nbsp;

### title and information

In order to show the brief information and detail one, I used simple 3D text and tooltip of MRTK, as well as a dialog box when user is close and would like to know more. I put blue platforms for car, and put the 3D text onto them. When we gaze at a car, we can see the specific model of that car.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/platforms.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/titles.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/tooltip.png " "){:width="100%"}

&nbsp;

The mechanics of the information dialog used the collier in Unity. It is only when the user is close enough of the car, the info button will appear and charge in the corresponding information of car.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pms/moreinfo.png " "){:width="100%"}

&nbsp;

### rating

At the end of this visit, the app will ask user for a rating. The source code can be found [here](https://github.com/zemin-xu/ParisMotorShow). Below is a demo video.

&nbsp;
