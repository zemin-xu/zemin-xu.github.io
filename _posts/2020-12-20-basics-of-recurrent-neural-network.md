---
layout: post
author: zemin 
category: AI
demo: false 
---

# Basics of Recurrent Neural Network

Recurrent neural network is a type of network architecture that accepts variable inputs and variable outputs[1].
In this post I will talk about the fundamental concepts of RNN and its variations like LSTM.

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

In real life we will meet some other modeling problem which are more difficult for FFNN. We can conclude them as four types with the graph below.

&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rnn/different_types.png " "){:width="100%"}
###### [different types of problems](https://calvinfeng.gitbook.io/machine-learning-notebook/supervised-learning/recurrent-neural-network/recurrent_neural_networks#:~:text=Recurrent%20neural%20network%20is%20a,vanilla%20feed%2Dforward%20neural%20networks.)
&nbsp;


&nbsp;
![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rnn/rnn_graph.png " "){:width="100%"}
###### https://calvinfeng.gitbook.io/machine-learning-notebook/supervised-learning/recurrent-neural-network/recurrent_neural_networks#:~:text=Recurrent%20neural%20network%20is%20a,vanilla%20feed%2Dforward%20neural%20networks.
&nbsp;





## Vanilla Recurrent Neural Network (RNN)


## RNN cell architectures
## RNN applications
## Attention in RNN

# References

[1].[Vanilla Recurrent Neural Network](https://calvinfeng.gitbook.io/machine-learning-notebook/supervised-learning/recurrent-neural-network/recurrent_neural_networks#:~:text=Recurrent%20neural%20network%20is%20a,vanilla%20feed%2Dforward%20neural%20networks.)