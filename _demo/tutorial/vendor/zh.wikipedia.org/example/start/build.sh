#!/usr/bin/env bash

gcc -o app main.c $(pkg-config --cflags --libs sdl2)

#gcc -o app main.c $(sdl2-config --cflags --libs)
