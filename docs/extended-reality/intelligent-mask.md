---
layout: default 
parent: Extended Reality
title: Intelligent Mask -- Augmented Reality
---

# {{ page.title }}

Track and animate a user's facial expression in real-time using **ARKit**, use emotion detection model to detect his or her emotion using **Vision** framework, and apply the result to switch to one of the animal masks that adapts to this emotion.

## Detect Human Face
{: .fs-6 .fw-300 }

---

## Introduction 

The current augmented reality apps mainly focus on overlapping virtual objects onto physical world. The raw data like face and world tracking is directly used as the input of such pipeline. It might be interesting that we can preprocess the data with machine learning and use their result to influence the augmented effect.

In this project, my main point is to fuse the AR and AI part within Apple's developing environment. It is divided into two parts: face tracking and emotion prediction with Vision framework. A pretrained model will be used and converted into CoreML model that Vision framework can use.

## Face Tracking


ARKit is a framework that handles the processes of creating augmented reality experience including world tracking and establishing a correspondence between the real-world space and the virtual space. In other words, it should coordinate with another virtual content framework like RealityKit, SceneKit or MetalKit. In this project, I use SceneKit and Storyboard as UI template.

### ARKit Configuration

**ViewController.swift** will handle most of the work including arkit session and scenekit management. To enable face tracking feature, some configuration option should be activated. Of course we should check if the feature is supported firstly. **ARKit** is a session-based framework. The *session* inside the code is the arkit session instance inside SceneKit object *sceneView*.

```swift
guard ARFaceTrackingConfiguration.isSupported else {
            print(" Face Tracking Not Supported ! ")
            return
}
let config = ARFaceTrackingConfiguration()
config.isLightEstimationEnabled = true
config.providesAudioData = false
sceneView.session.run(config, options: [.resetTracking, .removeExistingAnchors])
```

### View Management

We can use some pre-defined functions to manage view in SceneKit, such as **viewDidLoad** and **viewWillDisappear**. All the initialization tasks can be placed inside **viewDidLoad** function. At this stage, we can initialize a scene object and assign to local property.

```swift
let scene = SCNScene()
sceneView.scene = scene
```

### ARFaceAnchor to SCNNode

Like in **Unity** that every object is a *GameObject*, in **SceneKit** every object is a node. ARKit will create an ARFaceAnchor object that specifying the transform of detected face. The task here is to register it in local property whenever a face anchor is found. A pre-defined delegate function called **renderer** can be use here.

```swift
// local property
var anchorNode: SCNNode?

// this func get called for each anchor added to the scene
// pass in as value of anchorNode property
func renderer(_ renderer: SCNSceneRenderer, didAdd node: SCNNode, for anchor: ARAnchor) {
    anchorNode = node
}
```

### Mask Geometry Creation

## Model Conversion

## Conclusion

## References


