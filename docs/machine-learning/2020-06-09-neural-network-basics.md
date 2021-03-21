---
layout: post
author: zemin 
category: Deep Learning
demo: false 
---

Under construction.

# Introduction

This post is my notes of series released by [3Blue1Brown](https://www.3blue1brown.com) on neural network and machine learning. In this series, he used an example of how computer recognizes hand written digits from 0 to 9 by constructing its own neural network. This example is firstly described in [Neural Networks and Deep Learning](http://neuralnetworksanddeeplearning.com) by Michael Nielsen.

## Neuron model

The *neuron* is the smallest element and that the value in a neuron is called its *activation*. Activation of a neuron in different layer can have different meanings. For example, in the first layer, the activation means the graysacle of where the neuron is. In the last layer, it means the probalibity of a certain digit, for this exercise.



<img src="{{ site.url_imgs }}/neuron_network_activation_first_layer.png "neuron at first layer"){:width="100%"}
<img src="{{ site.url_imgs }}/neuron_network_activation_last_layer.png "neuron at last layer"){:width="100%"}

### Perceptron

*Perceptron* is a type of artificial neuron developed by the scientist Frank Rosenblatt.

A perceptron takes several binary inputs and produces a single binary output. The output is determined by whether the weighted sum is less than or greater than some threshold value. I use an daily example by Michael Nielsen to illustrate it.

> Suppose the weekend is coming up, and you've heard that there's going to be a cheese festival in your city. You like cheese, and are trying to decide whether or not to go to the festival. You might make your decision by weighing up three factors:

1. Is the weather good ?
2. Does your boyfriend or girlfriend want to accompany you?
3. Is the festival near public transit? (You don't own a car).

### Sigmoid Neuron

*Sigmoid neuron* takes the float value from 0 and 1. When changing weight of some neuron, the effect will be continuous rather than be sharp with perceptron. In the video, the model uses sigmoid neuron. The word *sigmoid* here represents *sigmoid function*, which will convert any value to a range from 0 to 1.

<img src="{{ site.url_imgs }}/neuron_network_sigmoid_function.png "sigmoid function"){:width="100%"}

### difference between them

The biggest difference between a *sigmoid* neuron and a *percetron* is that the former takes a float value from 0 and 1 while that latter one takes only two integer -- 0 and 1. Here I will explain the aim of such a model.

We can imagine that percetron uses a step function when comparing to sigmoid neuron. The conversion graph is a smooth curve, not a sharp angle in step function. Therefore, a small change in weight result in a different small change in activation. By calulating the derivative of change, we can know how much they react to the change repectively.

## Layer

*Layer* is the component of model. The model consists of an input layer, an output layer and several hidden layers. A layer consist of numerous neurons and the process of parsing previous layer to construct current layer reprensent how we treat the data. The solution in this video is using the different visual components in a number to know whether it corresponds. For example, a _9_ can be represented using a upper top and a line on the right. Recognizing a visual part can also be seperated by several sub-components which consist of the following layers. A layer here can be a group of neurons containing the info whether a visual component is activated and how much it is.

## Weight and bias

From the second layer, we will connect an neuron with each of those in the previous layer, and we assign a different weight for each. For a neuron in the second layer, the *weight* here represents the influence of the value in such neuron of first layer to itself. The value useful is the sum of product of each activation with its weight. The *sigmoid* function is used when converting this sum into a range of 0 and 1.

The sum of the product of *activation* with its respective *weight*, will be adjusted by adding a *bias*. We can think of *bias* as a mesure of difficulty of firing the neuron in next layer.

## Cost

The sum of squares of difference of the activation of an neuron and the result it should be. When computer behaves well, the cost should be quite small.
<img src="{{ site.url_imgs }}/neuron_network_activation_cost.png "a pretty correct training cost"){:width="100%"}

## Neural Network models

### Feedforward Neural Network

The output from one layer is used as input to the next layer.

### Reccurent Neural Network

> The idea is to have neurons which fire for some limited duration of time, before becoming quiescent. That firing can stimulate other neurons, which may fire a little while later, also for a limited duration. That causes still more neurons to fire, and so over time we get a cascade of neurons firing. Loops don't cause problems in such a model, since a neuron's output only affects its input at some later time, not instantaneously.


## Gradient descent

**Gradient**, the direction of steepest increase. **Gradient descent** is the process of repeatedly nudging an input of a function by some multiple negative gradient.

## Backpropagation

