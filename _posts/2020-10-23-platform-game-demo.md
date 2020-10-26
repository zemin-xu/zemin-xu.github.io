---
layout: post
author: zemin 
category: Unity 
demo: true
demo_link: platform_game.mp4 
---
# Platform Game

## Character

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/platform/character.png ""){:width="100%"}

## Animation

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/platform/mixamo.png ""){:width="100%"}

## Animator

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/platform/animator.png ""){:width="100%"}

## UI

![Alt text](https://raw.githubusercontent.com/zemin-xu/zemin-xu.github.io/master/assets/images/platform/ui.png ""){:width="100%"}

## ChangeColorBlock script

``` c#
 private IEnumerator ChangeColor()
    {
        while (true)
        {
            int color = Random.Range(0, 8);

            ResetBloc();
            switch (color)
            {
                case 0:
                    renderer.material.color = Color.red;
                    Danger();
                    break;

                case 1:
                case 2:
                case 3:
                    renderer.material.color = Color.green;
                    break;

                case 4:
                case 5:
                case 6:
                case 7:
                    renderer.material.color = Color.yellow;
                    break;
            }

            float t = Random.Range(minTime, maxTime);
            yield return new WaitForSeconds(t);
        }
    }
```

