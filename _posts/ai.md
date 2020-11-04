# artificial neural networks

## intro

### application

- satellite image analysis
- speech and writing pattern calssification
- face recognition with computer vision
- stock forecasting
- etc

## biological inspiration
neurons(10^11) with connection

35mV and -70mV, duration time variable

binary operation

## artificial neuron

non linear

input signals: w0x0
synaptic weights: w0, w1, w2
linear aggregator
activation threshold or bias
activation potential
activation function:f(sum of wix1 + b)
output signals

### activation functions

without activation func, the weight and bias would only have a linear transformation
activation func make it non-linear and be able to solve complex problem

Binary step function(Heaviside/ Hard limiter)

linear function: f(u) = u

logistic function(sigmoid or soft step)
f(u) = 1 / (1 + e^(-u))

Hyperbolic tangent function
tanh(u) = (2 / (1 + e^[-2u])) - 1

ReLU(Rectified Linear Unit)
f(u) = {u, if u > 0; 0, if u <= 0}

Leaky ReLU
f(u) = max(0.1u, u)

exponential Linear Units(ELUs)

softmax activation function

### network architectures

each input will have a seperate weight for each neuron

the inputs are called also the input layers

### perceptron learning rule
able to modify the weight and bias
a = hardlim(Wp + b)
n = sum of (w*p) + b = 0

single neuron-perceptron
AND gate

1. choose a weight vector that is orthogonal to the decision boundary
2. compute the bias b, by picking a point on the decision boundary

for perceptrons with multiple neurons, there will be one decision boundary for each neuron

### training a single neuron-perceptron
ANN training => supervised learning
learning rule adjust the weights and biases of network

1. initialize with random value



### backpropagation
XOR operation and AND operation
backpropagation, current a is influenced by last output a
to quantify the quality , use a cost function

Ramdom search
Random local search
follow gradient

