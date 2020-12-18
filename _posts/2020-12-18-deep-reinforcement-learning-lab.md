---
layout: post
author: zemin 
category: AI
demo: false 
---
# Deep Reinforcement Learning Lab

This lab is about using DRL to solve the CartPole problem (continuous input, discrete actions) using methods inspired by DQN. The implementation code is provided by professor. By running it and changing parameters, we can learn more about the meaning of the key parameters and DRL.

&nbsp;

Before doing this lab, I make an [introductory post](https://zeminxu.me/ai/2020/12/18/basics-of-reinforcement-learning.html) on the keywords related to **Reinforcement Learning**.

## Deep Network

In classic reinforcement learning, we use a table for agent to note the value (V value or Q value) for a pair of state and action. When the agent explore it, the value will be updated at the cell. In DRL, the value function will be replaced by a neural network. To specify, the V Neural Network will take a **state vector** as input, while the Q Neural Network will take a **state-action vector** as input.

## Problem statement

For this lab, we use the **Cart Pole** problem as demonstration. The black part is the cart which we can move left or right. We should keep the straight not fallen while moving. In order to describe the state, we have 4 numbers: the position and speed for the cart and pole. For Action Space, we have 2 actions: left and right.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rl/cart_pole.png " "){:width="100%"}

&nbsp;

## ER
Replay dataset. Record play and store buffer, learn from it.



# References
