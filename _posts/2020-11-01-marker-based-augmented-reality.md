---
layout: post
author: zemin 
category: CV
demo: false 
demo_link: vr_roll_a_ball.mp4 
---

# Marker-based Augmented Reality model report

## Problem statement

In this project, I need to design and implement an OpenCV solution. The solution relies on keypoint-based image descriptor to match between the image of a structured planar marker and its instance in webcam stream. In order to have a optimal solution under webcam stream utilization, there are several factors to consider about.

1. **Computation Time**
This factor is the most curcial one because in the solution, the detection and matching task should be finished less than 1 frame.
The minimum value should be 30 frames per second so that the streaming is fluent enough, that's is to say, the maximum computation time should be less than 0.03 second for each frame.
2. **Rotation & Scale Invariance**
It is normal that the instance in webcam will be rotated or shown in different size. Therefore, a feature detector that has rotational variance or scale variance should not be considered.
3. **Light Condition**
Sometimes the situation that the lighting is not ideal will happen, no matter for sample image or for webcam usage.
4. **Motion Blur**
A common situation for webcam is that the object will move slowly or fastly sometimes. The quality of detection should be considered even the object is moving.
5. **Robustness**
For me, a robust solution is that the detecting and matching result is generally good for any kind of image inputs, even under bad situation such as lighting.

In this project, I choose a hard book cover with rich details and another with much less interest points as objects to test.
I choose **SIFT**, **SURF**, **ORB**, **AKAZE** and **BRISK** as the feature detectors and carry out the experiments.
The **Harris Corner Detector**[1] and **Shi-Tomasi Corner Detector**[2] is eliminated because of their scale-variant feature.

## Theoretical study

### SIFT(Scale Invariant Feature Transform)

SIFT[3] is scale-invariant, which is also good at handling illumination change as well. It uses DoG as an approximation of LoG to calculate local extrema(potential keypoint) over scale[4]. SIFT provides distinctiveness, robustness and invariance to common image transformations such as rotation and scale[5]. It is widely accepted as one of highest quality options currently available, promising distinctiveness and invariance to a variety of common image transformations – however, at the expense of computational cost[6].

### SURF(Speeded-Up Robust Features)

SURF[7] approximates LoG with Box Filter convolution calculation, which is faster and is suitable for real-time detecting task. SURF is good at handling images with blurring and rotation, but not good at handling viewpoint change and illumination change.[8] Its implementation is in opencv_contrib repository.

### ORB(Oriented FAST and Rotated BRIEF)

ORB[9] is a binary feature descriptor that came from *OpenCV Lab* and is basically a fusion of FAST[10] keypoint detector and BRIEF[11] descriptor with many modifications to enhance the performance and scale as well as rotational invariance[12]. It employs the efficient Hamming distance metric for matching and these features make it suitable for real-time feature detection and description.
One of its parameters is *nFeatures* which denotes maximum number of features to be retained.

### AKAZE

AKAZE[13] is the accelerated version of KAZE[14] which uses non-linear scale space to find features. It uses a binary descriptor that exploits gradient infomation. It is proved to be an improvement in repeatability and distinctiviness compared to previous algorithms.

### BRISK

BRISK[6]

## Experiment

To have a optimal solution, I firstly evaluate the time for detection and matching operations of algorithms above. Each detector pointer is created with default parameters which are supposed to be the optimal ones.

### performance

The first experiment is to test the **computational time** of detection for each feature extractor. My CPU is Intel i5-9300H with clockspeed of 2.40 GHz. The calculation time of **detect()** function is tested. In source code you can find the **KPTest()** code implementation. For this test, the variable is the sample image differentiated in lighting and texture(detail).

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/sift_kp_less_light.png " "){:width="100%"}
###### SIFT keypoints with simple detail sample under light environment

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/sift_kp_rich_light.png " "){:width="100%"}
###### SIFT keypoints with rich detail sample under light environment

