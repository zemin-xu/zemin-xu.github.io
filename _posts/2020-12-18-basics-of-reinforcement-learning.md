---
layout: post
author: zemin 
category: AI
demo: false 
---

# Basics of Reinforcement Learning

Compared to supervised learning with features and label, reinforcement learning is an approach unsupervised based on that it does not rely on a set of labelled training data. However, we still want to guide the model by maximizing the reward. In this sense, it is not exactly unsupervised. It is the way resembling how human learns things. For example, when touching the fire, the hurt (negative reward) will make us learn not touch fire. In this post I will explain some fundamental concepts of reinforcement learning.


##### Environment

Environment is the world that an agent interact with.

##### Agent

Agent is the learner here who make decision/action.

##### State(St)

Whenever the agent do an action, the environment will respond with a new situation, also called as **state**. State can be detailed with the information of agent the the relationship to the environment. For example, in a maze game, the state can be summarized with the 2D position of agent.

##### Transition

The behavior of agent will cause the change of state. In order to specify this change, we can use **transition**. In the last example, the transition can be the movement of agent.

##### Action(At)

Action is the behavior of agent in the environment.

##### Reward(Rt)

Imagine that at the beginning of an experience, we(the trainer) have a goal for the agent to achieve. In order to communicate this goal to agent, we use a **reward**. Normally by maximizing the reward, the agent can get closer to the goal.

&nbsp;

## Markov Decision Process

### Markov Process
Imagine that we have a system that we can observe, all the states form a **state space**. If this space is finite, we can call this sequence of states as a **Markov Chain**. Several chains forms **history**. In order that the system to be a **Markov Process**, it should satisfy **Markov Property**, which states that *the future system dynamic from any state have to depend only on that state*[2].

In this context, all the states form a **state space** 

# References

[1].[Markov Decision Process](https://towardsdatascience.com/the-fundamentals-of-reinforcement-learning-177dd8626042)
[2].[Markov Process & Markov Property Introduction](https://towardsdatascience.com/the-fundamentals-of-reinforcement-learning-177dd8626042)