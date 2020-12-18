---
layout: post
author: zemin 
category: AI
demo: false 
---

# Basics of Reinforcement Learning

Compared to supervised learning with features and label, reinforcement learning is an approach unsupervised based on that it does not rely on a set of labelled training data. However, we still want to guide the model by maximizing the reward. In this sense, it is not exactly unsupervised. It is the way resembling how human learns things. For example, when touching the fire, the hurt (negative reward) will make us learn not touch fire. In this post I will explain some fundamental concepts of reinforcement learning.

## Markov Decision Process

> Markov Decision Process is a formulation of sequential interaction between agent and environment.[1]

Before talking about MDP, we need to know some terms.

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


# References

[Markov Decision Process](https://towardsdatascience.com/the-fundamentals-of-reinforcement-learning-177dd8626042)