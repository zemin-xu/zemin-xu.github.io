---
layout: post
author: zemin 
category: AI
demo: false 
---

# Basics of Recurrent Neural Network

Recurrent neural network is a type of network architecture that accepts variable inputs and variable outputs[1].
In this post I will talk about the fundamental concepts of RNN and its variations like LSTM. This post is my note after course given by Hugo DURCHON in Telecom-SudParis, at ARTEMIS research group. Some of the graphs in this post are from his presentation.

## Sequence

Sequential data is everywhere, such as music, video. For definition, a sequence is an enumerated and ordered collection of objects in which repetitions are allowed. The order is crucial for a sequence. In other words, a specific order of elements leads to a specific result.

## FeedForward Neural Network

A FeedForward Neural Network involves the neurons whose connections do not form a cycle. Typically FFNN accepts a fixed-size input and give an output. Multi Layer Perceptron is an example of type FFNN.

&nbsp;

A natural question is that: can we try to build a FFNN to complete a classification task over a sequence? Let us think about a concrete problem: sentiment analysis. The input should be a sentence and the output should be a classification among positiveness and negativeness.

&nbsp;

The first issue that FFNN encounters is the length of input. FFNN requires that the input has the same size, while a sentence can be with different size of words. Even if we make a dictionary of all the positive or negative words and use this one-word to do classification, the result will not be optimal. As we know, we cannot isolate a word from its context. Take an example: "In spite of minor flaws a movie you won’t want to miss". We, as humans, can know that it is still a good movie. However, the word *flow* will make this model go into a wrong classification.

&nbsp;

Even though we take a several-words size window, we will lose the generalization of this model. Therefore, FFNN is not a good choice for sequence.

&nbsp;

## Sequence Modeling Problems

In real life we will meet some other modeling problem which are more difficult for FFNN. We can conclude them as four types with the graph below, according to the variables of input and output. For each of the models, we can find a corresponding case in real life. For example, **image captioning** is the case for **one-to-many** model. 

&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rnn/different_types.png " "){:width="100%"}
###### [different types of problems](https://calvinfeng.gitbook.io/machine-learning-notebook/supervised-learning/recurrent-neural-network/recurrent_neural_networks#:~:text=Recurrent%20neural%20network%20is%20a,vanilla%20feed%2Dforward%20neural%20networks.)
&nbsp;

## Vanilla Recurrent Neural Network

&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rnn/rnn_graph.png " "){:width="100%"}
###### [vanilla RNN](https://towardsdatascience.com/introduction-to-recurrent-neural-network-27202c3945f3)
&nbsp;

The graph above is an abstract representation of vanilla RNN. The formula is as below:

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rnn/rnn_formula.png " "){:width="100%"}

&nbsp;

Two notes are important there. First, the hidden layer called RNN cell has several cell state, denoted by h, and the current cell state depends on the last cell state and the input at that current time step. In other words, the hidden layer involves a loop whose current input are last output and current time step.

&nbsp;

Second, the function and its parameters remain the same at every time step.

&nbsp;

We can view its unfolded presentation in which the function is tanh, to better understand how the data is processed.

### Vanishing Gradients and Exploding Gradients

As we know, the way in CNN to update the weights is back propagation. Back propagation is a way to use gradient descent to update the weights, so that the loss can go down. In RNN we use a method called **back propagation through time** which will multiply the same factor when computing gradients. If this factor is smaller than 1, the value will come to 0; if greater than 1, this value will become big. That's why vanilla RNN cannot preserve long-term dependencies and why it is not considered in real problem.

&nbsp;

## LSTM

**Long Short Term Memory** is special kind of RNN, which is capable of learning long-term dependencies. They have the same chain-like structure like vanilla RNN and it is to change the way RNN cells managing information and gradient flow to avoid vanishing gradient problem.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rnn/lstm_structure.png " "){:width="100%"}
###### [LSTM structure](https://colah.github.io/posts/2015-08-Understanding-LSTMs/)

&nbsp;

The additional elements in LSTM, compared to vanilla RNN, are four gates and the core cell state. This cell state, as shown on the graph below, is designed to fight vanishing gradient problem and to track long-term dependencies like the **memory**. The hidden state that is used to make decision over short-term infomation is the same as in vanilla RNN.

&nbsp;

The four yellow rectangles are the four gates to filter information for the cell state. They are:

#### Forget gate

to decide what information should we forget or keep from previous states

#### Input gate

to control which values will be written to current cell

#### Input modulation gate

to decide how much to write to current cell, which can be considered as a sub-gate of input gate 

#### Output gate

to control the Output to cell state

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rnn/lstm_cell.png " "){:width="100%"}
###### [LSTM structure](https://colah.github.io/posts/2015-08-Understanding-LSTMs/)

&nbsp;

## RNN applications
## Attention in RNN

# References

[1].[Vanilla Recurrent Neural Network](https://calvinfeng.gitbook.io/machine-learning-notebook/supervised-learning/recurrent-neural-network/recurrent_neural_networks#:~:text=Recurrent%20neural%20network%20is%20a,vanilla%20feed%2Dforward%20neural%20networks.)
[2].[introduction to RNN](https://towardsdatascience.com/introduction-to-recurrent-neural-network-27202c3945f3)
[3].[LSTM introduction](https://colah.github.io/posts/2015-08-Understanding-LSTMs/)
