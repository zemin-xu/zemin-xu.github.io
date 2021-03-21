---
layout: default 
title: Point Cloud reconstruction
parent: Computer Vision
demo: false 
---

# Point Cloud Reconstruction

The goal of this lab is to gain practical experience of point cloud reconstruction. By choosing a meaningful object, we will takes several overlap photos and use C3DC application to reconstruct its point cloud model.

## Object

The object I choose is a monochrome photography in my room, which should be a linear type in cloud reconstruction. I take photo under my room light, so that the lighting condition is good enough. The order of photos are important. We should not take from an arbitrary angle and continue with another one. The correct way is to choose a direction and vary a certain amount of angle. The image below shows the photos I take.



<img src="{{ site.url_imgs }}/pc/painting.png " class=".mx-auto" style="width: 100%">



<img src="{{ site.url_imgs }}/pc/painting_all_images.jpg " class=".mx-auto" style="width: 100%">



## parameters

As this is a plane object onto world, it should take **linear** as processing type.



<img src="{{ site.url_imgs }}/pc/parameters.png " class=".mx-auto" style="width: 100%">



## result

The result is good enough, even though here are some points of my book shelf and the frame of painting is not complete. We can easily remove it within any point cloud editing tool like **MeshLab**.



<img src="{{ site.url_imgs }}/pc/view_front_raw.png " class=".mx-auto" style="width: 100%">



As we see closer, we may find that there are some holes in the painting. We can also find some part is purple, that is because the light is yellow, and the tree is black.

Another issue is that the bottom part of painting lose lots of details. I think the reason is that when I takes the photo, the camera is under the bottom line. In photos there are not details on this part.



<img src="{{ site.url_imgs }}/pc/view_random_angle.png " class=".mx-auto" style="width: 100%">



<img src="{{ site.url_imgs }}/pc/view_front_close.png " class=".mx-auto" style="width: 100%">

