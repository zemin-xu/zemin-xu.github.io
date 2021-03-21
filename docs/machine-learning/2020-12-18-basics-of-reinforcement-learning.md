---
layout: default 
title: Basics of Reinforcement Learning
parent: Machine Learning
demo: false 
---

# Basics of Reinforcement Learning

Compared to supervised learning with features and label, reinforcement learning is an approach unsupervised based on that it does not rely on a set of labelled training data. However, we still want to guide the model by maximizing the reward. In this sense, it is not exactly unsupervised. It is the way resembling how human learns things. For example, when touching the fire, the hurt (negative reward) will make us learn not touch fire. In this post I will explain some fundamental concepts of reinforcement learning. This post is my note after course given by Nicolas HOFFMANN in Telecom-SudParis, at ARTEMIS research group.

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



## Markov Decision Process

### Markov Process

Imagine that we have a system that we can observe, all the states form a **state space**. If this space is finite, we can call this sequence of states as a **Markov Chain**. Several chains forms **history**. In order that the system to be a **Markov Process**, it should satisfy **Markov Property**, which states that *the future system dynamic from any state have to depend only on that state*[2]. Let us take an example to clarify it. The weather of each day in a city form a system. If today's sunny weather will not influence the probability of raining weather of tomorrow, then we can regard it as a Markov Process.

### Markov Reward Process

In this context, if we go from transition *i* to transition *j*, we can have a reward to specify its effect to achieve to goal. In this case, we can have a matrix in which each cell(*i*, *j*) represents a reward.

### Discounted Rate

At this stage, we may think about how to express the influence of an action at a certain state for the whole system. We may doubt: perhaps what we behave at the beginning will not influence the result. It is reasonable. We need to find a way to differ the weights of each transition. So we have the **discounted rate** denoted as *γ*. As in this post[2] said, "the discount represent the **foresightedness** of the agent.



<img src="{{ site.url_imgs }}/rl/cumulative_reward_equation.png " class=".mx-auto" style="width: 100%">

## Policy

Now that we know the goal of agent is to maximize the cumulative reward, the next problematic is the action to choose in a given state, in order to have a high reward. We will have another term called **policy** denoted as *π*. *π* can be interpreted as the strategy that that agent takes. A good policy will yield high reward, which a bad policy will not. We denote π* as the policy that maximize the reward. It is also called optimal policy.

## Value Function

For every state *s*, the value function Vπ(s) quantifies the amount of reward an agent is expected to receive starting in *s* and following *π*. In other words, it is the expected return if we start at this state and act according to this policy forever after[4]. We can see that Value Function(V-Function) here evaluates the value of each state. In order to do so, we need to have a model of environment.

## Q-Function

Different from value function, the Q-Function evaluates the effectiveness of each action. Compared to V-Function, Q-Function is used more because the actual environment is always complicated.

## On-Policy / Off-Policy

In order to learn, the agent need to explore to find new better policies, however, the learning is done when all the actions chosen are optimal. This is a dilemma. To treat it there are two solutions. The first one is to use a behavior policy to explore and improve the target policy, which is the one with optimal actions. This is called **Off-Policy**. **Q-Learning** is an algorithm that is of Off-Policy, in which the the behavior policy is different from target policy. Another solution is to improve the policy that the agent knows already. This is called **On-Policy**. **SARSA**, which stands for state-action-reward, state'-action', is of On-Policy, because the behavior policy and target policy are the same.

# References

[1].[Markov Decision Process](https://towardsdatascience.com/the-fundamentals-of-reinforcement-learning-177dd8626042)
[2].[Markov Process & Markov Property Introduction](https://towardsdatascience.com/the-fundamentals-of-reinforcement-learning-177dd8626042)
[3].[Discounted cumulative expected reward equation](https://www.freecodecamp.org/news/an-introduction-to-reinforcement-learning-4339519de419/)
[4].[Value Function](https://spinningup.openai.com/en/latest/spinningup/rl_intro.html)