&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_sample_rich_dark_kp.png " "){:width="100%"}
###### performance comparison with rich detail sample under dark environment

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_sample_simple_dark_kp.png " "){:width="100%"}
###### performance comparison with simple detail sample under dark environment

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_sample_rich_light_kp.png " "){:width="100%"}
###### performance comparison with rich detail sample under light environment

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_sample_simple_light_kp.png " "){:width="100%"}
###### performance comparison with simple detail sample under light environment

&nbsp;

From the test above, we can find that the detection time of **SURF**, **ORB** and **BRISK** are at the same level of speed and are much faster than **SIFT** and **AKAZE**. Another observation is that **SURF** find the most keypoints among them.

&nbsp;

The second test is on matching. For binary string-based feature extractors(ORB, BRISK and AKAZE) I used **BruteForce-Hamming** matcher, and for floating-point ones I used **FLANN** matcher, because it is supposed to be faster than Brute Force based matcher for big dataset. The sample image is the one with simple detail under light environment.

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_match_akaze_light.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/AKAZE.gif " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_match_brisk_light.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_match_orb_light.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_match_sift_light.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/perf_match_surf_light.png " "){:width="100%"}

&nbsp;

From this test we can find that binary string-based descriptors match much faster than that of floating-point-based ones. From observation, I found that **SIFT** and **SURF** will influence the fluency of webcam streaming. However, the matching quality(matching rate) is also better. For binary string-based extractors, the **BRISK** and **AKAZE** are equally better than **ORB** in terms of stability. They all have the problem of jittering when moving the instance quickly. With **ORB**, the matching output will jitter even I hold the book in hand without motion. After this experiment, I decide:

1. Abandon **ORB** because of jittering.

2. Test with parameters of **SIFT** and **SURF** to make the amount of matching less, in order to have less calculation time. According to theory, **SURF** should be three times faster than **SIFT**.

3. Try to improve the matching quality to make sure that when I hold nothing, it will not do wrong matching.

### Rotation & scale

The next experiment is about rotational invariance and scale invariance. At a closer distance, the rotation will not influence much the result of all the descriptors. However, when I move the object away, their behaviour differs. For **SIFT** it is almost the same, but for **SURF** it is not as robust as before, with some jittering and unmatching. **BRISK** and **AZAKE** is not as good as before. But **BRISK** is more robust than **AKAZE** without unmatching.

### Varying parameters of descriptors

At this stage, I have a general idea of the characteristics of each descriptor. I divide them in to two group:

1. SIFT and SURF
2. BRISK and AKAZE

For the 1st group, I try varying their parameters to limit the calculation time to an acceptable value(0.16s). At the same time, they should have similar quality of matching without too much jittering.

I test with **SURF** by varying the value of **hessianThreshold**, ,**nOctaves** and **nOctaveLayers**.
By observation, the augmentation of **hessianThreshold** can be useful to augment the matching rate and performance time. However, it suffers from the jittering problem even the object is stable. What's worse is that it cannot detect object, if the object is not faced to camera.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/surf_default_100_4_3.png " "){:width="100%"}
###### SURF defaut parameters

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/surf_500_4_3.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/surf_800_4_3.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/surf_1200_4_3.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/surf_1200_4_2.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/surf_1200_3_3.png " "){:width="100%"}

&nbsp;

For **SIFT** descriptor, I use **Brute Force L2** matcher because I find that it is faster. There are several parameters for **SIFT**: **nfeatures**, **nOctaveLayers**, **contrastThreshold**, **edgeThreshold** and **sigma**. By varying them I find that the default value is the most robust choice. The change of threshold will make it a bit faster, but it starts suffering jittering.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/sift_default_0_3_4_10_16.png " "){:width="100%"}
###### SIFT defaut parameters

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/sift_0_3_4_10_12.png " "){:width="100%"}

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/mbar/sift_0_3_8_10_16.png " "){:width="100%"}

&nbsp;

By observation, I find that the computation time of **SIFT** is similar to **SURF**, while with a better quality, so I decide to abandon **SURF** for the solution.

&nbsp;

