---
layout: default
title: Home
nav_order: 0
permalink: /
---

<button class="btn js-toggle-dark-mode">dark mode</button>

<script>
const toggleDarkMode = document.querySelector('.js-toggle-dark-mode');

jtd.addEvent(toggleDarkMode, 'click', function(){
  if (jtd.getTheme() === 'dark') {
    jtd.setTheme('light');
    toggleDarkMode.textContent = 'Preview dark color scheme';
  } else {
    jtd.setTheme('dark');
    toggleDarkMode.textContent = 'Return to the light side';
  }
});
</script>

# Introduction

Hello, my name’s Zemin. Here you can find projects I participated related to VR, AR and interactive experience.
