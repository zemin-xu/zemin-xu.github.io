---
layout: post
author: zemin 
category: Python 
demo: false 
---

Under construction.

# Introduction

In order to learn computer vision, Python in an unevitable tool. I will post here some common functions used in the source code that I have seen, and most of the description comes from the official documentation including [built-in functions](https://docs.python.org/3/library/functions.html) and [functions in numpy](). Most of examples come from [Programiz](https://www.programiz.com/python-programming/methods).

## Build-in functions

### zip

Make an iterator that aggregates elements from each of the iterables.

Returns an iterator of tuples, where the i-th tuple contains the i-th element from each of the argument sequences or iterables. The iterator stops when the shortest input iterable is exhausted. With a single iterable argument, it returns an iterator of 1-tuples. With no arguments, it returns an empty iterator.

#### syntax : zip(*iterables)

&nbsp;

```python
number_list = [1, 2, 3]
str_list = ['one', 'two', 'three']

# No iterables are passed, returns an empty iterator
result = zip()

# Converting itertor to list
result_list = list(result)
print(result_list)

# Two iterables are passed
result = zip(number_list, str_list)

# Converting itertor to set
result_set = set(result)
print(result_set)

""" output
[]
{(2, 'two'), (1, 'one'), (3, 'three')}
"""
```