For the second group of **BRISK** and **AZAKE**, I try improving their detection and matching quality by varying their parameters.

&nbsp;

For **BRISK**, its parameters are **threshold**, **octaves** and **patternScale**.




&nbsp;

descriptor_type	Type of the extracted descriptor: DESCRIPTOR_KAZE, DESCRIPTOR_KAZE_UPRIGHT, DESCRIPTOR_MLDB or DESCRIPTOR_MLDB_UPRIGHT.
descriptor_size	Size of the descriptor in bits. 0 -> Full size
descriptor_channels	Number of channels in the descriptor (1, 2, 3)
threshold	Detector response threshold to accept point
nOctaves	Maximum octave evolution of the image
nOctaveLayers	Default number of sublevels per scale level
diffusivity	Diffusivity type. DIFF_PM_G1, DIFF_PM_G2, DIFF_WEICKERT or DIFF_CHARBONNIER

### Lighting

The next experiment is



### limitations

### advices

add limitation part
do video with quick zoom and slow zoom
test impact of preprocessing
test preprocessing like denoising
robustness(rotation, motion, lighting, background texture influence, marker itself)
give the install file zip
## References

1. [OPENCV -- Harris Corner Detection](https://docs.opencv.org/3.4/dc/d0d/tutorial_py_features_harris.html)

2. [OPENCV -- Shi-Tomasi Corner Detector & Good Features to Track](https://docs.opencv.org/3.4/d4/d8c/tutorial_py_shi_tomasi.html)

3. G. D. Lowe. Distinctive image features from scale-invariant keypoints. IJCV, pages 91–110, November 2004

4. [OPENCV -- Introduction to SIFT (Scale-Invariant Feature Transform)](https://docs.opencv.org/3.4/da/df5/tutorial_py_sift_intro.html)

5. A. Pieropan, M. Björkman, N. Bergström and D. Kragic, Feature Descriptors for Tracking by Detection: a Benchmark, Jul 2016, [online](https://arxiv.org/pdf/1607.06178.pdf)

6. S. Leutenegger, M. Chli and R. Siegwart, "Brisk: Binary robust invariant scalable keypoints", Proc. Int. Conf. Computer Vision, pp. 2548-2555, 2011.

7. Bay, H., Ess, A., Tuytelaars, T., Gool, L.V.: Surf: Speeded Up Robust Features. Computer Vision and Image Understanding 10, 346–359 (2008)

8. [OPENCV -- Introduction to SURF (Speeded-Up Robust Features)](https://docs.opencv.org/3.4/df/dd2/tutorial_py_surf_intro.html)

9. Ethan Rublee, Vincent Rabaud, Kurt Konolige, Gary R. Bradski: ORB: An efficient alternative to SIFT or SURF. ICCV 2011: 2564-2571.

10. Edward Rosten and Tom Drummond, “Machine learning for high speed corner detection” in 9th European Conference on Computer Vision, vol. 1, 2006, pp. 430–443.

11. Michael Calonder, Vincent Lepetit, Christoph Strecha, and Pascal Fua, "BRIEF: Binary Robust Independent Elementary Features", 11th European Conference on Computer Vision (ECCV), Heraklion, Crete. LNCS Springer, September 2010.

12. [OPENCV -- ORB (Oriented FAST and Rotated BRIEF)](https://docs.opencv.org/3.4/d1/d89/tutorial_py_orb.html)

13. KAZE Features. Pablo F. Alcantarilla, Adrien Bartoli and Andrew J. Davison. In European Conference on Computer Vision (ECCV), Fiorenze, Italy, October 2012. bibtex

14. Fast Explicit Diffusion for Accelerated Features in Nonlinear Scale Spaces. Pablo F. Alcantarilla, Jesús Nuevo and Adrien Bartoli. In British Machine Vision Conference (BMVC), Bristol, UK, September 2013. bibtex

https://arxiv.org/ftp/arxiv/papers/1710/1710.02726.pdf

# how to run the project

This project use opencv 4.4.0 version with opencv_contrib 4.4.0 version.

