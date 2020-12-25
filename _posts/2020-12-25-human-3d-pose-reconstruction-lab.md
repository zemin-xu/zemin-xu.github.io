---
layout: post
author: zemin 
category: CV
demo: false 
---

# Human 3D Pose Reconstruction Lab

The purpose of the lab is to implement the 3D reconstruction from multi-views of human pose on a calibrated system. The course and lab is provided by Tan-Khoa MAI in Telecom-SudParis, at ARTEMIS research group. The dataset and part of code are provided by him. The code can be found [here](https://github.com/zemin-xu/human_pose_reconstruction).

&nbsp;

Generally speaking, the dataset is composed of original videos from cameras of different views and text data about camera parameters and coordinates output of joints.

&nbsp;

Videos are different sportive activities recorded by different people(subject).

&nbsp;

Two type of data are important here: **2DTXT** file and **3DTXT** file. The 2DTXT contains arrays of 2D coordinates for each joint at each frame. The 3DTXT contains one more dimension coordinate information.

&nbsp;

## Draw keypoints on original videos with 2DTXT file

Each line in a **2DTXT** file is the information of a frame. It contains 25 pairs of array with order in (x, y, reliability). The *x* and *y* are the coordinates of this joint on the video. The main task here is to use functions in **opencv** to draw circles onto each original frame and save it. The key code is provided below: in a double loop, the x and y data will be extracted and a white circle will be draw onto each joint of each frame.

&nbsp;

``` python
for i in range(nFrame):
    ret, frame = cap.read()
    for j in range(numJoint):
        data2d = pose2Dv0[i][j]
        x = data2d[0].astype('int')
        y = data2d[1].astype('int')
        cv2.circle(frame, (x, y), 4, (255, 255, 255))  
    vidWriter.write(frame)
```

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/pc/painting.png " "){:width="100%"}
###### video with keypoints

&nbsp;
