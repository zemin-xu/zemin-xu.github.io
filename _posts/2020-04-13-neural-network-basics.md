---
layout: post
author: zemin 
category: Deep Learning
demo: false 
---

Under construction.

# Introduction

This post is my notes of series released by [3Blue1Brown](https://www.3blue1brown.com) on neural network and machine learning. In this series, he used an example of how computer recognizes hand written digits from 0 to 9 by constructing its own neural network.

## Neuron & Activation

The *neuron* is the smallest element and that the number in a neuron is called its activation. Activation of a neuron in different layer can have different meanings. For example, in the first layer, the activation means the graysacle of where the neuron is. In the last layer, it means the probalibity of a certain digit.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/neuron_network_activation_first_layer.png "neuron at first layer"){:width="100%"}
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/neuron_network_activation_last_layer.png "neuron at last layer"){:width="100%"}

## Layer

According to the system, there may be different solutions of analysing a model from an input to an output, and *layer* here means the component of one solution. For example, the solution is using the different components in a number to know whether it corresponds. For example, a _9_ can be represented using a upper top and a line on the right. Recognizing a visual part can also be seperated by several sub-components which consist of the following layers.

## Weight

From the second layer, we will connect it with each of the previous layer, and we assign a weight for each of them. For a neuron in the second layer, the *weight* here represents the influence of the value in such neuron of first layer to itself. The value useful is the sum of product of each activation with its weight. The *sigmoid* function is used when converting this sum into a range of 0 and 1.

## Cost

The sum of squares of difference of the activation of an neuron and the result it should be. When computer behaves well, the cost should be quite small.
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/neuron_network_activation_cost.png "a pretty correct training cost"){:width="100%"}

## Gradient descent

**Gradient**, the direction of steepest increase. **Gradient descent** is the process of repeatedly nudging an input of a function by some multiple negative gradient.

[Neural Networks and Deep Learning](http://neuralnetworksanddeeplearning.com)