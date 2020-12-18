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

In classic reinforcement learning, we use a table for agent to note the value (V value or Q value) for a pair of state and action. The tabular method is not useful for this problem because the input is not discrete. When the agent explore it, the value will be updated at the cell. In DRL, the value function will be replaced by a neural network. To specify, the V Neural Network will take a **state vector** as input, while the Q Neural Network will take a **state-action vector** as input.

## Problem statement

For this lab, we use the **Cart Pole** problem as demonstration. The black part is the cart which we can move left or right. We should keep the straight not fallen while moving. In order to describe the state, we have 4 numbers: the position and speed for the cart and pole. For Action Space, we have 2 actions: left and right.

&nbsp;

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/rl/cart_pole.png " "){:width="100%"}

&nbsp;

## Code

The [implementation notebook](https://colab.research.google.com/drive/1mc5tdDF5WkBYcp_LP0JWEyAryXH9tdDS?usp=sharing) will be worked on Google Colab, with running on GPU. The environment is simulated by using *gym* package. The detail can be found [here](https://gym.openai.com/envs/CartPole-v1/).

### QNetwork

The **QNetwork** class defines the Q-value function network with the constructor taking stateSpace, actionSpace, width of network and dropoutRate of neural network as inputs.

```python
class QNetwork(torch.nn.Module):
    def __init__(self, stateSpace, actionSpace, width=64, dropoutRate=0.5):
```

It also defines function Q which will return the Q-value of a specific action, or all values for all possible actions.

### Doer

The **Doer** class defines how agent acts. The constructor will take the model, stateSpace, actionSpace and epsilon as parameters. The epsilon is the probability of doing random exploration. For example here epsilon=0.1, about 10% of time the agent will explore by acting randomly, and for other time it will evaluate the collected data to find optimal action.

### Experience Replay

Briefly speaking, **experience replay** is to record how an agent behaves in a buffer and later evaluate with the data. One of the advantage of it is that we can use efficiently the previous experience, which is useful when the experience gaining is expensive or hard.

## Key parameters
activation function


## ER
Replay dataset. Record play and store buffer, learn from it.



# References
